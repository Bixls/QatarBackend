<?php

class invitationPackages{
  public  $id;
  public  $packageName;
  public  $number;
  public  $VIP;
  public  $price;

public function getInvitationList($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `invitationPackages` LIMIT ".$inputs->limit."") or die (mysql_error());
  $stack = array();
      while($row = mysql_fetch_array($query)){
        $invitations=new invitationPackages;
        $invitations->id=$row['Packageid'];

        $invitations->number=$row['number'];
        $invitations->packageName=$row['packageName'];
        //$invitations->VIP=$row['VIP'];
        $invitations->price=$row['price'];
      array_push($stack, $invitations);
      }
   echo json_encode($stack);
    $dbConnect->close();


}

}


 ?>
