<?php
require_once("configuration.php");
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    if($_SERVER['PHP_AUTH_USER']==AUSER&&$_SERVER['PHP_AUTH_PW']==APASS)
    {
$id=$_POST["id"];

$target_dir = "uploads/".date("Ym")."/";


if (!file_exists($target_dir)) {
    mkdir($target_dir, 0775, true);
}


$uploadOk = 1;
$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
$target_file = $target_dir .$id."-".date("his").".".$imageFileType;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {


        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {

    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $respond = array('success' => false);
    echo json_encode($respond);

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        require_once("includes/members.php");
        $newMember=new member;
        $newMember->changeAvatar($id,$target_file);
        $respond = array('success' => true);
        echo json_encode($respond);
        //SUCESS uploading
    } else {
      $respond = array('success' => false);
      echo json_encode($respond);
    }
}


}
}
?>
