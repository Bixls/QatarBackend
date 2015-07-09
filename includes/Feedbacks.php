<?php

class Feedbacks{

  public function SendFeedback($inputs){
    require_once("DataBaseConnection.php");
    $dbConnect=new DatabaseConnect;

    $sql = "INSERT INTO `".DB_DATABASE."`.`Feedbacks` (`SenderID`,  `FeedbackType`, `Subject`, `Message`)
    VALUES ('".$inputs->SenderID."', '".$inputs->FeedbackType."', '".$inputs->Subject."',  '".$inputs->Message."');";

    if (mysql_query($sql)) {
        $respond = array('sucess' => true);
       echo json_encode($respond);
      //successfully Registering new user
    } else {
      $respond = array('success' => false);
     echo json_encode($respond);
    //an error has been accourd
    }
  $dbConnect->close();


}

}









?>
