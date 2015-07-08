<?php

class invitationsLog{

public function invite($inputs)
{
  require_once("DataBaseConnection.php");


  require_once("Messages.php");
  $messege=new Messages;

  $messegeInput = new stdClass();
  $messegeInput->SenderID = $inputs->SenderID;
  $messegeInput->Subject = $inputs->Subject;
  $messegeInput->Content = $inputs->Content;
  $messegeInput->EventID = $inputs->EventID;
$respond= array();

foreach ($inputs->listArray as $key) {

$dbConnect=new DatabaseConnect;
$query = mysql_query("SELECT * FROM `invitationsLog` WHERE `EventID` = \"".$inputs->EventID."\" AND
`memberID` = \"".$key->id."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
  $res = new stdClass();
  $res->id=$key->id;
    if(empty($row)){
    $sql = mysql_query("INSERT INTO `".DB_DATABASE."`.`invitationsLog` (`EventID`,`memberID`)
    VALUES ('".$inputs->EventID."', '".$key->id."');") or die (mysql_error());
    $dbConnect->close();
    $messegeInput->ReciverID=$key->id;
        if($messege->sendMessegeWithReturn($messegeInput)){
          //Messege Sent
          $res->sucess=true;
        }
        else{
            $res->sucess=false;
            //Messege was not Sent
        }
    }
    else{
      $res->sucess=false;
      //Already invited
    }
    array_push($respond,$res);
}
echo json_encode($respond);

}


public function JoinEvent($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `Attendees` WHERE `eventID` = \"".$inputs->eventID."\" AND `memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
if(empty($row)){

  $sql = "INSERT INTO `".DB_DATABASE."`.`Attendees` (`eventID`,`memberID`)
  VALUES ('".$inputs->eventID."', '".$inputs->memberID."');";

  if(mysql_query($sql))
  {
  $respond = array('sucess' => true);
  echo json_encode($respond);
  }else{
    $respond = array('sucess' => false);
   echo json_encode($respond);
  }

}else{
  $respond = array('sucess' => true,
  'AlreadyAttend' => true
);
 echo json_encode($respond);
}
  $dbConnect->close();
}
public function LeaveEvent($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("DELETE  FROM `Attendees` WHERE `eventID` = \"".$inputs->eventID."\" AND `memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
if($query){
  $respond = array('sucess' => true);
}else{
  $respond = array('sucess' => false);
}
 echo json_encode($respond);
  $dbConnect->close();
}
public function ViewEventAttendees($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
      mysql_query("set names 'utf8'");
$query=mysql_query("SELECT members.id , members.name , members.ProfilePic FROM Attendees  INNER JOIN members ON Attendees.memberID=members.id WHERE Attendees.eventID=
".$inputs->eventID."  LIMIT ".$inputs->start.", ".$inputs->limit."");
$stack = array();
while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
  array_push($stack, $row);

}

echo json_encode($stack);
$dbConnect->close();

}

public function isJoind($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `Attendees` WHERE `eventID` = \"".$inputs->eventID."\" AND `memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
$found=false;
if(!empty($row)){
  $found=true;
}

echo json_encode($found);
$dbConnect->close();

}









}






 ?>
