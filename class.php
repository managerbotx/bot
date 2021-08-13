<?php
/*
کانال ایرو سورس مرجع سورس و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/
error_reporting(0);
define('API_KEY', "1816669750:AAFvN9Kdq9qjO-SBZUmudbhvPOKls47NWQQ"); //محل گذاشتن توکن ربات
/* Functions */
function Bot($m, $d=[])
{
   $ch = curl_init('https://api.telegram.org/bot'.API_KEY.'/'.$m);
   curl_setopt_array($ch, [
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $d
   ]);
       return json_decode(curl_exec($ch),true);
}
function SendMessage($chat_id, $text, $parse, $message_id, $keyboard=null)
{
   Bot('SendMessage',[
   'chat_id'=> $chat_id,
   'text'=> $text,
   'parse_mode'=> $parse,
   'reply_to_message_id'=> $message_id,
   'reply_markup'=> $keyboard
   ]);
}
function forwardMessage($chat_id, $from, $message_id)
{
    Bot('forwardMessage',[
    'chat_id'=> $chat_id,
    'from_chat_id'=> $from,
    'message_id'=> $message_id
    ]);
}
function EditMessageText($chat_id, $text, $message_id, $keyboard=null)
{
   Bot('EditMessageText',[
   'chat_id'=> $chat_id,
   'text'=> $text,
   'message_id'=> $message_id,
   'reply_markup'=> $keyboard
   ]);
}
function SendAudio($chat_id, $audio, $caption, $parse, $message_id, $keyboard=null)
{
   Bot('SendAudio',[
   'chat_id'=> $chat_id,
   'audio'=> $audio,
   'caption'=> $caption,
   'parse_mode'=> $parse,
   'reply_to_message_id'=> $message_id,
   'reply_markup'=> $keyboard
   ]);
}
function SendPhoto($chat_id, $photo, $caption, $parse, $message_id, $keyboard=null)
{
   Bot('SendPhoto',[
   'chat_id'=> $chat_id,
   'photo'=> $photo,
   'caption'=> $caption,
   'parse_mode'=> $parse,
   'reply_to_message_id'=> $message_id,
   'reply_markup'=> $keyboard
   ]);
}
function answerCallbackQuery($callback_query_id,$text,$show_alert)
{
    Bot('answerCallbackQuery', [
        'callback_query_id' => $callback_query_id,
        'text' => $text,
        'show_alert' => $show_alert,
    ]);
}
function SendDocument($chat_id, $document, $caption, $parse, $message_id, $keyboard=null)
{
   Bot('SendDocument',[
   'chat_id'=> $chat_id,
   'document'=> $document,
   'caption'=> $caption,
   'parse_mode'=> $parse,
   'reply_to_message_id'=> $message_id,
   'reply_markup'=> $keyboard
   ]);
}
function SaveData($data, $from)
{
    $json_en = json_encode($data, 128|256);
    file_put_contents("user/$from.json", $json_en);
}
function sc($name,$about,$range,$lang,$photo,$document,$number,$msg_id)
{
    $data = [
    'name'=> $name,
    'about'=> $about,
    'range'=> $range,
    'lang'=> $lang,
    'photo'=> $photo,
    'document'=> $document,
    'key'=> $number,
    'message_id'=> $msg_id,
    'download'=> 0,
    'users'=> []
    ];
    $json_en = json_encode($data, 128|256);
    file_put_contents("Code/$number.json", $json_en);
}
function Save($data)
{
    global $user,$from_id;
    $user['step'] = $data;
    $json = json_encode($user, 128|256);
    file_put_contents("user/$from_id.json", $json);
}
function sp($index, $data)
{
    global $user,$from_id;
    $user[$index] = $data;
    $json = json_encode($user, 128|256);
    file_put_contents("user/$from_id.json", $json);
}
function is_admin()
{
    global $admin,$from_id;
    return in_array($from_id, $admin);
}
function is_vip($from){
    global $list;
    return in_array($from, $list['vip']);
}
/* Variables */
$update = json_decode(file_get_contents('php://input'),true);
$u = json_decode(file_get_contents('php://input'));
if(isset($u->message) || isset($u->edited_message))
    if(time()-(($u->message->date)?:($u->edited_message->edit_date))>3)
        exit;
if(isset($update['message']))
{
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $text = isset($message['text'])?$message['text']:null;
    $from_id = $message['from']['id'];
    $message_id = $message['message_id'];
    $username = $message['from']['username'];
    $first_name = $message['from']['first_name'];
    $rp = $message['reply_to_message']['forward_from']['id'];
}
if(isset($update['callback_query']))
{
    $call = $update['callback_query'];
    $chat_id = $call['message']['chat']['id'];
    $data = $call['data'];
    $callId = $call['id'];
    $from_id = $call['from']['id'];
    $message_id = $call['message']['message_id'];
    $username = $call['from']['username'];
    $first_name = $call['from']['first_name'];
}
//************************************/
if(!is_dir("user"))
{
   mkdir("user");
} if(!is_dir("Code"))
{
   mkdir("Code");
}
touch("user/number.txt");
//***********************************/
$Bot = "شهر کالاف دیوتی موبایل"; //
$bot = "CityCodMBot"; //یوزرنیم ربات
$channel = "CityCodM"; //یوزرنیم کانال
$lock = ""; //اگر میخواهید روی دو کانال قفل شود آیدی کانال دوم هم وارد شود در غیر این صورت خالی باشد
$admin = [1880686031]; //ایدی عددی ادمین ها
$logs = "logcitycodmbot"; //چنل گزارشات ربات ادمین شود
//***********************************/
$home = json_encode([
     'keyboard'=> [
     [['text'=> "👤حساب کاربری"]],
     [['text'=> "🚦پشتیبانی"],['text'=> "👥 زیرمجموعه گیری"],['text'=> "🎁 حساب ویژه"]]
   ],'resize_keyboard'=> true
]);
$panelVip = json_encode([
     'keyboard'=> [
     [['text'=> "💾 دریافت اکانت"],['text'=> "⏰ مشاهده اعتبار"],['text'=> "⬅️ برگشت"]]
   ],'resize_keyboard'=> true
]);
$panel = json_encode([
     'keyboard'=> [
     [['text'=> "📊 آمار"]],
     [['text'=> "🗑 حذف پست"],['text'=> "🗳 افزودن پست"]],
     [['text'=> "📑 لیست بلاک ها"]]
   ],'resize_keyboard'=> true
]);
$whois = json_encode([
     'keyboard'=> [
     [['text'=> "✅ بله"],['text'=> "☑️ خیر"]]
   ],'resize_keyboard'=> true
]);
$back = json_encode([
     'keyboard'=> [
     [['text'=> "⬅️ برگشت"]]
   ],'resize_keyboard'=> true
]);
$Back = json_encode([
     'keyboard'=> [
     [['text'=> "↩️ برگشت"]]
   ],'resize_keyboard'=> true
]);
$keyRemove = json_encode([
      'ReplyKeyboardRemove'=>[
       []
      ],'remove_keyboard'=> true
]);
//***********************************/
if(file_exists("user/$from_id.json"))
{
    $user = json_decode(file_get_contents("user/$from_id.json"),true);
}
$number = file_get_contents("user/number.txt");
$list = json_decode(file_get_contents("list.json"),true);
$vips = json_decode(file_get_contents("vip.json"),true);
$now = date("Y-m-d-h-i-sa");
$left = Bot('GetChatMember',['chat_id'=> '@'.$channel, 'user_id'=> $from_id])['result']['status'];
$left2 = Bot('GetChatMember',['chat_id'=> '@'.$lock, 'user_id'=> $from_id])['result']['status'];
/*
کانال ایرو سورس مرجع سورس و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/
