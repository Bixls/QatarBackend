<?php
class member{
  public $id;
  public $name;
  public $Mobile;
  private $password;
  public $groupID;
  public $ProfilePic;
  public $Verified;




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
           $ValidKey=rand( 1000 ,  9999 );
          mysql_query("set names 'utf8'");
          $sql = "INSERT INTO `".DB_DATABASE."`.`members` (`name`,  `password`, `groupID`, `Mobile`, `ProfilePic`, `Verified`)
          VALUES ('".$user->name."', '".$user->password."', '".$user->groupID."', '".$user->Mobile."', '".$user->ProfilePic."', '".$ValidKey."');";

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
        if($data->password==$row['password'])
        {
        $respond = array('success' => true);
        $user=new member;
        $user->name=$row['name'];
        $user->id=$row['id'];
        $user->Mobile=$row['Mobile'];
        $user->groupID=$row['groupID'];
        $user->ProfilePic=$row['ProfilePic'];
        $user->Verified=$row['Verified']==0?true:false;
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
public function getPic(){

}


}



 ?>
