<?php

 include 'conn.php';

//Connection Of Databases
$conn=getconn();
// Code to Create 'books' Table if not exists
$sqlBook = "CREATE TABLE IF NOT EXISTS books (
    Book_id INT AUTO_INCREMENT PRIMARY KEY,
    Book_Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Publication VARCHAR(255) NOT NULL,
    Book_Edition VARCHAR(255) NOT NULL,
    Book_Quantity VARCHAR(255) NOT NULL,
    BookCV LONGTEXT NOT NULL,
    Availability VARCHAR(255) NOT NULL DEFAULT 'Available'
)";

// Code to Create 'users' Table if not exists
$sqlUser = "CREATE TABLE IF NOT EXISTS users (
    User_Name VARCHAR(255) PRIMARY KEY,
    Full_Name VARCHAR(255) NOT NULL ,
    SClass INT NOT NULL,
    Department VARCHAR(255) NOT NULL,
    Section VARCHAR(255) NOT NULL,
    Roll VARCHAR(255) NOT NULL,
    Phone BIGINT NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Borrowed_Book VARCHAR(255) NOT NULL DEFAULT 'No',
    Profile_Pic LONGTEXT NOT NULL
    )";

$sqlManage = "CREATE TABLE IF NOT EXISTS manage (
    DataID BIGINT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(255) NOT NULL ,
    BookName VARCHAR(255) NOT NULL,
    Issued_Date DATE NOT NULL,
    Return_Date DATE NOT NULL,
    Returned INT DEFAULT '0',
    OverDate INT DEFAULT '1'

    )";

// Create 'books' Table if not exists
if ($conn->query($sqlBook) === TRUE) {
    echo "Books Table created successfully";
} else {
    echo "Users Error creating Books table: " . $conn->error;
}

//  Create 'users' Table if not exists
if ($conn->query($sqlUser) === TRUE) {
    echo " Users Table created successfully";
} else {
    echo "Users Error creating Users table: " . $conn->error;
}

// if ($conn->query($sqlManage) === TRUE) {
//     echo "Manage Table created successfully";
// } else {
//     echo "Users Error creating Manage table: " . $conn->error;
// }


// INSERT Data into Table of Books
if($_POST['title']==true){
    // $stuid=$_POST['stuid'];
    $title=ucwords( $_POST['title']);
    $author=ucwords($_POST['author']);
    $publication=ucwords($_POST['publication']);
    $edition=$_POST['edition'];
    $quantity=$_POST['quantity'];

    /// Image Uploading
	$filename = $_FILES["coverimage"]["name"];
	$tempname = $_FILES["coverimage"]["tmp_name"];
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $uniqueName = uniqid() . "." . $fileExtension;
	$folder = "../Photos/BookCV/" . $uniqueName;

	// Now let's move the uploaded image into the folder: image
	if (move_uploaded_file($tempname, $folder)) {
        for($i=0; $i<$quantity;$i++){

            $sqlBook="INSERT INTO books (Book_Title, Author , Publication, Book_Edition, Book_Quantity,BookCV) VALUES ('$title','$author','$publication', '$edition', '$quantity' ,'$uniqueName');";
            $result=mysqli_query($conn,$sqlBook);
         }
         
	} 
    /// Image uploading
    if($result ){
    //echo "Data inserted succesfully (Books)";
    $msg="success";
    header("location:../pages/books.php?msg=$msg");
    }
    else{
    $msg="Failed";
    header("location:../pages/books.php?msg=$msg");
    echo "Please Enter Valid Information !!";
    }
}



// INSERT Data into Table of Users
else if($_POST['name']==true){
$Uname=strtolower($_POST['Uname']);
$Uname = str_replace(' ', '_', $Uname);

$checkUsername = mysqli_query($conn,"Select * from users");
$SameName=0;
while($data=mysqli_fetch_assoc($checkUsername)){

    if($Uname == $data['User_Name']){
        $SameName=1;
        break;
    }

}

$name=strtolower($_POST['name']);
$name=ucwords($name);
$sclass=$_POST['sclass'];
$department=$_POST['department'];
$section=$_POST['section'];
$roll=$_POST['roll'];
$phone=$_POST['phone'];
$email=$_POST['email'];

// Profile Pic uploading
$Pfilename = $_FILES["profilePic"]["name"];
$Ptempname = $_FILES["profilePic"]["tmp_name"];
$PfileExtension = strtolower(pathinfo($Pfilename, PATHINFO_EXTENSION));
$PuniqueName = uniqid() . "." . $PfileExtension;
$Pfolder = "../Photos/Profile_Pic/" . $PuniqueName;

// Now let's move the uploaded image into the folder: image
if (move_uploaded_file($Ptempname, $Pfolder)) {
  
if($SameName==0){
$sqlUser="INSERT INTO users (User_Name,Full_Name, SClass, Department, Section, Roll, Phone, Email,Profile_Pic) VALUES ('$Uname','$name', '$sclass', '$department', '$section', '$roll', '$phone', '$email','$PuniqueName');";
$result=mysqli_query($conn,$sqlUser);
    echo "Data inserted succesfully (Users)";
    $msg="success";
    header("location:../pages/users.php?msg=$msg");
    // return 'success';
}
else{
    //echo "Data inserted succesfully (Users)";
    $msg="Invalid UserName";
    header("location:../pages/users.php?msg=$msg");
}}
}


// INSERT Data into Table of Manage

else if($_POST['UsersName']==true){

    include "manageData.php";

    
    $username = $_POST['UsersName'];
    $bookname = $_POST['BooksName'];
    $issueDate = $_POST['issueDate'];
    $returnDate = $_POST['returnDate'];


$sqlManage="INSERT INTO manage (UserName, BookName, Issued_Date, Return_Date) VALUES ('$username', '$bookname', '$issueDate', '$returnDate');";
$result=mysqli_query($conn,$sqlManage);
if($result){

    updateData($username,$bookname,$issueDate,$returnDate);

    echo "Data inserted succesfully (Manage)";
    $msg="success";
    header("location:../pages/manage.php?msg=$msg");
    // return 'success';
}
else{
    $msg="Failed";
    header("location:../AddBooks.php?msg=$msg");
    echo "Please Enter Valid Information !!";
}

}
?>