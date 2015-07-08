<?php

class comments{

public function addComment($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $tableName=$inputs->POSTType==0?"EventsComments":"NewsComments";

  $sql = "INSERT INTO `".$tableName."` (`POSTID`,  `memberID`, `comment`)
  VALUES ('".$inputs->POSTID."', '".$inputs->memberID."', '".$inputs->comment."')";
  if (mysql_query($sql)) {
      $respond = array('sucess' => true);
     echo json_encode($respond);
    //successfully Registering new user
  } else {
    $respond = array('success' => false);
   echo json_encode($respond);
  //an error has been accourd
  }

$dbConnect->close();
}
public function RemoveComment($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $tableName=$inputs->POSTType==0?"EventsComments":"NewsComments";
  $sql = "DELETE FROM `".$tableName."` WHERE `CommentID` = ".$inputs->CommentID;
  if (mysql_query($sql)) {
      $respond = array('sucess' => true);
     echo json_encode($respond);
    //successfully Registering new user
  } else {
    $respond = array('success' => false);
   echo json_encode($respond);
  //an error has been accourd
  }

$dbConnect->close();

}
public function retriveComments($inputs){

  $tableName=$inputs->POSTType==0?"EventsComments":"NewsComments";


    require_once("DataBaseConnection.php");
    $dbConnect=new DatabaseConnect;
    $sql = mysql_query("SELECT  `".$tableName."`.`CommentID`,`members`.`name` , `members`.`ProfilePic`
      , `".$tableName."`.`comment` from `".$tableName."` INNER JOIN `members`
      ON `members`.`id`=`".$tableName."`.`memberID`
      WHERE `".$tableName."`.`POSTID` = \"".$inputs->POSTID."\"
       LIMIT ".$inputs->start.", ".$inputs->limit."  ") or die (mysql_error());
     if ($sql){
       $stack = array();
         while( $row = mysql_fetch_array($sql,MYSQL_ASSOC)){
         array_push($stack, $row);
       }
         echo json_encode($stack);

  }else{
  $respond = array('sucess' => false);
  echo json_encode($respond);
  }
  $dbConnect->close();


}


}


?>
