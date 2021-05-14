const TelegramBot = require('node-telegram-bot-api');//connect bot
const http = require('http');
const https = require('https');
const fs = require('fs');
const TOKEN = 'TOKENBOT_HERE'
console.log('Bot has been started')
const bot = new TelegramBot(TOKEN, {
polling: true
})
//take voice message
bot.on('voice', (msg)=>{
//console.log(msg)
bot.on("polling_error", console.log);
file_id = msg.voice.file_id;
link = "https://api.telegram.org/bot"+TOKEN+"/getFile?file_id=" + file_id;
//console.log(link);
const request = require('request');
//download voice message
request("https://api.telegram.org/bot"+TOKEN+"/getFile?file_id=" + file_id, { json: true }, (err, res, body) => {
if (err) { return console.log(err); }
//console.log(body.result.file_path);
full = "https://api.telegram.org/file/bot"+TOKEN+"/" + body.result.file_path;
//console.log (full);
const file = fs.createWriteStream("file.ogg");
const request = https.get(full, function(response) {
response.pipe(file)
var runner = require("child_process");
var phpScriptPath = "far.php";
runner.exec("php " + phpScriptPath, function(err, phpResponse, stderr) {
 if(err) console.log(err); /* log error */
 const chatId = msg.chat.id;
bot.sendMessage(chatId, phpResponse );
console.log(phpResponse);
console.log(phpScriptPath);
})
})
})
});
//message output
