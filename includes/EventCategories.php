<?php



class EventCategories{

public $catID;
public $catName;


public function getEventCategories(){

require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
mysql_query("set names 'utf8'");
$query = mysql_query("SELECT * FROM `EventCatigories` ") or die (mysql_error());
$stack = array();
  while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
  array_push($stack , $row);
  }
    echo json_encode($stack);
    $dbConnect->close();
}

}







 ?>
