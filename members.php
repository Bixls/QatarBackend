<?php
class member{
  public $id;
  public $name;
  public $username;
  private $password;
  public $groupID;
  public $Mobile;
  public $ProfilePic;
public $Verified;


 private $tableName="members";



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
           $ValidKey=rand( 1000 ,  9999 );
          $sql = "INSERT INTO `".DB_DATABASE."`.`members` (`name`, `username`, `password`, `groupID`, `Mobile`, `ProfilePic`, `Verified`)
          VALUES ('".$user->name."', '".$user->username."', '".$user->password."', '".$user->groupID."', '".$user->Mobile."', '".$user->ProfilePic."', '".$ValidKey."');";

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
  $query = mysql_query("SELECT * FROM `members` WHERE `username` = \"".$data->username."\"") or die (mysql_error());
      if ($query){
        $row = mysql_fetch_array($query);
        if($data->password==$row['password'])
        {
        $respond = array('success' => true);
        $user=new member;
        $user->name=$row['name'];
        $user->id=$row['id'];
        $user->username=$row['username'];
        $user->groupID=$row['groupID'];
        $user->ProfilePic=$row['ProfilePic'];
        $user->Verified=$row['Verified'];

        echo json_encode($user);
      //  echo json_encode($row);
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


}



 ?>
