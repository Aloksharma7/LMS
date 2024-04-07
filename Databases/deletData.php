<?php

include_once 'conn.php';
$conn = getconn();
//Delet User
if( isset($_POST['uname'])){
    $username = $_POST['uname'] ;
    $bookname = getBookName($username);
    

    while($uBData=mysqli_fetch_assoc($bookname)){
        $uBookName = $uBData['BookName'];
    }
    // echo "<br>Out while: $username";
    // echo "<br>After: $uBookName";


    $delSqlUser = "DELETE FROM `users` WHERE User_Name = '$username'";
    $delSqlManage = "DELETE FROM `manage` WHERE UserName = '$username'";
    $bUpdate = "UPDATE `books` SET `Availability`='Available' WHERE Book_Title='$uBookName' && Availability='Not_Available'";

    $sqlBookQuantity = "UPDATE `books` SET `Book_Quantity` = `Book_Quantity`+1 WHERE Book_Title='$BookName'";
    $BookUpdate=mysqli_query($conn,$sqlBookQuantity);

    $result=mysqli_query($conn,$delSqlUser);
    $result2=mysqli_query($conn,$delSqlManage);
    $result3=mysqli_query($conn,$bUpdate);
    if($result && $result2 && $result3){
        $msg = "deleted";
    header("location:../pages/users.php?msg=$msg");
    }
}
//Delet Book
else if(isset($_POST['booktitle'])){
    $booktitle = $_POST['booktitle'] ;
    $bUsername = getUserName($booktitle);
    echo $bookid;
    echo $booktitle;
    while($bUData=mysqli_fetch_assoc($bUsername)){
        $bUName = $bUData['UserName'];
    }

    $delSqlBook = "DELETE FROM `books` WHERE Book_Title = '$booktitle'";
    $delSqlManageB = "DELETE FROM `manage` WHERE BookName = '$booktitle'";
    $Uupdate = "UPDATE `users` SET `Borrowed_Book`='No' WHERE User_Name='$bUName'";
    $result=mysqli_query($conn,$delSqlBook);
    $result2=mysqli_query($conn,$delSqlManageB);
    $result3=mysqli_query($conn,$Uupdate);
    if($result && $result2 && $result3){
        $msg = "deleted";
    header("location:../pages/books.php?msg=$msg");
    }
}

//Delet Manage
else if(isset($_POST['Mname'])){
    $ManageUserName = $_POST['Mname'];
    $ManageUserID = $_POST['RMid'];
    $BookName = $_POST['Bname'];
    echo $ManageUserName;

    $useruser = UserName($ManageUserID);
    while($newData=mysqli_fetch_assoc($useruser)){
        $newnewData = $newData['Returned'];
    }

    echo $newnewData;
    if($newnewData === '0'){
        $delManageData = "DELETE FROM `manage` WHERE DataID = '$ManageUserID'";
        $updateUser = "UPDATE `users` SET `Borrowed_Book`='No' WHERE User_Name='$ManageUserName'";
        $updateBook = "UPDATE `books` SET `Availability`='Available' WHERE Book_Title='$BookName' && Availability='Not_Available'
        ORDER BY RAND()
        LIMIT 1
        ";

        $sqlBookQuantity = "UPDATE `books` SET `Book_Quantity` = `Book_Quantity`+1 WHERE Book_Title='$BookName'";
        $BookUpdate=mysqli_query($conn,$sqlBookQuantity);
        
        $result=mysqli_query($conn,$delManageData);
        $result2=mysqli_query($conn,$updateUser);
        $result3=mysqli_query($conn,$updateBook);
    
    }
    else{
        $delManageData = "DELETE FROM `manage` WHERE DataID = '$ManageUserID'";
        $result=mysqli_query($conn,$delManageData);
    }
    

    if($result ){
        echo "data deleted $ManageUserName";
        $msg = "deleted";
    header("location:../pages/manage.php?msg=$msg");
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
function UserName($DataId){
    include_once 'conn.php';
    $conn = getconn();

    $getUserDetails = "SELECT * FROM `manage` WHERE DataID='$DataId'";
    $resultUserName = mysqli_query($conn, $getUserDetails);
    return $resultUserName;
}

?>