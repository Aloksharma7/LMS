<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <title>LMS</title>
</head>
<body>
    <div class="main">
        
        <div class="header">
            <h1>Library Management System</h1>
        </div>

        <div class="middle">
            <!-- Contains All the Browsering Feature -->
        <div class="sidebar">

            <div class="userDetails">
                <div class="picture"><img src="./Photos/admin.jpg" alt="User Profile"></div>
                <div class="info">
                <span class="username">Raju Sharma</span>
                <span class="role">Admin</span>
                </div>
            </div>
            <!-- Menus for Navigation -->
            <div class="menus">
                <ul>
                    <li class="focus"><a href="./" >Dashboard</a></li>
                    <li><a href="./Pages/books.php">Books</a></li>
                    <li><a href="./Pages/users.php">Users</a></li>
                    <li><a href="./Pages/manage.php">Records</a></li>
                </ul>
            </div>
            
        </div>
        <!-- Contains all the infromation of Dashboard to be displayed -->
        <div class="contents">
            <h3>Total</h3>
            <div class="divider"></div>
            <section class="total">

                <section class="totalBooks totalTheme" id="totalBooks">
                    <span class="BooksCount">
                    <?php $Total_Book = getTotalBooks(); echo $Total_Book;   ?>
                    </span>
                    <span>Books</span>
                    <img src="./Photos/stack-of-books.png" alt="Book Png">
                </section>

                <section class="totalUsers totalTheme" id="totalUsers">
                    <span class="UsersCount">
                    <?php $Total_User = getTotalUsers(); $Total_Users = $Total_User->num_rows; echo $Total_Users;   ?>
                    </span>
                    <span>Users</span>
                    <img src="./Photos/group_black.png" alt="Book Png">
                </section>

                <section class="totalAuthors totalTheme" id="totalRecords">
                    <span class="AuthorsCount">
                    <?php $Total_Manage = getTotalManage(); echo $Total_Manage;   ?>
                    </span>
                    <span>Records</span>
                    <img src="./Photos/checklist_black.png" alt="Book Png">
                </section>

            </section>
            
            <!-- All books infromation -->
            <h3>Books</h3>
            <div class="divider"></div>
            <section class="Books">

                <section class="issuedBooks totalbooktheme">
                    <span class="icon"><img src="./Photos/send.png" alt="OverDue" width="60px" height="60px" style="margin-left: -10px;"></span>
                    <span class="coldata">
                    <span class="btitle">Issued</span>
                    <span class="issuedBooksCount Counts">
                    <?php $Total_IssuedBooks = getIssuedBooks(); echo $Total_IssuedBooks;   ?>
                    </span>
                    </span>
                </section>

                <section class="returnedBooks totalbooktheme">
                    <span class="icon"><img src="./Photos/likeGreen.png" alt="Returned" width="110px" height="110px"></span>
                    <span class="coldata">
                    <span class="btitle">Returned</span>
                    <span class="returnedBooksCount Counts">
                    <?php $Total_ReturnedBooks = getReturnedBooks(); echo $Total_ReturnedBooks;   ?>
                    </span>
                    </span>
                </section>

                <section class="overDue totalbooktheme">
                    <span class="icon"><img src="./Photos/Red-Dislike.png" alt="OverDue" width="110px" height="110px"></span>
                    <span class="coldata">
                    <span class="btitle">OverDue</span>
                    <span class="overDueBooksCount Counts">
                    <?php $Total_OverDate = getOverDate(); echo $Total_OverDate;   ?>
                    </span>
                    </span>
                </section>

                <section class="available totalbooktheme">
                    <span class="icon"><img src="./Photos/available_black.png" alt="OverDue" width="85px" height="85px"></span>
                    <span class="coldata">
                    <span class="btitle">Available</span>
                    <span class="availableBooksCount Counts">
                    <?php $Total_AvailableBooks = getAvailableBooks(); echo $Total_AvailableBooks;   ?>
                    </span>
                    </span>
                </section>

                <!-- <section class="requested totalbooktheme">
                    <span class="icon">.</span>
                    <span class="coldata">
                    <span class="btitle">Requested</span>
                    <span class="returnedBooksCount Counts">3</span>
                    </span>
                </section> -->

            </section>

            <h3>New Users</h3>
            <div class="divider"></div>
            <section class="newUsers">
            <?php 
            $newUsers = getTotalUsers();
            for($i=0;$i<4;$i++){
            $data=mysqli_fetch_assoc($newUsers);
            ?>
                <section class="user1 newuserstheme">
                    <span class="bookCover">
                        <img src="./Photos/Profile_Pic/<?php echo $data['Profile_Pic'];  ?>" alt="user" height="200px" width="150px"></span>
                    <span class="coldata">
                    <span class="bookName"><?php echo $data['Full_Name']; ?></span>
                    <span>Class <?php echo $data['SClass']; ?></span>
                    </span>
                </section>
                <?php }?>

            </section>
        </div>
        </div>
    </div>
</body>
</html>


<?php

function getTotalUsers(){
    include_once "./Databases/conn.php";
    
    $conn=getconn();
    $sqlUser="Select * from users";
    $Users=mysqli_query($conn,$sqlUser);
    return $Users;
}

function getTotalBooks(){
     include_once "./Databases/conn.php";
    $conn=getconn();
    $sqlBook="Select * from books";
    $Books=mysqli_query($conn,$sqlBook);
    $Total_Books = $Books->num_rows;
    return $Total_Books;
}

function getTotalManage(){
    include_once "./Databases/conn.php";
   $conn=getconn();
   $sqlManage="Select * from manage";
   $Manage=mysqli_query($conn,$sqlManage);
   $Total_Manage = $Manage->num_rows;
   return $Total_Manage;
}

function getIssuedBooks(){
    include_once "./Databases/conn.php";
   $conn=getconn();
   $sqlIssuedBooks="Select * FROM `books` WHERE Availability='NOt_Available'";
   $IssuedBooks=mysqli_query($conn,$sqlIssuedBooks);
   $Total_IssuedBooks = $IssuedBooks->num_rows;
   return $Total_IssuedBooks;
}


function getReturnedBooks(){
    include_once "./Databases/conn.php";
   $conn=getconn();
   $sqlReturnedBooks="Select * FROM `manage` WHERE Returned=1";
   $ReturnedBooks=mysqli_query($conn,$sqlReturnedBooks);
   $Total_ReturnedBooks = $ReturnedBooks->num_rows;
   return $Total_ReturnedBooks;
}

function getOverDate(){
    include_once "./Databases/conn.php";
   $conn=getconn();
   $sqlOverDate="Select * FROM `manage` WHERE OverDate=0";
   $OverDate=mysqli_query($conn,$sqlOverDate);
   $Total_OverDate = $OverDate->num_rows;
   return $Total_OverDate;
}

function getAvailableBooks(){
    include_once "./Databases/conn.php";
   $conn=getconn();
   $sqlAvailableBooks="SELECT * FROM `books` WHERE Availability='Available'";
   $AvailableBooks=mysqli_query($conn,$sqlAvailableBooks);
   $Total_AvailableBooks = $AvailableBooks->num_rows;
   return $Total_AvailableBooks;
}





// $sqlUser="Select * from users WHERE Borrowed_Book='No' ";
// $sqlBook="SELECT DISTINCT Book_Title FROM books WHERE Availability='Available';";


?>

<script>
    var book = document.getElementById("totalBooks");
    var user = document.getElementById("totalUsers");
    var record = document.getElementById("totalRecords");

    book.addEventListener("click", function(){
        window.location.href = "./Pages/books.php";
    });

    user.addEventListener("click", function(){
        window.location.href = "./Pages/users.php";
    });

    record.addEventListener("click", function(){
        window.location.href = "./Pages/manage.php";
    });

</script>