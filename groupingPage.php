
<?php
 include_once 'header2.php';
  ?>
        <nav>
          <ul>
            <li class="currentlogout">
              <form action="includes/logout2.inc.php" method="POST">
              <button type="submit" name="logout">Logout</button>
        </form>
         </li>
          </ul>
        </nav>
      </div>
    </header>
    </body>
    <body class="body2">
    
  <!--for the file uploading-->
  <?php 
include_once 'includes/dbh2.inc.php';



//include_once'includes/variable.inc.php';

?>
  <?php
  
if(isset($_POST['uploadBtn'])){
    $fileName= $_FILES['myfile']['name'];
    $fileTmpName=$_FILES['myfile']['tmp_name'];
//finding the extension of the file
$fileExtension=pathinfo($fileName,PATHINFO_EXTENSION);
//define you allowed extension
$allowedType= array('csv');
if (!in_array($fileExtension,$allowedType)){?>
<div>
Invalid File extension
</div>

}

<?php } else{
//upload your file
$handle =fopen($fileTmpName,'r');//read mode 'r'
while(($myData=fgetcsv($handle,1000,',')) !==FALSE){
    $student_name=$myData[0];
    $gender=$myData[1];
    $year_of_study=$myData[2];
  
    $query="insert into students(student_name,gender,year_of_study) 
    values('".$student_name."','".$gender. "','".$year_of_study. "')";
   
    $run = mysqli_query($conn,$query);
}
if(!$run){
die("error in uploading file". mysqli_connect_error());

}else{?>
<div>File Uploaded Successfully!!!
</div>

<?php }

}

}

?>

<form action="" method="post" enctype="multipart/form-data"> 
<h3>upload your file</h3>
<hr/>
<div>
<input type="file"  name="myfile">
</div>
<div>
<div>
<div>
<input type="submit" name="uploadBtn">
</div>
</div>
</div>
</form><?php
//best outside the if statement so user isn't stuck on a white blank page.


?>
 <!-- <section class="body-page2">-->
  
	
 
  <div class ="forgrouping-box">
  <form action="includes/grouping.inc.php" method="POST">
  <p>Please insert the number of members to be in  each group  :</p>
  
  <input type="text" name="members" placeholder=" number of Members">
  <p>Please insert the  desired number of each category to be in each group  :</p>
  <p>For Male:</p>
   <input type="text" name="male" placeholder=" number of Males">
    <input type="text" name="mfirstyear" placeholder=" number of First year">
     <input type="text" name="msecondyear" placeholder=" number of second year">
    
      <input type="text" name="mthirdyear" placeholder=" number of Third year">
       <input type="text" name="mfourthyear" placeholder=" number of Fourth year">
      
      <p>For female:</p>
        <input type="text" name="female" placeholder=" number of Female">
         <input type="text" name="ffirstyear" placeholder=" number of First year">
     <input type="text" name="fsecondyear" placeholder=" number of second year">
    
      <input type="=text" name="fthirdyear" placeholder=" number of Third year">
       <input type="text" name="ffourthyear" placeholder=" number of Fourth year">
       <br>
       <button type="submit" name="grouping">Go to Grouping Operation </button>
       <br>
       <button type="submit" name="getpdf">see results in  pdf </button>
       
       </form>
        
        <!--<form  method="POST">
         <input type="submit" name="submit" value="Print file">
            <p>Username</p>
            <input type="text" name="uid" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="pwd" placeholder="Enter Password">
            <button type="submit" name="submit">Login</button><br/>
            <a href="#">Forget Password</a>    
            </form>-->

  </div>
  </section>

  <?php
  include_once 'footer2.php';
  exit();
  ?>