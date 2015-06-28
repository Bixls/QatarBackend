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
public function __construct($user) {
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;

$query = mysql_query("SELECT * FROM `members` WHERE `username` = \"".$user->username."\"") or die (mysql_error());
$sucess=false;
if ($query){
    		$row = mysql_fetch_array($query);
if($row['username']==$user->username){

echo json_encode($sucess);
}else{


  $sql = "INSERT INTO `".DB_DATABASE."`.`members` (`name`, `username`, `password`, `groupID`, `Mobile`, `ProfilePic`)
  VALUES ('".$user->name."', '".$user->username."', '".$user->password."', '".$user->groupID."', '".$user->Mobile."', '".$user->ProfilePic."');";

  if (mysql_query($sql)) {
    $id=mysql_insert_id();
  $sucess=true;
  echo json_encode($sucess);
} else {
echo json_encode($sucess);;
}

}

}


}


}



 ?>
