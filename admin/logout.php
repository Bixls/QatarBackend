<?php
session_start();
if(isset($_COOKIE["username"])){
  $cookie_name = "username";
  setcookie($cookie_name, "", time() - 3600);
}

if(session_destroy()) // Destroying All Sessions
{
header("Location: index.php"); // Redirecting To Home Page
}
?>
