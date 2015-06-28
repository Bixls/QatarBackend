<?php

class Groups{

public  $id;
public  $name;
public  $ProfilePic;

public  function getGroupList($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `groups` LIMIT ".$inputs->limit."") or die (mysql_error());
  $stack = array();
      while($row = mysql_fetch_array($query)){
        $group=new Groups;
        $group->id=$row['id'];
        $group->name=$row['name'];
        
      array_push($stack, $group);
      }
   echo json_encode($stack);
    $dbConnect->close();

  }


}















 ?>
