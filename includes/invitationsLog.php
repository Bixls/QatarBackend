<?php

  require_once('db.php');
  class invitationsLog{
  public $db;
  public function __construct() {
  global $db;
  $this->db = new DB;
  }

public function invite($inputs)
{
$error= array();
$this->db->select($table='Events',$where=array('id'=>$inputs->EventID),false,false,"AND",false,"*",false);
if($this->db->error){echo json_encode($this->db->errorMessege()); return false; }
$outs=$this->db->row_array();
$eventType=$outs['eventType'];
$vip=$outs['VIP'];
$sender=$outs['CreatorID'];
$respond= array();

foreach ($inputs->listArray as $key) {

  $res = new stdClass();
  $res->id=$key->id;


    $this->db->select($table='BlockList',$where=array('memberID'=>$key->id,'InvitationID'=>$eventType),false,false,"AND",false,"*",false);
    if($this->db->error){echo json_encode($this->db->errorMessege()); return false; }

      if($this->db->count()<=0){
                        //check there is no other selected
          $this->db->select($table='invitationsLog',$where=array('EventID'=>$inputs->EventID,'memberID'=>$key->id),false,false,"AND",false,"*",false);
              if($this->db->error){echo json_encode($this->db->errorMessege()); return false; }

              if($this->db->count()<=0)
                  {
                      //invite people
                      $this->db->insert("invitationsLog", array('EventID' =>$inputs->EventID , 'memberID'=>$key->id ));
                  if($this->db->error){echo json_encode($this->db->errorMessege()); return false; }
                      //Send messege
                      $this->db->insert("messageLog",array('SenderID' => $sender, 'ReciverID'=>$key->id,'EventID'=>$inputs->EventID,'type'=>$vip?3:2));
                    if($this->db->error){echo json_encode($this->db->errorMessege()); return false; }
                      $res->sucess=true;
                  }
                  else{
                        $res->sucess=false;  //Already invited
                  }

      }
      else{ $res->sucess=true; } //member Block the invitation

        array_push($respond,$res);
}


//array_push($respond,$error);
echo json_encode($respond);
}


public function JoinEvent($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
$query=mysql_query("UPDATE  `invitationsLog` SET `IsGoing` = '1' WHERE `invitationsLog`.`memberID` = ".$inputs->memberID." AND `invitationsLog`.`EventID`=".$inputs->eventID)or die (mysql_error());
if($query){
  $respond = array('sucess' => true);
}else{
  $respond = array('sucess' => false);
}
 echo json_encode($respond);
  $dbConnect->close();
}
public function LeaveEvent($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query=mysql_query("UPDATE  `invitationsLog` SET `IsGoing` = '0' WHERE `invitationsLog`.`memberID` = ".$inputs->memberID." AND `invitationsLog`.`EventID`=".$inputs->eventID)or die (mysql_error());
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
$query=mysql_query("SELECT members.id , members.name , members.ProfilePic FROM invitationsLog
   INNER JOIN members ON invitationsLog.memberID=members.id WHERE invitationsLog.EventID=
".$inputs->eventID."  LIMIT ".$inputs->start.", ".$inputs->limit."");
$stack = array();
if($query){
while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
  array_push($stack, $row);

}
}

echo json_encode($stack);
$dbConnect->close();

}
public function isJoind($inputs){
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
$query = mysql_query("SELECT `IsGoing` FROM `invitationsLog` WHERE `EventID` = \"".$inputs->eventID."\" AND
`memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
  $respond = array('sucess' => false);
if($row["IsGoing"]==1){
  $respond = array('sucess' => true);
}
echo json_encode($respond);
$dbConnect->close();
}

public function isInvited($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `invitationsLog` WHERE `EventID` = \"".$inputs->eventID."\" AND
  `memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
  $respond = array('sucess' => false);
if(!empty($row)){
  $respond = array('sucess' => true);
}

echo json_encode($respond);
$dbConnect->close();

}









}






 ?>
