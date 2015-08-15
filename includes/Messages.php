<?php

//sendMessege(messege,,invitationType
//subject,,sender,reciver)
//deleteMessege(senderID)
//ReadMessege
//RetriveInbox(list of all messeges in my inbox)
  require_once('db.php');
  class Messages{

  public $db;
  public function __construct() {
  global $db;
  $this->db = new DB;
  }

public function  sendMessege($inputs)
{
  $error= array();
  if(!is_array($inputs->ReciverID)){

  $reciver = new stdClass();
  $reciver->id = $inputs->ReciverID;
  $inputs->ReciverID= array();
  array_push($inputs->ReciverID,$reciver);
  }

  foreach ($inputs->ReciverID as $ReciverID) {
    $this->db->insert("messageLog",array(
      'SenderID' =>  $inputs->SenderID,
      'ReciverID' => $ReciverID->id,
      'Subject' =>  $inputs->Subject,
      'Content' =>  $inputs->Content
    ));
    if($this->db->error){
    array_push($error,$this->db->errorMessege());
    }
  }
  echo json_encode(!empty($error)?$error: array('sucess' => true));
}
public function  deleteMessege($inputs)
{
  $this->db->delete("messageLog", $where=array("messageID"=>$inputs->id));
  echo json_encode($this->db->error?$this->db->errorMessege(): array('sucess' => true));
}
public function  ReadMessege($inputs)
{

  $this->db->select($table='messageLog',$where=array('messageID'=>$inputs->messageID),$limit=false,false,"AND",false,"*",false);
  if(!$this->db->error)
  {
  $messegeIntry=$this->db->row_array();
  $sw=($messegeIntry['type']);
    if($sw=='0'||$sw=='1'){
    $What="`members`.`name` , `members`.`ProfilePic`,
       `messageLog`.`Subject`,`messageLog`.`TimeSent`,`messageLog`.`Content`";
    $innerJoin=  "INNER JOIN `members` ON `members`.`id`=`messageLog`.`SenderID`";
    $this->db->select($table,$where,$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
  }else{



    $What="`members`.`name` , `members`.`ProfilePic`,
     `Events`.`id` ,`Events`.`subject` ,`Events`.`eventType` , `Events`.`VIP` ,
     `Events`.`picture` ,`Events`.`description`, `Events`.`TimeEnded`, `Events`.`timeCreated` ,
      `Events`.`comments` , `Events`.`approved`";
    $innerJoin = "INNER JOIN `members` ON `Events`.`CreatorID`=`members`.`id`";
    $this->db->select('Events',array('Events`.`id'=>$messegeIntry['EventID']),$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
  }
    $this->db->update('messageLog', $fields=array('Status'=>1), $where);
  }else{ echo json_encode($this->db->errorMessege());}
}
public function  RetriveInbox($inputs)
{
  $table="invitationsLog";
  $where=array('invitationsLog`.`memberID'=>$inputs->ReciverID);
  $limit=$inputs->start.",".$inputs->limit;
  $What="
  `invitationsLog`.`invitationID`,
   `invitationsLog`.`EventID`,
   `members`.`name` ,
   `members`.`ProfilePic` ,
   `Events`.`VIP` type,
   `Events`.`subject`";
  $innerJoin=  "INNER JOIN `members` ON `members`.`id`=`invitationsLog`.`memberID` INNER JOIN `Events` on Events.id=invitationsLog.EventID";
  $this->db->select($table,$where,$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
  echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
}
public function retriveInvitationInbox($inputs){
  $table="invitationsLog";
  $where=array('invitationsLog`.`memberID'=>$inputs->ReciverID);
  $limit=$inputs->start.",".$inputs->limit;
  $What="
  `invitationsLog`.`invitationID`,
   `invitationsLog`.`EventID`,
   `members`.`name` ,
   `members`.`ProfilePic` ,
   `Events`.`VIP` type,
   `Events`.`subject`";
  $innerJoin=  "INNER JOIN `members` ON `members`.`id`=`invitationsLog`.`memberID` INNER JOIN `Events` on Events.id=invitationsLog.EventID";
  $this->db->select($table,$where,$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
  echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
}
public function  unReadInbox($inputs)
{
    $this->db->select('messageLog',$where=array('ReciverID'=>$inputs->ReciverID,'Status'=>0),false,false,"AND",false,"*",false);
    $respond = array('unReaded' => $this->db->count());
    echo json_encode($this->db->error?$this->db->errorMessege():$respond);
}


}
?>
