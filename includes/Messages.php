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
  $this->db->insert("messageLog", get_object_vars($inputs));
  echo json_encode($this->db->error?$this->db->errorMessege(): array('sucess' => true));
}
public function  deleteMessege($inputs)
{
  $this->db->delete("messageLog", $where=array("id"=>$inputs->id));
  echo json_encode($this->db->error?$this->db->errorMessege(): array('sucess' => true));
}
public function  ReadMessege($inputs)
{

  $this->db->select($table='messageLog',$where=array('messageID'=>$inputs->messageID),$limit=false,false,"AND",false,"*",false);
  if(!$this->db->error)
  {

  $sw=($this->db->row_array()['type']);
    if($sw=='0'||$sw=='1'){
    $What="`members`.`name` , `members`.`ProfilePic`,
       `messageLog`.`Subject`,`messageLog`.`TimeSent`,`messageLog`.`Content`";
    $innerJoin=  "INNER JOIN `members` ON `members`.`id`=`messageLog`.`SenderID`";
    $this->db->select($table,$where,$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
  }else{
    $What="`members`.`name` , `members`.`ProfilePic`,
       `messageLog`.`Subject`,`messageLog`.`TimeSent`,`messageLog`.`Content` ,
    `Events`.`id`, `Events`.`subject`, `Events`.`picture`, `Events`.`VIP`";

    $innerJoin = " INNER JOIN `members` ON `members`.`id`=`messageLog`.`SenderID`
     INNER JOIN `Events` ON  `Events`.`id`=`messageLog`.`EventID`";
    $this->db->select($table,$where,$limit,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result());
  }
    $this->db->update('messageLog', $fields=array('Status'=>1), $where);
  }else{ echo json_encode($this->db->errorMessege());}
}
public function  RetriveInbox($inputs)
{
  $table="messageLog";
  $where=array('messageLog`.`ReciverID'=>$inputs->ReciverID);
  $limit=$inputs->start.",".$inputs->limit;
  $What="`messageLog`.`messageID`,`members`.`name` , `members`.`ProfilePic` , `messageLog`.`Subject`, `messageLog`.`type`, `messageLog`.`Status`";
  $innerJoin=  "INNER JOIN `members` ON `members`.`id`=`messageLog`.`SenderID`";
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
