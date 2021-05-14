<?php

$token = 'YOUR IAM TOKEN'; # IAM-токен
$folderId = "indetifiers"; # Идентификатор каталога
$audioFileName = "file.ogg";

$file = fopen($audioFileName, 'rb');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Transfer-Encoding: chunked'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

curl_setopt($ch, CURLOPT_INFILE, $file);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($audioFileName));
$res = curl_exec($ch);
curl_close($ch);
$decodedResponse = json_decode($res, true);
if (isset($decodedResponse["result"])) {
    $word = $decodedResponse["result"];
} else {
    echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
    echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
}
//
fclose($file);
$dbconn = pg_connect("host=localhost dbname=writehereyournametable user=userdb password=password")//connect
or die('Не удалось соединиться: ' . pg_last_error());
$str = pg_escape_string($word);
$result2 = pg_query($dbconn, "SELECT * FROM documents WHERE name = '{$str}'");//comparison
$myrow2 = pg_fetch_assoc($result2);
$value2 = $myrow2[preview_path];
echo $value2;
pg_close($dbconn);
?>