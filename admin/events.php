<?php
$table="Events";
$per_page = 5;
$where=array( );
$title="Events admin panel";
$list = array('id'=>'id' ,'Group Name'=>'subject','is VIP'=>'VIP','Event Type'=>'eventType','Picture'=>'picture');
$customeFileds= array('Approve' =>"approve.php?id=" ,
                      'Delete'=>"delete.php?id=");

require_once("View.php");

class events{

public function ViewUnApprovedEventList(){

}
public function ViewEventList(){

}
public function getEventsbyMember($memberID){

}
public function SearchEventsByName($searcher){
  
}
public function approveEvent($id){

}
public function disApproveEvent($id){

}
public function RemoveEvent($id){

}
public function ViewEvent($id){

}

}


 ?>
