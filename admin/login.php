<?php
$errors='';
if (isset($_POST['submit'])) {

// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];

if($username=="admin"&&$password=="admin"){
if(isset($_POST['remember-me'])){
  if($_POST['remember-me']){
    $cookie_name = "username";
    $cookie_value = $username;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day
}
}
$_SESSION['username']=$username; // Initializing Session
header("location: index.php");
} else {

$errors= "اسم المستخد او كلمه السر خاظئه";
}


}
?>

<html lang="ar">
<head>
 <title>مرحبا بك في لوحه التحكم</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/master/dist/cdnjs/3.3.1/css/bootstrap-rtl.min.css">

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container" >
     <form class="form-signin" method="post" action="index.php" >


       <h2 class="form-signin-heading">من فضلك قم بتسجيل الدخول</h2>
       <label for="inputEmail" class="sr-only">اسم المستخدم</label>
       <input type="Username" id="inputEmail" name="username" class="form-control" placeholder="اسم المستخدم" required autofocus>
       <label for="inputPassword" class="sr-only">كلمه السر</label>
       <input type="password" id="inputPassword" name="password" class="form-control" placeholder="كلمه السر" required>
       <div class="checkbox">
         <label>
           <input type="checkbox" name="remember-me" id="remember-me"> تذكرني
         </label>
       </div>
       <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">تسجيل دخول</button>
       <br>
       <?php if($errors!=""){ ?> <div class="alert alert-danger"><?php echo $errors; ?></div><?php } ?>
     </form>

   </div> <!-- /container -->
</body>
</html>

<?php

?>
