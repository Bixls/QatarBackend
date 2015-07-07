<?php
class News{

public function GetNewsList($inputs){
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
$sql=mysql_query("SELECT NewsID,Subject,Image FROM News WHERE GroupID=".$inputs->GroupID."
 ORDER BY timeCreated DESC  LIMIT ".$inputs->start." , ".$inputs->limit."  ");
 if ($sql){
   $stack = array();
     while( $row = mysql_fetch_array($sql,MYSQL_ASSOC)){
     array_push($stack, $row);
   }
     echo json_encode($stack);
}
else{
 $respond = array('sucess' => false);
echo json_encode($respond);
}
$dbConnect->close();
}
public function GetFullNews($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
  $query=mysql_query("SELECT * FROM News WHERE NewsID=".$inputs->NewsID."");
  if ($query){
  $row = mysql_fetch_array($query,MYSQL_ASSOC);
  echo json_encode($row);
}
else{
  $respond = array('sucess' => false);
 echo json_encode($respond);
}
$dbConnect->close();
}

}







?>
