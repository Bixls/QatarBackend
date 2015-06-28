<?php
class member{
  public $id;
  public $name;
  public $username;
  public $password;
  public $groupID;
  public $Mobile;
  public $ProfilePic;
 public $tableName="members";

public function CreateNew($user) {
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;

$query = mysql_query("SELECT * FROM `members` WHERE `username` = \"".$user->username."\"") or die (mysql_error());

if ($query){
    		$row = mysql_fetch_array($query);
if($row['username']==$user->username){

 $respond = array('success' => false);
echo json_encode($respond);
//User name has been already found
}else{


  $sql = "INSERT INTO `".DB_DATABASE."`.`members` (`name`, `username`, `password`, `groupID`, `Mobile`, `ProfilePic`)
  VALUES ('".$user->name."', '".$user->username."', '".$user->password."', '".$user->groupID."', '".$user->Mobile."', '".$user->ProfilePic."');";

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


}


}



 ?>
