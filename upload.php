<?php
require_once("configuration.php");
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'You dont have acess to this file';
        exit;
    } else {
                if($_SERVER['PHP_AUTH_USER']==AUSER&&$_SERVER['PHP_AUTH_PW']==APASS)
                {

                  $TicketId=0;
                  require_once("includes/DataBaseConnection.php");
                  $dbConnect=new DatabaseConnect;
                  $sql = "INSERT INTO `".DB_DATABASE."`.`Images` (`imageID`) VALUES (NULL)";
                  if (mysql_query($sql)) {
                  $TicketId=mysql_insert_id();
                  $uploadOk = 1;
                  $dbConnect->close();
                  }
                  else{
                  $uploadOk=0;
                  }



            $PicType=$_POST["type"];
            $target_dir = "uploads/".date("Ym")."/".$PicType."/";


            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0775, true);
            }




            $imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
            $FileName=$target_dir .$TicketId;
            $target_file = $target_dir .$TicketId.".".$imageFileType;
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
                $dbConnect=new DatabaseConnect;
                mysql_query("DELETE  FROM `Images` WHERE `imageID`=".$TicketId."");
                $dbConnect->close();
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                    $respond = array('success' => true,'id'=>$TicketId);
                    createthumb($target_file,$FileName."150x150.".$imageFileType,150,150);
                    $dbConnect=new DatabaseConnect;
                    mysql_query("UPDATE `".DB_DATABASE."`.`Images` SET `imageSrc` = '".$FileName."', `ext` = '".$imageFileType."' WHERE `Images`.`imageID` = ".$TicketId."");
                    echo json_encode($respond);
                    //SUCESS uploading
                } else {
                  $respond = array('success' => false);
                  echo json_encode($respond);

                    $dbConnect=new DatabaseConnect;
                    mysql_query("DELETE  FROM `Images` WHERE `imageID`=".$TicketId."");
                    $dbConnect->close();

                }
            }
        }
    }


    function createthumb($name,$filename,$new_w,$new_h)
    {
    	$system=explode(".",$name);
    	if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
    	if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
    	$old_x=imageSX($src_img);
    	$old_y=imageSY($src_img);
    	if ($old_x > $old_y)
    	{
    		$thumb_w=$new_w;
    		$thumb_h=$old_y*($new_h/$old_x);
    	}
    	if ($old_x < $old_y)
    	{
    		$thumb_w=$old_x*($new_w/$old_y);
    		$thumb_h=$new_h;
    	}
    	if ($old_x == $old_y)
    	{
    		$thumb_w=$new_w;
    		$thumb_h=$new_h;
    	}
    	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
    	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
    	if (preg_match("/png/",$system[1]))
    	{
    		imagepng($dst_img,$filename);
    	} else {
    		imagejpeg($dst_img,$filename);
    	}
    	imagedestroy($dst_img);
    	imagedestroy($src_img);
    }

?>
