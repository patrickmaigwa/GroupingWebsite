<?php
if(isset($_POST['submit'])){
include_once 'dbh2.inc.php';
$first =mysqli_real_escape_string($conn, $_POST['first']);
$last =mysqli_real_escape_string($conn, $_POST['last']);
$email =mysqli_real_escape_string($conn, $_POST['email']);
$uid =mysqli_real_escape_string($conn, $_POST['uid']);
$pwd =mysqli_real_escape_string($conn, $_POST['pwd']);

//Error handlers
//check for empty fields
 if(empty($first)||empty($last)||empty($email)||empty($uid)||empty($pwd)){
    header("Location: ../signup2.php?signup=empty");
    exit();
 }else{

    //check if input characters are valid
    if(!preg_match("/^[a-zA-Z]*$/",$first)||!preg_match("/^[a-zA-Z]*$/",$last))
    {
        header("Location: ../signup2.php?signup=invalid");
    exit();
    }else{
      //check if email is valid
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup2.php?signup=email");
        exit();
      } else{
       //check if username is in the database ie if username is already used
       $sql="SELECT * FROM users WHERE user_uid='$uid'";
       $result=mysqli_query($conn, $sql); 
       $resultCheck=mysqli_num_rows($result);  
       if($resultCheck >0){
        header("Location: ../signup2.php?signup=usertaken");
        exit();
       }else{
          //hashing the password
          $hashedpwd= password_hash($pwd, PASSWORD_DEFAULT);
 //INSERT THE USER INTO THE DATABASE
 $sql="INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedpwd');";
 mysqli_query($conn, $sql);
 header("Location: ../signup2.php?signup=success");
 header("Location: ../login2.php");
 exit();
       }
      }
    }
 }
}else{
    header("Location: ../login2.php");
    exit();
}