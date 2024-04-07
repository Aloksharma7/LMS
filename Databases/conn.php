<?php

function getconn(){
$hostname="localhost";
$username="root";
$password="";
$dbname="LMS";

$conn=mysqli_connect($hostname,$username,$password,$dbname);

if($conn){
    
    return $conn;
}
else{
   return mysqli_connect_error();
}
}
?>