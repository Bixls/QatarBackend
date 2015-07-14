<?php
$errors='';
if (isset($_POST['submit'])) {

// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];

if($username=="admin"&&$password=="admin"){
$_SESSION['username']=$username; // Initializing Session
header("location: index.php"); // Redirecting To Other Page
} else {

$errors= "Username or Password is invalid";
}


}
?>

<html lang="en">
<head>
 <title>Welcome To Qatar Admin Panel</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container" >
     <form class="form-signin" method="post" action="index.php" >


       <h2 class="form-signin-heading">Please sign in</h2>
       <label for="inputEmail" class="sr-only">Email address</label>
       <input type="Username" id="inputEmail" name="username" class="form-control" placeholder="UserName" required autofocus>
       <label for="inputPassword" class="sr-only">Password</label>
       <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
       <div class="checkbox">
         <label>
           <input type="checkbox" value="remember-me"> Remember me
         </label>
       </div>
       <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
       <br>
       <?php if($errors!=""){ ?> <div class="alert alert-danger"><?php echo $errors; ?></div><?php } ?>
     </form>

   </div> <!-- /container -->
</body>
</html>

<?php

?>
