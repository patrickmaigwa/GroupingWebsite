<?php

// search for all male and put and put the result into a different db table
include_once 'dbh2.inc.php';
include_once 'variable.inc.php';

if(isset($_POST['grouping'])){
  $maleandfemale=$male + $female;
  $malefstf=$mfirstyear + $msecondyear + $mthirdyear + $mfourthyear;
  $femalefstf=$ffirstyear + $fsecondyear + $fthirdyear + $ffourthyear;

  if($members != $maleandfemale){
    die("Please Make sure that the number of members is equal to the number of male and female.". mysqli_connect_error());
      }else{
if($mfirstyear&&$msecondyear&&$mthirdyear&&$mfourthyear&&$ffirstyear&&$fsecondyear&&$fthirdyear&&$ffourthyear=null){

  die("None of the fields should be left blank". mysqli_connect_error());
  header("Location: ../groupingpg.php?fields should not be blank");
}else{
}}
  $members=$_POST['members'];
  $total_students="SELECT COUNT(student_name)  AS total FROM students WHERE year_of_study BETWEEN 1 AND 4";
  $runtotal=mysqli_query($conn,$total_students);
  //check if the counting was successfull
  if(!$runtotal){
    die("Error!Make sure you have uploaded the excel file.". mysqli_connect_error());
    
    }else{?>
    <div>
    </div>
    
    <?php }



  //fetching the data
  $data=mysqli_fetch_assoc($runtotal);
  //check if fetch is successful
  if(!$data){
    die("error in fetching!!!". mysqli_connect_error());
    
    }else{?>
    <div>
    </div>
    
    <?php }
  $num_rows=$data['total'];
$numgroup=($num_rows)/($members);
//check if calculation for the number of groups was successful
if(!$numgroup){
  die("Number of groups could not be calculated!!!". mysqli_connect_error());
  
  }else{?>
  <div>
  
  </div>
 
  <?php
   }


$i;
//choosing the database to be used
$choosedb=mysqli_select_db($conn,$dbname);
//checking if the database has changed successfully
if(!$choosedb){
    die("error.Database not changed successfuly". mysqli_connect_error());
    
    }else{?>
    <div>
    </div>
    <?php 
   
}

//creating temporary table for each grouping operation

$temptable="CREATE TEMPORARY TABLE studenttemptable(
  student_id   INT(11)  not null PRIMARY KEY AUTO_INCREMENT,
  student_name VARCHAR(50),     
  gender  TEXT(50),             
  year_of_study  VARCHAR(50)
   
)";

$runtemptable=mysqli_query($conn,$temptable);
if(!$runtemptable){
die("error in creating temporary table". mysqli_connect_error());


}else{?>
<div>
</div>

<?php }

//copying the students details to the temporary table
$temptablecpy ="INSERT INTO studenttemptable(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM students";
$runtemptablecpy=mysqli_query($conn,$temptablecpy);
//check if insertion to temptable is successful
if(!$runtemptablecpy){
  die("error in copying data to temporary table". mysqli_connect_error());
  
  
  }else{?>
  <div>
  </div>
  
  <?php }

for($i=1;$i<=$numgroup;$i++){
  

  //creating table for each grouping operation
  $creating_table="CREATE TABLE group$i(
    student_id   INT(11)  not null PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(50),     
    gender  TEXT(50),             
    year_of_study  VARCHAR(50)
     
 )";
 $table_query=mysqli_query($conn,$creating_table);
 if(!$table_query){
  die("error in creating table". mysqli_connect_error());
  
  
  }else{?>
  <div>
  </div>
  
  <?php }

    //for the first years
  $query1 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study AS resultf1 FROM studenttemptable
   WHERE gender='F'AND year_of_study=1 LIMIT $ffirstyear";
 $run1 = mysqli_query($conn,$query1);

 //check if first operation is successfull
 if(!$run1){
  die("error in first operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }

 $detailsdeletef1="DELETE FROM studenttemptable WHERE gender='F'AND year_of_study=1  LIMIT $ffirstyear";
 $rundetailsdeletef1=mysqli_query($conn,$detailsdeletef1);
 //check if delete was sucess
 if(!$rundetailsdeletef1){
  die("error in deleting detailsf1 in temp table". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }
 
$query2 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable 
WHERE gender='M'AND year_of_study=1  LIMIT $mfirstyear";
$run2 = mysqli_query($conn,$query2);
//check if second operation is successfull 
if(!$run2){
  die("error in second operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }
  //delete records from temp table
  $detailsdeletem1="DELETE FROM studenttemptable WHERE gender='M'AND year_of_study=1  LIMIT $mfirstyear";
  $rundetailsdeletem1=mysqli_query($conn,$detailsdeletem1);
 //check if delete was success
 if(!$rundetailsdeletem1){
  die("error in deleting detailsm1 in temp table". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }


//for the second years
$query3 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable
 WHERE gender='F'AND year_of_study=2  LIMIT $fsecondyear";
$run3 = mysqli_query($conn,$query3);

//check if second operation is successfull 
if(!$run3){
  die("error in third operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }

  //delete records from temp table
  $detailsdeletef2="DELETE FROM studenttemptable WHERE gender='F'AND year_of_study=2  LIMIT $fsecondyear";
  $rundetailsdeletef2=mysqli_query($conn,$detailsdeletef2);

 //check if delete was success
 if(!$rundetailsdeletef2){

  die("error in deleting detailsf2 in temp table". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }



$query4 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable 
WHERE gender='M'AND year_of_study=2  LIMIT $msecondyear";
$run4 = mysqli_query($conn,$query4);
//check if fourth operation is successfull 
if(!$run4){
  die("error in fourth operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }

//delete records from temp table
$detailsdeletem2="DELETE FROM studenttemptable WHERE gender='M'AND year_of_study=2  LIMIT $msecondyear";
$rundetailsdeletem2=mysqli_query($conn,$detailsdeletem2);

//check if delete was success
if(!$rundetailsdeletem2){
 die("error in deleting detailsm2 in temp table". mysqli_connect_error());
 
 }else{?>
 <div>
 </div>
 
 <?php }



//for the third years
$query5 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable 
WHERE gender='F'AND year_of_study=3 LIMIT $fthirdyear";
$run5 = mysqli_query($conn,$query5);
//check if fifth operation is successfull 
if(!$run5){
  die("error in fifth operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }

  //delete records from temp table
$detailsdeletef3="DELETE FROM studenttemptable WHERE gender='F'AND year_of_study=3  LIMIT $fthirdyear";
$rundetailsdeletef3=mysqli_query($conn,$detailsdeletef3);

//check if delete was success
if(!$rundetailsdeletef3){
 die("error in deleting detailsf3 in temp table". mysqli_connect_error());
 
 }else{?>
 <div>
 </div>
 
 <?php }

$query6 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable 
WHERE gender='M'AND year_of_study=3 LIMIT $mthirdyear";
$run6 = mysqli_query($conn,$query6);

//check if sixth operation is successfull 
if(!$run6){
  die("error in sixth operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }
  //delete records from temp table
$detailsdeletem3="DELETE FROM studenttemptable WHERE gender='M'AND year_of_study=3  LIMIT $mthirdyear";
$rundetailsdeletem3=mysqli_query($conn,$detailsdeletem3);

//check if delete was success
if(!$rundetailsdeletem3){
 die("error in deleting detailsm3 in temp table". mysqli_connect_error());
 
 }else{?>
 <div>
 </div>
 
 <?php }

//for the fourthyears
$query7 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study 
FROM studenttemptable WHERE gender='F'AND year_of_study=4 LIMIT $ffourthyear";
$run7 = mysqli_query($conn,$query7);
//check if seventh operation is successfull 
if(!$run7){
  die("error in seventh operation". mysqli_connect_error());
  
  }else{?>
  <div>
  </div>
  
  <?php }

//delete records from temp table
$detailsdeletef4="DELETE FROM studenttemptable WHERE gender='F'AND year_of_study=4  LIMIT $ffourthyear";
$rundetailsdeletef4=mysqli_query($conn,$detailsdeletef4);
//check if delete was success
if(!$rundetailsdeletef4){

 die("error in deleting detailsf4 in temp table". mysqli_connect_error());
 
 }else{?>
 <div>
 </div>
 
 <?php }


$query8 ="INSERT INTO group$i(student_name,gender,year_of_study) SELECT student_name,gender,year_of_study FROM studenttemptable 
WHERE gender='M'AND year_of_study=4 LIMIT $mfourthyear";
$run8 = mysqli_query($conn,$query8);
//check if eighth operation is successfull 
if(!$run8){
  die("error in eighth operation". mysqli_connect_error());
  
  }else{?>
  <div>
  The first round is complete
  </div>
  <?php 

 // mysqli_close($conn);
}
//delete records from temp table
$detailsdeletem4="DELETE FROM studenttemptable WHERE gender='M'AND year_of_study=4  LIMIT $mfourthyear";
$rundetailsdeletem4=mysqli_query($conn,$detailsdeletem4);

//check if delete was success
if(!$rundetailsdeletem4){

 die("error in deleting detailsm4 in temp table". mysqli_connect_error());
 
 }else{?>
 <div>
 </div>
 
 <?php }

for($i=1;$i<=$numgroup;$i++){
  
}
}

}


    //best outside the if statement so user isn't stuck on a white blank page.
header("location: ../groupingpg.php");
exit;

