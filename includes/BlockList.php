<?php
class BlockList{

  public function SetBlockList($inputs){
  //  $input->array of items i want to make it blocked
  // so i want to for get user blocklist and then remove un needed items and set only needed items
  // so stepes here will be first retrive user list , then remove un nessesary items and add un added items


  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;

  $sql=mysql_query("DELETE FROM BlockList WHERE memberID=".$inputs->memberID);
  if ($sql){
    foreach ($inputs->listArray as $key) {
      $sql = mysql_query("INSERT INTO `".DB_DATABASE."`.`BlockList` (`memberID`,`InvitationID`)
      VALUES ('".$inputs->memberID."', '".$key->id."');") or die (mysql_error());
    }
       $respond = array('sucess' => true);
    }else{
     $respond = array('sucess' => false);

    }
      echo json_encode($respond);

    $dbConnect->close();


  }
  public function GetUserBlockList($inputs){
    require_once("DataBaseConnection.php");
    $dbConnect=new DatabaseConnect;

    $sql=mysql_query("SELECT InvitationID FROM BlockList WHERE memberID=".$inputs->memberID."  ORDER BY InvitationID");

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
}













 ?>
