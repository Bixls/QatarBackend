<?php



require_once("configuration.php");
require_once(ROOTPATH."/includes/DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
$sql = mysql_query("SELECT * FROM `Images`  WHERE `imageid`=".$_GET['id']."");
$row=mysql_fetch_array($sql);

$url = $_SERVER['SCRIPT_FILENAME']; //returns the current URL
$parts = explode('/',$url);
$dir ="";
for ($i = 0; $i < count($parts) - 1; $i++) {
 $dir .= $parts[$i] . "/";
}


if(!isset($_GET['t'])){
$src =$dir.$row['imageSrc'].".".$row['ext'];
}else{
  $src =$dir.$row['imageSrc'].$_GET['t'].".".$row['ext'];
}

//echo $src;
  header('Content-Type: image/jpeg');
  header('Content-Length: ' . filesize($src));
   echo file_get_contents($src);


?>
