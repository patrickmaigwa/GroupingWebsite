<?php

session_start();

if(isset($_POST['submit'])){//if the submit button has been pressed... then check the following conditions
include 'dbh2.inc.php';
$uid=mysqli_real_escape_string($conn, $_POST['uid']);//for user not to input a malicious code in the input section
$pwd=mysqli_real_escape_string($conn, $_POST['pwd']);

//Error handler
//check if inputs are empty
if(empty($uid)|| empty($pwd)){
    header("Location: ../home.php?login=empty");
    exit();
}else{
    //check if the username and password are in the database
$sql="SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
 $result= mysqli_query($conn, $sql);
$resultCheck=mysqli_num_rows($result);
if($resultCheck < 1){
    header("Location: ../home.php?login=error");
    exit();
}else{
   if($row=mysqli_fetch_assoc($result)) {
       //De-hashing the password
       $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
       if ($hashedPwdCheck== false){
        header("Location: ../home.php?login=error");
        exit();
       }elseif ($hashedPwdCheck== true){
//login the user here
  $_SESSION['u_id'] = $row['user_id'];
  $_SESSION['u_first'] = $row['user_first'];
  $_SESSION['u_last'] = $row['user_last'];
  $_SESSION['u_email'] = $row['user_email'];
  $_SESSION['u_uid'] = $row['user_uid'];

header("Location: ../groupingpg.php?login=success");

exit();
       } 
       
   }
}
}

}
else{

    header("Location: ../home.php?login=error");
    exit();
}
