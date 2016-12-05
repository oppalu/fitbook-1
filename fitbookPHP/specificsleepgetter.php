<?php
/**
 * Created by PhpStorm.
 * User: peiyulin
 * Date: 2016/11/28
 * Time: 下午12:03
 */
 header('Access-Control-Allow-Origin: *');
 $ssid=$_GET["ssid"];
 Session_id($ssid);
 session_start();

$userid=$_SESSION['id'];

require ("DBHelper.php");


$date=$_GET["date"];

$date="\"".$date."\"";


$db=new MyDB();
$tempsql="select sleeptime,getuptime,deepduration,lightduration from Usersleep where userid=".$userid." and date=".$date." ;";


$sql =<<<EOF
     $tempsql
EOF;


$sleeptime="";
$getuptime="";
$deepduration="";
$lightduration="";


$ret = $db->query($sql);

while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
  $sleeptime=$row['sleeptime'];

  $getuptime=$row['getuptime'];

  $deepduration=$row['deepduration'];

  $lightduration=$row['lightduration'];
}





//use while avoid empty
if($sleeptime==""){
  $arr = array('isava'=>0,'totalsleep' => 1, 'sleeptime'=>session_id(),'getuptime'=>1,'deeptime'=>1,'lighttime'=>1);
  echo json_encode($arr);
}else{
  $strtotal=changemin2hour($deepduration+$lightduration);
  $strdeep=changemin2hour($deepduration);
  $strlight=changemin2hour($lightduration);

  $arr = array('isava'=>1,'totalsleep' => $strtotal, 'sleeptime'=>$sleeptime,'getuptime'=>$getuptime,'deeptime'=>$strdeep,'lighttime'=>$strlight);
  echo json_encode($arr);
}



function changemin2hour($min){
  $hour=$min/60;
  $minutes=$min%60;
  $hour=floor($hour);
  $str=$hour."小时 ".$minutes."分钟";
  return $str;
}






 ?>
