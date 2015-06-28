<?php
require ("configuration.php");

class DatabaseConnect
{
public $link;
public function __construct()
{
  $this->link= mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die('Could not connect to MySQL server.');
    mysql_select_db(DB_DATABASE);
}
public function close(){
  mysql_close($this->link);
}
}
?>
