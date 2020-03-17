<!DOCTYPE html>
<html>
<title> Excel file in database</title>
<body>
<?php 
include('dbh2.inc.php');
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
</form>
</body>
 
</html>