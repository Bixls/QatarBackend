<?php

class Groups{

public  $Gid;
public  $Gname;
public  $ProfilePic;

public  function getGroupList($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `groups` LIMIT ".$inputs->limit."") or die (mysql_error());
  $stack = array();
      while($row = mysql_fetch_array($query)){
          $respond = array(
            'id' => $row['Gid'],
            'name' => $row['Gname'],
            'ProfilePic' => $row['ProfilePic'],
            );
      array_push($stack, $respond);
      }
   echo json_encode($stack);
    $dbConnect->close();

  }


}















 ?>
