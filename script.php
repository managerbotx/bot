<?php
/*
کانال ایرو سورس مرجع سورس و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/
/*
کرون جاب 1 دقیقه ای روی این فایل ثبت شود
*/
include "class.php";
date_default_timezone_set('Asia/Tehran');
$date = date('Ymd');

foreach(scandir("user") as $value){
    $from = pathinfo($value)['filename'];
    $users = json_decode(file_get_contents("user/".$value),true);
    if($users['acc'] == "vip"){
     $ex = explode("%",$users['date'])[0];
       if($date >= str_replace("-","",$ex)){
           SendMessage($from, "⏳ مهلت اشتراک ویژه شما به پایان رسید.\nجهت تمدید اکانت خود 20 زیرمجموعه بگیرید.", null, null);
           $users['acc'] = "member";
           $users['date'] = "";
           file_put_contents("user/".$value, json_encode($users,128|256));
       }
    }
}
/*
کانال ایرو سورس مرجع سورس و قالب و اموزش 
لطفا در کانال ما عضو شويد 
@irosource 
گپی بدون منبع حرام است
*/