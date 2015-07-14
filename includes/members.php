<?php
class member{
  public $id;
  public $name;
  public $Mobile;
  private $password;
  public $groupID;
  public $ProfilePic;
  public $Verified;
  public $maskInbox;

  public $inNOR;
  public $inVIP;




public function CreateNew($user) {
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
$query = mysql_query("SELECT * FROM `members` WHERE `Mobile` = \"".$user->Mobile."\"") or die (mysql_error());
    if ($query){
        		$row = mysql_fetch_array($query);
        if($row['Mobile']==$user->Mobile){
         $respond = array('success' => false);

        echo json_encode($respond);
        //User name has been already found
        }else{
           $ValidKey=1;
          $user->password=md5($user->password);
          mysql_query("set names 'utf8'");
          $sql = "INSERT INTO `".DB_DATABASE."`.`members` (`name`,  `password`, `groupID`, `Mobile`, `ProfilePic`, `Verified`,`maskInbox`)
          VALUES ('".$user->name."', '".$user->password."', '".$user->groupID."', '".$user->Mobile."', '".$user->ProfilePic."', '".$ValidKey."','11111');";

          if (mysql_query($sql)) {
              $id=mysql_insert_id();
              $respond = array('sucess' => true,'id'=>$id);
             echo json_encode($respond);
            //successfully Registering new user
          } else {
            $respond = array('success' => false);
           echo json_encode($respond);
          //an error has been accourd
          }
        }
    }
    $dbConnect->close();
}
public function signIn($data) {
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
  $query = mysql_query("SELECT * FROM `members` WHERE `Mobile` = \"".$data->Mobile."\"") or die (mysql_error());
      if ($query){
        $row = mysql_fetch_array($query);
        if(md5($data->password)==$row['password'])
        {
        $respond = array('success' => true);
        $user=new member;
        $user->name=$row['name'];
        $user->id=$row['id'];
        $user->Mobile=$row['Mobile'];
        $user->groupID=$row['groupID'];
        $user->ProfilePic=$row['ProfilePic'];
        $user->Verified=$row['Verified']==0?true:false;
        $user->maskInbox=$row['maskInbox'];
        $user->inNOR=$row['inNOR'];
        $user->inVIP=$row['inVIP'];
        echo json_encode($user);
          //sucess
        }
        else{
         $respond = array('success' => false);
         echo json_encode($respond);
          //Faild logins is incorrect
        }
      }
    $dbConnect->close();
}
public function Verify($data) {
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $id=$data->id;
  $query = mysql_query("SELECT * FROM `members` WHERE `id` = \"".$id."\"") or die (mysql_error());
      if ($query){
        $row = mysql_fetch_array($query);
        if($id==$row['id'])
        {
          if($data->Verified==$row['Verified'])
          {
            $query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `Verified` =  '0' WHERE `id` = \"".$id."\"") or die (mysql_error());
                if ($query){
                  $respond = array('success' => true);
                  echo json_encode($respond);
                   //sucess
                }else{
                  $respond = array('success' => false);
                  echo json_encode($respond);
                   //query not posted
                }

            //sucess
          }else{
            //Failer
            $respond = array('success' => false);
            echo json_encode($respond);
             //verification is in correct
          }
        }
        else{
          $respond = array('success' => false);
          echo json_encode($respond);
           //Faild logins is incorrect
        }
    }
    $dbConnect->close();

}
public function changeAvatar($id,$src)
{
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `ProfilePic` =  '".$src."' WHERE `id` = \"".$id."\"") or die (mysql_error());
  $dbConnect->close();
  $respond = array('success' => true);
  echo json_encode($respond);
}

public function editProfile($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET
  `maskInbox` =  '".$inputs->maskInbox."' ,`name` =  '".$inputs->name."'
  WHERE `id` = \"".$inputs->id."\"") or die (mysql_error());
  $dbConnect->close();
  $respond = array('success' => true);
  echo json_encode($respond);

}
public function getUserbyID($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
$query = mysql_query("SELECT `members`.`id` , `members`.`name` , `members`.`ProfilePic` , `groups`.`Gid`, `groups`.`Gname` from `members` INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`   WHERE `members`.`id` = \"".$inputs->id."\"") or die (mysql_error());
    if ($query){
      $row = mysql_fetch_array($query);
      $respond = array('name'=>$row['name'],
      'ProfilePic'=>$row['ProfilePic'],
      'Gid'=>$row['Gid'],
      'GName'=>$row['Gname']
      );
      echo json_encode($respond);
        //sucess
      }
      else{
            $respond = array('success' => false);
              echo json_encode($respond);
      }
  $dbConnect->close();
}

public function getUsersbyGroup($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
$query = mysql_query("SELECT `members`.`id` , `members`.`name` , `members`.`ProfilePic` , `groups`.`Gid`, `groups`.`Gname` from `members` INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid` WHERE `groupID` = \"".$inputs->groupID."\"   LIMIT ".$inputs->start.", ".$inputs->limit."  ") or die (mysql_error());
$stack = array();
    while($row = mysql_fetch_array($query)){

      $user = array(
      'id'=>$row['id'],
      'name'=>$row['name'],
      'ProfilePic'=>$row['ProfilePic']
      );

    array_push($stack, $user);
    }
 echo json_encode($stack);
  $dbConnect->close();
}

public function searchUsers($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
$query = mysql_query("SELECT `members`.`id` , `members`.`name` , `members`.`ProfilePic` , `groups`.`Gid`, `groups`.`Gname` from `members` INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid` WHERE `members`.`name` LIKE \"%".$inputs->Key."%\"   LIMIT ".$inputs->start.", ".$inputs->limit."  ") or die (mysql_error());

$stack = array();
    while($row = mysql_fetch_array($query)){

      $user = array(
      'id'=>$row['id'],
      'name'=>$row['name'],
      'ProfilePic'=>$row['ProfilePic'],
      'GroupID'=>$row['Gid'],
      'GroupName'=>$row['Gname'],
      );

    array_push($stack, $user);
    }
 echo json_encode($stack);
  $dbConnect->close();
}

public function addInvPoints($inputs){



  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;


  //UPDATE values in members db
  $MembersQuery = mysql_query("SELECT `inNOR` , `inVIP` FROM `members` WHERE `id` = \"".$inputs->memberID."\"  ") or die (mysql_error());
	$membersRow = mysql_fetch_array($MembersQuery);

  $invitationsQuery = mysql_query("SELECT  `number` ,`VIP` FROM `invitationPackages` WHERE `Packageid` = \"".$inputs->invitationID."\"  ") or die (mysql_error());
  $invitationsRow = mysql_fetch_array($invitationsQuery);

$oldInvitations=0;



if($invitationsRow['VIP']==0){

$oldInvitations=$membersRow['inNOR'];
$newNumber=$oldInvitations+$invitationsRow['number'];
  $query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `inNOR` =  '".$newNumber."'  WHERE `id` = \"".$inputs->memberID."\"") or die (mysql_error());

}elseif($invitationsRow['VIP']==1){

$oldInvitations=$membersRow['inVIP'];
$newNumber=$oldInvitations+$invitationsRow['number'];
  $query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `inVIP` =  '".$newNumber."'  WHERE `id` = \"".$inputs->memberID."\"") or die (mysql_error());

}
require_once("Functions.php");
$ip=get_client_ip();

$sql = "INSERT INTO `".DB_DATABASE."`.`purchasing_records` (`memberID`,  `invitationID`,`IP`)
VALUES ('".$inputs->memberID."', '".$inputs->invitationID."','".$ip."');";
mysql_query($sql);


  $dbConnect->close();
  $respond = array('success' => true);
  echo json_encode($respond);



}


public function getUserInvNumber($inputs) {
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
    $MembersQuery = mysql_query("SELECT `inNOR` , `inVIP` FROM `members` WHERE `id` = \"".$inputs->id."\"  ") or die (mysql_error());
  	$membersRow = mysql_fetch_array($MembersQuery);
if($membersRow){
  $respond = array('success' => true,
  'inNOR'=>$membersRow['inNOR'],
  'inVIP'=> $membersRow['inVIP']

  );

         echo json_encode($respond);
}
else{
  $respond = array('success' => false);
  echo json_encode($respond);
  }
$dbConnect->close();
}

}



 ?>
