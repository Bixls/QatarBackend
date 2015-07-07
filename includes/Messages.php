<?php

//sendMessege(messege,,invitationType
//subject,,sender,reciver)
//deleteMessege(senderID)
//ReadMessege
//RetriveInbox(list of all messeges in my inbox)

class Messages{

public function  sendMessege($inputs)
{
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $sql = "INSERT INTO `".DB_DATABASE."`.`messageLog` (`SenderID`,  `ReciverID`, `Subject`, `Content`, `invitationID`)
  VALUES ('".$inputs->SenderID."', '".$inputs->ReciverID."', '".$inputs->Subject."', '".$inputs->Content."', '-1');";

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
public function  deleteMessege($inputs)
{

}
public function  ReadMessege($inputs)
{

}
public function  RetriveInbox($inputs)
{
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $sql = mysql_query("SELECT  `messageLog`.`messageID`,`members`.`name` , `members`.`ProfilePic`
    , `messageLog`.`Subject`, `messageLog`.`Status` from `messageLog` INNER JOIN `members`
    ON `members`.`id`=`messageLog`.`SenderID`
    WHERE `messageLog`.`ReciverID` = \"".$inputs->ReciverID."\"
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
