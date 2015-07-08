<?php

//sendMessege(messege,,invitationType
//subject,,sender,reciver)
//deleteMessege(senderID)
//ReadMessege
//RetriveInbox(list of all messeges in my inbox)

class Messages{

  public function  sendMessegeWithReturn($inputs)
  {
    require_once("DataBaseConnection.php");
    $dbConnect=new DatabaseConnect;
    $sql = "INSERT INTO `".DB_DATABASE."`.`messageLog` (`SenderID`,  `ReciverID`, `Subject`, `Content`, `EventID`)
    VALUES ('".$inputs->SenderID."', '".$inputs->ReciverID."', '".$inputs->Subject."', '".$inputs->Content."', '".(empty($inputs->EventID)?-1:$inputs->EventID)."');";

    if (mysql_query($sql)) {
    return true;
    } else {
    return false;
    }
  $dbConnect->close();
  }

public function  sendMessege($inputs)
{
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $sql = "INSERT INTO `".DB_DATABASE."`.`messageLog` (`SenderID`,  `ReciverID`, `Subject`, `Content`, `EventID`)
  VALUES ('".$inputs->SenderID."', '".$inputs->ReciverID."', '".$inputs->Subject."', '".$inputs->Content."', '".(empty($inputs->EventID)?-1:$inputs->EventID)."');";

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
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;

  $sql ="DELETE FROM `messageLog` WHERE messageID=".$inputs->messageID;
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
public function  ReadMessege($inputs)
{
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query=mysql_query("SELECT EventID FROM messageLog WHERE messageID =".$inputs->messageID);
  if ($query){
    //First i need to read the messege
  mysql_query("UPDATE  `".DB_DATABASE."`.`messageLog` SET `Status` = '1' WHERE `messageLog`.`messageID` = ".$inputs->messageID);
  $row = mysql_fetch_array($query,MYSQL_ASSOC);
  if($row['EventID']==-1)
  {
    $query=mysql_query("SELECT `members`.`name` , `members`.`ProfilePic`,
       `messageLog`.`Subject`,`messageLog`.`TimeSent`,`messageLog`.`Content`
       from `messageLog` INNER JOIN `members`
       ON `members`.`id`=`messageLog`.`SenderID`
       WHERE messageID =".$inputs->messageID)or die (mysql_error());
       $row = mysql_fetch_array($query,MYSQL_ASSOC);
         $row['invitation']=false;
       echo json_encode($row);
    //general messege
  }else{
    $query=mysql_query("SELECT `members`.`name` , `members`.`ProfilePic`,
       `messageLog`.`Subject`,`messageLog`.`TimeSent`,`messageLog`.`Content` ,
    `Events`.`id`, `Events`.`subject`, `Events`.`picture`
       from `messageLog` INNER JOIN `members` ON `members`.`id`=`messageLog`.`SenderID`
     INNER JOIN `Events` ON  `Events`.`id`=`messageLog`.`EventID`
       WHERE messageID =".$inputs->messageID)or die (mysql_error());
       $row = mysql_fetch_array($query,MYSQL_ASSOC);
      $row['invitation']=true;
       echo json_encode($row);
    //invitation messege
  }
   }else{
     //Query faild
  $respond = array('sucess' => false);
 echo json_encode($respond);
}
$dbConnect->close();
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
