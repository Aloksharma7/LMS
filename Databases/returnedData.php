<?php

include_once 'conn.php';
$conn = getconn();

//Delet Manage
 if($_POST['RMname']){
    $ManageUserName = $_POST['RMname'];
    $BookName = $_POST['RBname'];
    echo $ManageUserName;
    
    $updateManageData = "UPDATE `manage` SET Returned = '1' WHERE UserName = '$ManageUserName'";
    $updateUser = "UPDATE `users` SET `Borrowed_Book`='No' WHERE User_Name='$ManageUserName'";
    $updateBook = "UPDATE `books` SET `Availability`='Available' WHERE Book_Title='$BookName' && Availability='Not_Available'
    ORDER BY RAND()
    LIMIT 1
    ";

    $sqlBookQuantity = "UPDATE `books` SET `Book_Quantity` = `Book_Quantity`+1 WHERE Book_Title='$BookName'";
    $BookUpdate=mysqli_query($conn,$sqlBookQuantity);

    $result=mysqli_query($conn,$updateManageData);
    $result2=mysqli_query($conn,$updateUser);
    $result3=mysqli_query($conn,$updateBook);

    if($result && $result2 && $result3){
        echo "data returned $ManageUserName";
    header("location:../pages/manage.php");
    }

}

else{
    echo "hello";
}


/// Functionalities
function getBookName($Fusername){
    include_once 'conn.php';
    $conn = getconn();

    echo "FuncData : $Fusername";
    $getBookNameSql = "SELECT BookName FROM `manage` WHERE UserName='$Fusername'";
    $resultBook=mysqli_query($conn,$getBookNameSql);

    return $resultBook;
}

function getUserName($bUsername){
    include_once 'conn.php';
    $conn = getconn();

    $getBUsername = "SELECT UserName FROM `manage` WHERE BookName='$bUsername'";
    $resultUser = mysqli_query($conn, $getBUsername);
    return $resultUser;
}

?>