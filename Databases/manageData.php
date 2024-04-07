<?php


function updateData($username,$bookname,$issueDate,$returnDate){

    //Connection Of Databases
    $dbconn=getconn();

    $UserName = $username;
    $BookName = $bookname;
    $IssueDate  =$issueDate;
    $ReturnDate = $returnDate;

    
    

    $sqlBookAvailability="UPDATE `books` SET `Availability`='Not_Available' WHERE Book_Title='$BookName' && Availability='Available'
    ORDER BY RAND()
    LIMIT 1
    ";

    $sqlBookQuantity = "UPDATE `books` SET `Book_Quantity` = `Book_Quantity`-1 WHERE Book_Title='$BookName'";

    $BookUpdate=mysqli_query($dbconn,$sqlBookQuantity);
    $BookUpdate=mysqli_query($dbconn,$sqlBookAvailability);

    $sqlUserBorrowed="UPDATE `users` SET `Borrowed_Book`='Yes' WHERE User_Name='$UserName'";
    $UserUpdate=mysqli_query($dbconn,$sqlUserBorrowed);

}


   
?>