<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/books.css">
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
                <div class="picture"><img src="../Photos/admin.jpg" alt="User Profile"></div>
                <div class="info">
                <span class="username">Raju Sharma</span>
                <span class="role">Admin</span>
                </div>
            </div>
            <!-- Menus for Navigation -->
            <div class="menus">
                <ul>
                    <li><a href="../">Dashboard</a></li>
                    <li class="focus"><a href="../Pages/books.php">Books</a></li>
                    <li><a href="../Pages/users.php">Users</a></li>
                    <li><a href="../Pages/manage.php">Records</a></li>
                </ul>
            </div>
            
        </div>
        <!-- Contains all the infromation of Dashboard to be displayed -->

        <div class="contents">
            
            <div class="addBooksBtn">
                <h3>Books</h3>
                <input type="button" value="Add Book" id="AddNewBook">
            </div>
            <div class="divider"></div>


            <div class="organizeBooks">
                <section class="searchSection">
                    <input type="search" name="searchBook" id="searchBook" placeholder="Search Books...">
                    <!-- <img src="../Photos/search.png" alt="search" height="20px" width="20px"> -->
                </section>
                </div>
<!-- 
                <section class="sortBooks">
                    <select name="sortBook" id="sortBook">
                        <option value="largeView">Large View</option>
                        <option value="List">List</option>
                    </select>
                </section>
             -->



            <div class="books" id="books">

                <?php 
                $Books = getBooks();
                while($bookData=mysqli_fetch_assoc($Books)){
                ?>
                <section class="book<?php echo $bookData['Book_id'];?>Data bookStyle">
                    <span class="image">
                    <style>
                        .book<?php echo $bookData['Book_id']; ?>Data .image::after {
                        content: '<?php echo $bookData['Book_Quantity']; ?>';
                         }
                    </style>
                        <img src="../Photos/BookCV/<?php echo $bookData['BookCV'];  ?>" alt="book" height="250px" width="180px">
                    </span>
                    <span class="details">
                    <span class="data">
                        <span class="name"><?php echo $bookData['Book_Title'];  ?></span>
                        <span class="Author"><?php echo $bookData['Author'];  ?></span>
                        <!-- <span class="Publication"><?php echo $bookData['Publication'];  ?> &nbsp <?php echo $bookData['Book_Edition'];  ?></span> -->
                        <!-- <span class="Edition"></span> -->
                    </span>
                    <span class="btn">
                        <form action="../Databases/deletData.php" method="post" class="delForm">
                            <input type="text" name="booktitle" value="<?php echo $bookData['Book_Title'];?>" style="display:none" readonly>
                            <img src="../Photos/delet.png" class="delBook" width="26px" height="26px">
                        </form>
                    </span>
                    </span>
                </section>
                <?php } ?>
            </div>

            

            

            
            

            <div class="form" id="frm">
                <form method="POST"  action="../Databases/InsertData.php" enctype="multipart/form-data">
                <span class="frm-header"><h1><center> Add Books</center></h1><span class="close" id="close-frm"><img src="../Photos/redClose.png" width="25px" height="25px"> </span></span>  <br>


                <div class="data-field"> 
                    <span>Title</span>
                    <input type="text" name="title" id="title" required><br>
                </div>
                <div class="data-field"> 
                    <span>Author</span>
                    <input type="text" name="author" id="author" required><br>
                </div>
                <div class="data-field"> 
                    <span>Publication</span>
                    <input type="text" name="publication" id="publication" required><br>
                </div>
                <div class="data-field"> 
                    <span>Edition</span>
                    <input type="text" name="edition" id="edition" required><br>
                </div>

                <div class="group-data-field">
                <div class="data-field" style="width:180px"> 
                    <span>Quantity</span>
                    <input type="number" name="quantity" id="quantity" value="1"required><br>
                </div>
                <div class="data-field"> 
                    <span>Cover Image</span></br>
                    <input type="file" name="coverimage" id="coverimage" accept="image/png, image/gif, image/jpeg" style="padding:7px" required><br>
                </div>
                </div>
                <div class="data-field btns"> 
              </br> <input type="submit" value="AddBook" name="submit" id="addBtn" >
                    <input type="Reset" value="Reset" name="Reset" id="resetBtn">

                </div>

                </form>
            </div>

            <div class="msg" id="msg" ><?php    //Pop message for data insertion and deletion
                    if(!empty($_REQUEST['msg'])){
                        $msg = $_REQUEST['msg'];
                        if($msg=="success"){
                         $smsg="Data inserted !!!";
                        echo $smsg;}
                        else if($msg == "deleted"){
                            $smsg="Data Deleted !!!";
                           echo $smsg;}} ?></div>
        </div>
        </div>
    </div>
</body>
</html>


<?php 

function getBooks(){
    include_once '../Databases/conn.php';
    $conn = getConn();

    $BookQuery = "SELECT * FROM `books` GROUP BY Book_Title;";
    $Books=mysqli_query($conn,$BookQuery);
    return $Books;
}

?>

<script>

    var delBook = document.getElementsByClassName('delBook');
    var delForm = document.getElementById('delForm');

    for (var i = 0; i < delBook.length; i++) {
    delBook[i].addEventListener('click', function(){
        // delForm.submit();
                // Find the form associated with the clicked delBook
                var parentForm = this.closest('.delForm');
        // Check if a form is found
        if (parentForm) {
            parentForm.submit();
        }
    });}

    var addBook = document.getElementById("AddNewBook");
    var form = document.getElementById("frm");
    var closefrm = document.getElementById("close-frm");
    var books = document.getElementById("books");

    addBook.addEventListener("click",showForm);
    closefrm.addEventListener("click",hideForm)

    function showForm(){
        form.style.position="absolute";
        form.style.display="block";
        form.style.top="185px";
        form.style.right="0";
        form.style.left="280px";
        form.style.marginLeft="auto";
        form.style.marginRight="auto";
        books.style.filter="blur(6px)";
    }

    function hideForm(){
        form.style.position="none";
        form.style.display="none";
        form.style.top="0";
        form.style.right="0";
        form.style.left="0";
        form.style.marginLeft="0";
        form.style.marginRight="0";
        books.style.filter="blur(0)";
    }


    // Search section

    var searchInput = document.getElementById("searchBook");
    const namesFromDOM = document.getElementsByClassName("name");


    searchInput.addEventListener("keyup", (event) => {
        const { value } = event.target;
    
    // get user search input converted to lowercase
    const searchQuery = value.toLowerCase();

    for (const nameElement of namesFromDOM) {
        // store name text and convert to lowercase
        let name = nameElement.textContent.toLowerCase();
        
        // compare current name to search input
        if (name.includes(searchQuery)) {
            // found name matching search, display it
            nameElement.parentNode.parentNode.parentNode.style.display = "flex";
            console.log(searchQuery);
        } else {
            // no match, don't display name
            nameElement.parentNode.parentNode.parentNode.style.display = "none";
            console.log("Not Matched");
        }
    }

    // console.log(searchQuery);
    });

        /// Pop message for data insertion and deletion

        const msg = document.getElementById("msg");
    const msgTxt = msg.innerText;
    console.log(msgTxt);
    if(msgTxt === "Data inserted !!!"){
    //msg.innerText = "Data Deleted";
    msg.style.display = "flex";

    setTimeout(() => {
        msg.style.display = "none";
    }, 1000);
    }
    else if(msgTxt === "Data Deleted !!!"){
    //msg.innerText = "Data Deleted";
    msg.style.display = "flex";
    msg.style.backgroundColor = "red";

    setTimeout(() => {
        msg.style.display = "none";
    }, 1000);
    }
    

</script>
