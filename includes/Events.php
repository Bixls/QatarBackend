<?php


require_once('db.php');


class Events{
public $id;
public $CreatorID;
public $VIP;
public $eventType;
public $subject;
public $description;
public $picture;
public $timeCreated;
public $TimeEnded;
public $comments;





public $db;
public function __construct() {
global $db;
$this->db = new DB;
}

public function getEventbyID($inputs){



        $What="`members`.`name` , `members`.`ProfilePic`,
         `Events`.`id` ,`Events`.`subject` ,`Events`.`eventType` ,`Events`.`CreatorID`, `Events`.`VIP` ,
         `Events`.`picture` ,`Events`.`description`, `Events`.`TimeEnded`, `Events`.`timeCreated` ,
          `Events`.`comments` , `Events`.`approved`";
        $innerJoin = "INNER JOIN `members` ON `Events`.`CreatorID`=`members`.`id`";
        $this->db->select('Events',array('Events`.`id'=>$inputs->Eventid),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
        echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());


}

public function getEventTypebyID($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    $query = mysql_query("SELECT eventType FROM `Events`  WHERE `id` = \"".$inputs."\"  ") or die (mysql_error());
  $re=0;
    if ($query){
    $row = mysql_fetch_array($query,MYSQL_ASSOC);
      $re= $row["eventType"];
  }
  $dbConnect->close();
return $re;
}


public function CreateEvent($inputs) {

  $error=array();
  if($inputs->VIP==1){
      $this->db->select($table='members',$where=array('id'=>$inputs->CreatorID),false,false,"AND",false,"*",false);
      $output=$this->db->row_array();
      if($output['inVIP']>0){
        $newVip=$output['inVIP']-1;
        $this->db->update('members',$what= array('inVIP' => $newVip),$where=array('id'=>$inputs->CreatorID));
      }else{
      array_push($error,"VIP");
      }
    }

  if(empty($error)){
  $this->db->insert("Events", get_object_vars($inputs));
  echo json_encode($this->db->error?$this->db->errorMessege(): array('sucess' => true));
  }else{
  echo json_encode($arrayName = array('sucess' =>false ,'reason'=>$error ));
  // echo faild because you dont have enough points
  }

}

public function getUserEventsList($inputs){
$inputs->userID;
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
  $query = mysql_query("SELECT
    `Events`.`id` ,
    `members`.`name`,
    `members`.`groupID` ,
    `members`.`ProfilePic` ,
    `Events`.`subject` ,
    `Events`.`VIP` ,
      `Events`.`eventType` ,
    `Events`.`picture` ,
    `Events`.`TimeEnded` ,
    `Events`.`approved`
     from `Events` INNER JOIN `members` ON   `Events`.`CreatorID`=`members`.`id` WHERE `CreatorID` = \"".$inputs->userID."\"  ORDER BY `Events`.`timeCreated` DESC   LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
$stack = array();
  while($row = mysql_fetch_array($query)){
    $user = array(
      'Eventid'=>$row['id'],
      'CreatorName'=>$row['name'],
      'CreatorPic'=>$row['ProfilePic'],
      'subject'=>$row['subject'],
      'EventPic'=>$row['picture'],
        'catID'=>$row['eventType'],
      'VIP'=>$row['VIP'],
      'TimeEnded'=>$row['TimeEnded']
    );
  array_push($stack, $user);
}
  echo json_encode($stack);
   $dbConnect->close();
}

public function getGroupEvents($inputs){
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");

  $query = mysql_query("SELECT `Events`.`id` , `members`.`name`, `members`.`groupID` , `members`.`ProfilePic` , `Events`.`subject` , `Events`.`VIP` ,`Events`.`picture` , `Events`.`TimeEnded` , `Events`.`approved` from `Events` INNER JOIN `members` ON
   `Events`.`CreatorID`=`members`.`id` WHERE `members`.`groupID` = ".$inputs->groupID." AND `Events`.`approved`=1 ORDER BY  `Events`.`VIP` DESC, `Events`.`TimeEnded` DESC LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
$stack = array();
  while($row = mysql_fetch_array($query)){
    $user = array(
    'Eventid'=>$row['id'],
    'CreatorName'=>$row['name'],
    'CreatorPic'=>$row['ProfilePic'],
    'subject'=>$row['subject'],
    'EventPic'=>$row['picture'],
    'VIP'=>$row['VIP'],
    'TimeEnded'=>$row['TimeEnded']
    );
  array_push($stack, $user);
}
  echo json_encode($stack);
   $dbConnect->close();
}
public function getEvents($inputs)
{
//$inputs->groupID;// -1:home page  anyother value i am on a group
//$inputs->catID;//-1 uncatigorized , anyother value catigorized
//$inputs->start;
//$inputs->limit;
$timeNow=Date("Y-m-d h:m:s");
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
$Filters="";
if($inputs->groupID==-1)
{
  $Filters.="AND `Events`.`VIP` = 1";
//Homepage
}
else{
  $Filters.="AND `members`.`groupID` = ".$inputs->groupID." ";
//Group page
}
if($inputs->catID!=-1)
{
  $Filters.=" AND `Events`.`eventType` = ".$inputs->catID." ";
//catigorized
}
if(1)
{
  $Filters.=" AND `Events`.`TimeEnded` >= '".$timeNow."' ";
//catigorized
}
    $query = mysql_query("SELECT
      `Events`.`id` ,
      `members`.`name`,
      `members`.`groupID` ,
      `members`.`ProfilePic` ,
      `Events`.`subject` ,
      `Events`.`VIP` ,
      `Events`.`eventType` ,
      `Events`.`picture` ,
      `Events`.`TimeEnded` ,
      `Events`.`approved`
      from `Events` INNER JOIN `members` ON   `Events`.`CreatorID`=`members`.`id`
      WHERE `Events`.`approved`=1 ".$Filters."
      ORDER BY  `Events`.`VIP` DESC,
      `Events`.`timeCreated` DESC
      LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
      $stack = array();

      while($row = mysql_fetch_array($query)){
      $user = array(
      'Eventid'=>$row['id'],
      'CreatorName'=>$row['name'],
      'CreatorPic'=>$row['ProfilePic'],
      'subject'=>$row['subject'],
      'EventPic'=>$row['picture'],
        'catID'=>$row['eventType'],
      'VIP'=>$row['VIP'],
      'TimeEnded'=>$row['TimeEnded']
      );
    array_push($stack, $user);
  }
    echo json_encode($stack);
     $dbConnect->close();
}


public function editEvent($inputs){
  $error=false;
  if($inputs->VIP==1){
    $this->db->select($table='Events',$where=array('id'=>$inputs->id),false,false,"AND",false,"*",false);
    $output=$this->db->row_array();
    if($output['VIP']==0){
      $this->db->select($table='members',$where=array('id'=>$inputs->CreatorID),false,false,"AND",false,"*",false);
      $output=$this->db->row_array();
      if($output['inVIP']>0){
        $newVip=$output['inVIP']-1;
      $this->db->update('members',$what= array('inVIP' => $newVip),$where=array('id'=>$inputs->CreatorID));
      }else{
        $error=true;
      }
    }
  }
  if(!$error){
  $this->db->update("Events", get_object_vars($inputs), $where=array("id"=>$inputs->id));
  echo json_encode($this->db->error?$this->db->errorMessege(): array('sucess' => true));
}else{
  echo json_encode($arrayName = array('sucess' =>false ,'reason'=>"VIP" ));
  // echo faild because you dont have enough points
}
}




}




 ?>
