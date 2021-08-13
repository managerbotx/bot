<?php
/*
کانال ایرو اکانت مرجع اکانت و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/
require 'class.php';
flush();
date_default_timezone_set('Asia/Tehran');
//------------------------------------------------------------------------------
if(in_array($from_id, $list['ban'])){
	exit();
}
//******************************//
$date = date('Ymd');
@$flood = json_decode(file_get_contents("flood.json"),true);
@$floods = $flood['flood']["$now-$from_id"];
@$flood['flood']["$now-$from_id"] = $floods+1;
@file_put_contents("flood.json",json_encode($flood));
@$flood = json_decode(file_get_contents("flood.json"),true);
@$floods = $flood['flood']["$now-$from_id"];

if($floods >= 4 and !in_array($from_id, $admin)){
    if($list['ban'] == null){
        $list['ban'] = [];
    }
    unlink("flood.json");
	array_push($list['ban'], $from_id);
	file_put_contents("list.json",json_encode($list));
	SendMessage($from_id,"■ شما به علت اسپم، از ربات مسدود شدید.", 'MarkDown', null);
	SendMessage($admin[0],"■ کاربر [$from_id](tg://user?id=$from_id) به علت اسپم از ربات مسدود گردید.", 'MarkDown', null);
}
//******************************//
if($text == '/start'){
  if(file_exists("user/$from_id.json")){
    SendMessage($chat_id, "🖐🏻 سلام به ربات $Bot خوش اومدی\n\n🆓 به راحتی اکانت های پولی را بصورت رایگان دریافت کنید\n\n🔗 این ربات برای ارسال اکانت  به کانال 《 @$channel 》 میباشد.\n\n👇🏻 از دکمه های زیر استفاده کنید", null, $message_id, $home);
 }else{
    SendMessage($chat_id, "🖐🏻 سلام به ربات $Bot خوش اومدی\n\n🆓 به راحتی اکانت های پولی را بصورت رایگان دریافت کنید\n\n🔗 این ربات برای ارسال اکانت  به کانال 《 @$channel 》 میباشد.\n\n👇🏻 از دکمه های زیر استفاده کنید", null, $message_id, $home);
    $data = ['step'=> "none", 'acc'=> "member", 'date'=> "", 'download'=> 0, 'name'=> "", 'photo'=> "", 'document'=> "", 'about'=> "", 'range'=> "", 'lang'=> ""];
    SaveData($data, $from_id);
  }
}
if(preg_match('/^\/start\s+ref_(\d+)/s',$text,$m)){
    $id = $m[1];
    if(file_exists("user/$from_id.json")){
        SendMessage($chat_id, "🖐🏻 سلام به ربات $Bot خوش اومدی\n\n🆓 به راحتی اکانت های پولی را بصورت رایگان دریافت کنید.\n\n🔗 این ربات برای ارسال اکانت  به کانال 《 @$channel 》 میباشد.\n\n👇🏻 از دکمه های زیر استفاده کنید", null, $message_id, $home);
    }else{
        SendMessage($chat_id, "🖐🏻 سلام به ربات $Bot خوش اومدی\n\n🆓 به راحتی اکانت های پولی را بصورت رایگان دریافت کنید.\n\n🔗 این ربات برای ارسال اکانت  به کانال 《 @$channel 》 میباشد.\n\n👇🏻 از دکمه های زیر استفاده کنید $id", null, $message_id, $home);
        SendMessage($id, "📣 خبر : کاربر $from_id با لینک شما وارد شما شد و 1 نفر دیگر به زیر مجموعه های شما اضافه شد", null, null);
        $u = json_decode(file_get_contents("user/$id.json"),true);
        $u['refer'] = $u['refer'] +1;
        file_put_contents("user/$id.json", json_encode($u,128|256));
        $data = ['step'=> "none", 'acc'=> "member", 'date'=> "", 'download'=> 0, 'name'=> "", 'photo'=> "", 'document'=> "", 'about'=> "", 'range'=> "", 'lang'=> ""];
        SaveData($data, $from_id);
        if($u['refer'] >= 20){
            SendMessage($id, "⏳ حساب شما به مدت 30 روز تمدید شد. لطفا تا اتمام مهلت بسته خود ممبرگیری نکنید چون چیزی به حساب شما اضافه نمیشود.", null, null);
            SendMessage('@'.$logs, "✅ کاربر $id به مدت 30 روز ویژه شد", null, null);
            $ago = date('Y-m-d', strtotime("+30 day"));
            $u['date'] = $ago."%".date('H:i:s');
            $u['acc'] = "vip";
            $u['refer'] = 0;
            file_put_contents("user/$id.json", json_encode($u,128|256));
        }
  }
}
elseif($left == "left"){
    SendMessage($chat_id, "☑️ برای استفاده از ربات « $Bot » ابتدا باید وارد کانال شوید\n❗️ برای دریافت اکانت ها ، اطلاعیه ها و گزارشات شما باید عضو کانال های ربات شوید\n\n📣 @$channel\n📣 @$lock\n\n👈🏻 بعد مجدد 《 /start 》 را بزنید", "html", $message_id, $keyRemove);
}
elseif($left2 == "left"){
    SendMessage($chat_id,"☑️ هنوز در کانال دوم ما عضو نشده اید \n\n📣 @$lock\n\nبعد از عضویت مجدد /start را بزنید", "html", $message_id, $keyRemove);
}

elseif(preg_match('/^\/start\s+(\d+)/i',$text, $match)){
  if(!file_exists("user/$from_id.json")){
     $data = ['step'=> "none", 'acc'=> "member", 'date'=> "", 'download'=> 0, 'name'=> "", 'photo'=> "", 'document'=> "", 'about'=> "", 'range'=> "", 'lang'=> ""];
     SaveData($data, $from_id);
  }
    if(file_exists("Code/".$match[1].".json")){
       $file = json_decode(file_get_contents("Code/".$match[1].".json"),true);
         if(!in_array($from_id, $file['users'])){
         if($file['download'] >= $file['range']){
           SendMessage($chat_id, "📣  دریافت این پست به اتمام رسیداست جهت دریافت اکانت خود را ویژه کنید جهت ویژه کردن حساب خود کافیست 20 زیرمجموعه بگیرید", null, null);
	     }else{
	     sp('download', $user['download']+1);
           array_push($file['users'], $from_id);
           $file['download'] = $file['download']+1;
	     file_put_contents("Code/".$match[1].".json",json_encode($file));
	     SendDocument($chat_id, $file['document'], "لول : {$file['name']}\n\n📝بتل پس  :  {$file['lang']}\n✏️  {$file['about']}\n\n👈🏻 با ویژه کردن حساب خود دیگر نیاز نیست نگران باشید که نتونستم اکانت رو دریافت کنم با حساب ویژه به راحتی اکانت ها را دریافت و از امکانات بالایی برخوردار شوید\n\n🆔 @$channel", null, $message_id, $home);           	     
	     $key = json_encode(['inline_keyboard'=>[ [['text'=>"📁 دریافت اکانت", 'url'=> "https://t.me/$bot?start={$file['key']}"]],[['text'=>"📥 تعداد دریافت {$file['download']} تا از {$file['range']}", 'callback_data'=> "off"]]]]);	     
	     Bot('editMessageReplyMarkup',['chat_id'=>'@'.$channel,'message_id'=> $file['message_id'],'reply_markup'=>$key]);
         file_exists("Code/".$match[1].".json");
         unlink("Code/".$match[1].".json");
         file_put_contents("user/number.txt", $number - 1);
         SendMessage('@'.$logs, "✅ اکانت  ".$match[1]." با موفقیت حذف شد", null, null);
         }
         }else{
            SendMessage($chat_id, "🙂 شما یک بار این اکانت را دریافت کردید", null, $message_id, $home);
         }      
    }else{
       SendMessage($chat_id, "❌ این اکانت قبلا دریافت و حذف شده", null, $message_id, $home);
 }
}
elseif($text == '⬅️ برگشت'){
    SendMessage($chat_id, "🏛 به منوی اصلی بازگشتیم\n👇🏻 از دکمه های پایین استفاده کنید", null, $message_id, $home);
    Save('none');
}
elseif($text == '👤حساب کاربری'){
   $refer = ($user['refer'])?$user['refer']:0;
   SendMessage($chat_id, "🆔 نام کاربری : @$username\n\n🎫 شناسه کاربری : `$from_id`\n📥 تعداد دریافت ها : `{$user['download']}`\n🎛 نوع حساب شما : `{$user['acc']}`\n👥 زیرمجموعه ها : `$refer`", "markdown", $message_id);
}
elseif($text == '🎁 حساب ویژه'){
  if($user['acc'] == "vip"){
     SendMessage($chat_id, "🎛 پنل حساب ویژه برای شما باز گردید\n👇🏻 از بخش پایین استفاده کنید", "markdown", $message_id, $panelVip);
  }else{
     SendMessage($chat_id, "😞 با عرض پوزش حساب شما عادی میباشد جهت ویژه کردن حساب خود 20 زیر مجموعه بگیرید\n\n🎛 نوع حساب شما : `{$user['acc']}`", "markdown", $message_id, $home);
  }
}
elseif($text == "⏰ مشاهده اعتبار" && $user['acc'] == "vip"){
    $ex = explode("%",$user['date']);
    $d = $ex[0];
    $s = $ex[1];
    $t = strtotime("$d $s")-time();
    $day = floor($t/86400);
    $t %= 86400;
    $hour = floor($t/3600);
    $t %= 3600;
    $min = floor($t/60);
    SendMessage($chat_id, "📣 اطلاع از حجم باقی مانده اشتراک ویژه\n\n🌓 $day روز\n⏰ $hour ساعت\n⏲ $min دقیقه\n⏳ باقی مانده است", null, $message_id, $panelVip);
}
elseif($text == "💾 دریافت اکانت" && $user['acc'] == "vip"){
    SendMessage($chat_id, "🔢 شماره اکانتی که در کانال هست را وارد کنید مثال : 4", null, $message_id, $back);
    Save('VipSource');
}
elseif($user['step'] == "VipSource" && $user['acc'] == "vip"){
   if(is_numeric($text)){
      if(file_exists("Code/$text.json")){
         $get = json_decode(file_get_contents("Code/$text.json"),true);
         SendDocument($chat_id, $get['document'], "لول : {$get['name']}\n\n📝بتل پس  :  {$get['lang']}\n✏️  {$get['about']}\n\n🆔 @$channel", null, $message_id, $panelVip);	    
         SendMessage($chat_id, "👆🏻 اینم اکانت مورد نظر شما کاربر محترم", null, $message_id);
         Save('none');
         file_exists("Code/$text.json");
         unlink("Code/$text.json");
         file_put_contents("user/number.txt", $number - 1);
         SendMessage('@'.$logs, "✅ اکانت  $text با موفقیت حذف شد", null, null);
         foreach(scandir("user") as $value){
            $from = pathinfo($value)['filename'];
            $users = json_decode(file_get_contents("user/".$value),true);
            if($users['acc'] == "vip"){
                   SendMessage($from, "⏳ شتراک ویژه شما به پایان رسید.\nجهت تمدید اکانت خود 20 زیرمجموعه بگیرید.", null, null);
                   $users['acc'] = "member";
                   $users['date'] = "";
                   file_put_contents("user/".$value, json_encode($users,128|256));
               }
        }
      }else{
         SendMessage($chat_id, "☑️ اکانتی با شماره $text یافت نشد", null, $message_id, $back);
    }
   }else{
     SendMessage($chat_id, "☑️ لطفا شماره اکانت را بصورت عدد و انگلیسی وارد کنید. مثال : 4", null, $message_id, $back);
  }
}
elseif($text == '🚦پشتیبانی'){
    SendMessage($chat_id, "🚦لطفا پیام خود را برای ما ارسال کنید تا در اسرع وقت توسط مدیران ما جواب داده شود یا به پیوی @Mad_Kobs مراجعه کنید", null, $message_id, $back);
    Save('support');
}
elseif($user['step'] == 'support'){
    forwardMessage($admin[0], $chat_id, $message_id);
    SendMessage($chat_id, "✅ پیام شما برای کارشناسان ما ارسال شد\n❓اگر پیام دیگری هم دارید آن را ارسال کنید", null, $message_id, $back);
}
elseif($rp && $admin[0] == $from_id){
    SendMessage($rp, "🗣 پاسخ پشتیبان برای شما :\n\n$text", null, null);
    SendMessage($chat_id, "✅ پیام شما برای کاربر ارسال شد", null, null);
}
elseif($text == "👥 زیرمجموعه گیری"){
   $refer = ($user['refer'])?$user['refer']:0;
   $msg_id =  Bot('SendMessage',['chat_id'=> $chat_id, 'text'=> "✋🏼 سلام با استفاده از لینک زیر برای خود زیر مجموعه جمع کنید و به20 تا برسید حساب شما به مدت 1 روز ویژه میشود و میتوانید تمامی اکانت ها را بصورت رایگان دریافت کنید.\nلینک شما 👇🏻\nt.me/$bot?start=ref_$from_id", 'reply_to_message_id'=> $message_id])['result']['message_id'];
   SendMessage($chat_id, "👆🏻 بنر بالا حاوی لینک دعوت شما به ربات است\n\n🎁 با دعوت دوستان به ربات با لینک اختصاصی خود میتوانید به ازای هر نفر 1 زیرمجموعه دریافت کنید\n✅ پس با زیرمجموعه گیری به راحتی میتوانید حساب خود را رایگان ویژه کنید\n\n👥 تعداد زیر مجموعه : $refer نفر", null, $msg_id);
}
//*****panel**//////
elseif($text == "/cityhossein" or $text == "↩️ برگشت" && is_admin()){
    SendMessage($chat_id, "⌨ پنل مدیریت باز شد", null, $message_id, $panel);
    Save('none');
}
elseif($text == '📊 آمار' && is_admin()){
    $count = count(scandir('user'))-4;
    $code = count(scandir('Code'))-2;
    SendMessage($chat_id, "📶 آمار کاربران ربات : *$count*\n📬 تعداد پست ها : *$code*", "markdown", $message_id);
}
elseif($text == '🗳 افزودن پست' && is_admin()){
    SendMessage($chat_id, "🏷 لول اکانت  خود را وارد کنید", null, $message_id, $Back);
    Save('name');
}


elseif($user['step'] == 'name'){
   SendMessage($chat_id, "📝 در مورد اکانت  کمی توضیح دهید", null, $message_id, $Back);
   sp('name', $text);
   Save('about');
}

elseif($user['step'] == 'about'){
   SendMessage($chat_id, "🔢 تعداد دریافت را وارد کنید به عدد و انگلیسی", null, $message_id, $Back);
   sp('about', $text);
   Save('range');
}

elseif($user['step'] == 'range'){
   if(is_numeric($text)){
      SendMessage($chat_id, "🌐 بتل پس اکانت  را وارد کنید", null, $message_id, $Back);
      sp('range', $text);
      Save('lang');
   }else{
      SendMessage($chat_id, "‼️ لطفا تعداد دریافت را بصورت عدد و انگلیسی وارد کنید مثال : 10", null, $message_id, $Back);
   }
}

elseif($user['step'] == 'lang'){
   SendMessage($chat_id, "🖼 لطفا یک فیلم از پیش نمایش اکانت  خود وارد کنید", null, $message_id, $Back);
   sp('lang', $text);
   Save('photo');
}

elseif($user['step'] == 'photo'){
   if(isset($update['message']['video'])){
       SendMessage($chat_id, "📦 لطفا اکانت اکانت  را بصورت zip وارد کنید", null, $message_id, $Back);
       sp('photo', $update['message']['video']['file_id']);
       Save('file');
   }else{
       SendMessage($chat_id, "‼️ لطفا فیلم ارسال کنید نه چیز دیگری", null, $message_id, $Back);
  }
}

elseif($user['step'] == 'file'){
   if(isset($update['message']['document'])){
       SendMessage($chat_id, "🧐 آیا پست به کانال ارسال گردد؟", null, $message_id, $whois);
       sp('document', $update['message']['document']['file_id']);
       Save('none');
   }else{
       SendMessage($chat_id, "‼️ لطفا اکانت ارسال کنید نه چیز دیگری", null, $message_id, $Back);
   }
}
elseif($text == '✅ بله' && is_admin()){
    $num = $number+1;
    $key = json_encode(['inline_keyboard'=>[ [['text'=>"📁 دریافت اکانت", 'url'=> "https://t.me/$bot?start=$num"]],[['text'=>"📥 تعداد دریافت 0 تا از {$user['range']}", 'callback_data'=> "off"]]]]);
    $msg_id = Bot('SendVideo',['chat_id'=>'@'.$channel,'video'=>$user['photo'],'caption'=>"🔢  شماره : $num\n\nلول : {$user['name']}\n\n✏️ {$user['about']}\n\nبتل پس : {$user['lang']}\n\n\n📣 @$channel",'reply_markup'=> $key])['result']['message_id'];
    $msg_id = Bot('SendVideo',['chat_id'=>'@'.$bot,'video'=>$user['photo'],'caption'=>"🔢  شماره : $num\n\nلول : {$user['name']}\n\n✏️ {$user['about']}\n\nبتل پس : {$user['lang']}\n\n\n📣 @$channel",'reply_markup'=> $key])['result']['message_id'];
    sc($user['name'],$user['about'],$user['range'],$user['lang'],$user['photo'],$user['document'],$num,$msg_id);
    file_put_contents("user/number.txt", $num);
    SendMessage($chat_id, "✅ پست در کانال ارسال گردید", null, $message_id, $panel);
}
elseif($text == "☑️ خیر" && is_admin()){
    SendMessage($chat_id, "☑️ ارسال پست لغو شد", null, $message_id, $panel);
    Save('none');
}
elseif(preg_match('/^\/(vip)\s+(\d+)\s+(\d+)/',$text, $m) && is_admin()){
    $id = $m[2];
    $day = $m[3];
    if(file_exists("user/$id.json")){
    $get = json_decode(file_get_contents("user/$id.json"),true);
       SendMessage($id, "📣 تبریک حساب شما به مدت $day روز ویژه شد 😉", null, null);
       SendMessage($chat_id, "✅ کاربر $id به مدت $day روز ویژه شد", null, null);
       SendMessage('@'.$logs, "✅ کاربر $id به مدت $day روز ویژه شد", null, null);
       $ago = date('Y-m-d', strtotime("+$day day"));
       $get['date'] = $ago."%".date('H:i:s');
       $get['acc'] = "vip";
       file_put_contents("user/$id.json", json_encode($get,128|256));
    }else{
       SendMessage($chat_id, "🤨 کاربری با آیدی $id یافت نشد.", null, null);
  }
}
elseif(preg_match('/^\/(dvip)\s+(\d+)/',$text, $m) && is_admin()){
    $id = $m[2];
    $day = $m[3];
    if(file_exists("user/$id.json")){
    $get = json_decode(file_get_contents("user/$id.json"),true);
       SendMessage($id, "😞 حساب شما از حالت ویژه خارج گردید", null, null);
       SendMessage($chat_id, "✅ از حالت ویژه خارج شد", null, null);
       SendMessage('@'.$logs, "🚧 کاربر $id از حالت ویژه برداشته شد", null, null);
       $get['date'] = "";
       $get['acc'] = "member";
       file_put_contents("user/$id.json", json_encode($get,128|256));
    }else{
       SendMessage($chat_id, "🤨 کاربری با آیدی $id یافت نشد.", null, null);
  }
}
elseif($text == "/fwd" && is_admin()){
    SendMessage($chat_id, "-> لطفا پیام خود را ارسال یا از جایی فروارد کنید :)", null, $message_id, $Back);
    Save('fwd');
}
elseif($user['step'] == 'fwd'){
    foreach(scandir("user") as $key => $value){
        $dir = pathinfo($value, PATHINFO_FILENAME);
        forwardMessage($dir, $chat_id, $message_id);
    }
    SendMessage($chat_id, "پیام برای همه ارسال گردید", null, $message_id, $panel);
    Save('none');
}
elseif($text == "/send" && is_admin()){
    SendMessage($chat_id, "-> لطفا پیام خود را ارسال کنید فقط متن", null, $message_id, $Back);
    Save('pms');
}
elseif($user['step'] == 'pms' && isset($text)){
    foreach(scandir("user") as $key => $value){
        $dir = pathinfo($value, PATHINFO_FILENAME);
        SendMessage($dir, $text, null, null);
    }
    SendMessage($chat_id, "پیام برای همه ارسال گردید", null, $message_id, $panel);
    Save('none');
}
elseif($text == "📑 لیست بلاک ها" && is_admin()){
    $result = "";
    foreach($list['ban'] as $key => $value){
        $result .= "🔐 $value\n";
    }
    SendMessage($chat_id, "📌 لیست افراد بلاک شده :\n $result", null, $message_id);
}
elseif($text == "🗑 حذف پست" && is_admin()){
    SendMessage($chat_id, "🗑 جهت حذف پست لطفا شماره آن را وارد کنید مثال 2", null, $message_id, $Back);
    Save('Delete');
}
elseif($user['step'] == 'Delete'){
    if(is_numeric($text)){
       if(file_exists("Code/$text.json")){
         SendMessage($chat_id, "✅ اکانت  $text با موفقیت حذف شد", null, $message_id, $panel);
         unlink("Code/$text.json");
         Save('none');
         file_put_contents("user/number.txt", $number - 1);
       }else{
        SendMessage($chat_id, "🔄 چنین اکانتی در دیتابیس یافت نکردم!", null, $message_id, $Back);
     }
    }else{
       SendMessage($chat_id, "🔢 لطفا اکانت را بصورت عدد وارد کنید با تشکر", null, $message_id, $Back);
  }
}
/*
کانال ایرو اکانت مرجع اکانت و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/
?>