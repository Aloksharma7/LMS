<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/manage.css">
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
                    <li><a href="../Pages/books.php">Books</a></li>
                    <li><a href="../Pages/users.php">Users</a></li>
                    <li class="focus"><a href="../Pages/manage.php">Records</a></li>
                </ul>
            </div>
            
        </div>
        <!-- Contains all the infromation of Dashboard to be displayed -->

        <div class="contents">
            
            <div class="addDataBtn">
                <h3>Users</h3>
                <input type="button" value="Add Record" id="addData">
            </div>
            <div class="divider"></div>


             <div class="manage">
                <section class="searchSection">
                    <input type="search" name="searchRecord" id="searchRecord" placeholder="Search Records...">
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


    <div class="manage" id="manage">
    <?php 
    $ManagedData = getManageData();
    while($ManageData=mysqli_fetch_assoc($ManagedData)){
    ?>
        <span class="data">
            <span class="fname"><?php echo $ManageData['UserName'];  ?></span>
            <span class="bookname"><?php echo $ManageData['BookName'];  ?></span>
            <span class="issuedDate">Issue Date: <?php echo $ManageData['Issued_Date'];  ?></span>
            <span class="ReturnDate">Return Date: <?php echo $ManageData['Return_Date'];  ?></span>
            <!-- <input type="button" value="Delete"> -->
            <div class="actionButtons">
            <form action="../Databases/deletData.php" method="post" id="deletBtn">
                <input type="text" name="Mname" value="<?php echo $ManageData['UserName'];?>" style="display:none" readonly>
                <input type="text" name="RMid" value="<?php echo $ManageData['DataID'];?>" style="display:none" readonly>
                <input type="text" name="Bname" value="<?php echo $ManageData['BookName'];?>" style="display:none" readonly>
                <input type="submit" value="Delete">
            </form>
            
            <form action="../Databases/returnedData.php" method="post" id="returnBtn">
                <?php if( $ManageData['Returned'] === '0') {?> 
                <input type="text" name="RMname" value="<?php echo $ManageData['UserName'];?>" style="display:none" readonly>
                <input type="text" name="RBname" value="<?php echo $ManageData['BookName'];?>" style="display:none" readonly>
                <input type="submit" value="Return">
                <?php } else {?>
                <input type="text" value="Returned" style="background: #249520;height: 31px;text-align: center;" readonly> <?php } ?>
            </form> 
    </div>
        </span>
    </section>
    <?php } ?>
    </div>
            

            <div class="form" id="frm">
                <form action="../Databases/InsertData.php" method="post" enctype="multipart/form-data">
                <span class="frm-header"><h1><center> Add Users</center></h1><span class="close" id="close-frm"><img src="../Photos/redClose.png" width="25px" height="25px"> </span>
                </span><br>

                <div class="data-field"> 
                    <span>User </span>

                    <?php 
                    $Users=getUsers();
                    $UsersCount = $Users->num_rows;
                    if($UsersCount >0){ ?>

                    <input list="username" name="UsersName" id="UsersName" required>
                    <datalist id="username">
                     <!-- PHP Codes -->
             <?php while($data=mysqli_fetch_assoc($Users)){ ?>
                 <option value="<?php echo $data['User_Name'];?>"></option>  
                <?php } }else{ ?>
                    <input   name="UserNotAvailable" id="UsersName" value="Users Not Available" style="color:red;" readonly required>
            <?php } ?>

                    </datalist>
                    <br>
                </div>
               
                <div class="data-field"> 
                    <span>Book</span> 
                    
                    <!-- PHP Codes -->
            <?php 
                $Books=getBooks();
                $BooksCount = $Books->num_rows;
                if($BooksCount > 0){  ?>

                    <input list="bookname"  name="BooksName" id="BooksName"  required>
                    <datalist id="bookname">

                     <!-- PHP Codes -->
            <?php while($data=mysqli_fetch_assoc($Books)){ ?>
    
                 <option value="<?php echo $data['Book_Title']; ?>" ></option>
                       <!-- PHP Codes -->
            <?php }} else{ ?>
                <input   name="BookNotAvailable" id="BooksName" value="Books Not Available" style="color:red;" readonly required>
            <?php } ?>
                    </datalist>
                    <br>
                </div>
                <div class="data-field"> 
                    <span>Date of Issued</span>
                    <input type="date" name="issueDate" id="issueDate" required><br>
                    <!-- pattern="\d{4}-\d{2}-\d{2}" placeholder="0000-00-00"  -->
                </div>
                <div class="data-field"> 
                    <span>Return Date</span>
                    <input type="date" name="returnDate" id="returnDate" required><br>
                    
                </div>
                <div class="data-field btns"> 
                     <!-- PHP Codes -->
                    <input type="<?php if($BooksCount > 0 && $UsersCount > 0 ){echo "submit";} else{echo "button";}?>" value="AddData" name="submit" id="addBtn">
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
    
function getUsers(){
    include_once "../Databases/conn.php";
    $conn=getconn();
    $sqlUser="Select * from users WHERE Borrowed_Book='No'";
    $Users=mysqli_query($conn,$sqlUser);
    return $Users;
}

function getBooks(){
    //include "../Databases/conn.php";
    $conn=getconn();
    $sqlBook="SELECT DISTINCT Book_Title FROM books WHERE Availability='Available';";
    $Books=mysqli_query($conn,$sqlBook);
    return $Books;
    }

    function getManageData(){
        include_once '../Databases/conn.php';
        $conn = getConn();
    
        $ManageQuery = "SELECT * FROM `manage` ORDER BY DataID DESC;";
        $ManageData=mysqli_query($conn,$ManageQuery);
        return $ManageData;
    }
?>


<script>

    var addData = document.getElementById("addData");
    var form = document.getElementById("frm");
    var closefrm = document.getElementById("close-frm");
    var manage = document.getElementById("manage");

    addData.addEventListener("click",showForm);
    closefrm.addEventListener("click",hideForm)

    function showForm(){
        form.style.position="absolute";
        form.style.display="block";
        form.style.top="40px";
        form.style.right="0";
        form.style.left="280px";
        form.style.marginLeft="auto";
        form.style.marginRight="auto";
        manage.style.filter="blur(6px)";
    }

    function hideForm(){
        form.style.position="none";
        form.style.display="none";
        form.style.top="0";
        form.style.right="0";
        form.style.left="0";
        form.style.marginLeft="0";
        form.style.marginRight="0";
        manage.style.filter="blur(0)";
    }


    var searchInput = document.getElementById("searchRecord");
    const namesFromDOM = document.getElementsByClassName("fname");
    const booksFromDOM = document.getElementsByClassName("bookname");


    searchInput.addEventListener("keyup", (event) => {
        const { value } = event.target;
    
    // get user search input converted to lowercase
    const searchQuery = value.toLowerCase();
    console.log(searchQuery);

    // var searchName = "0";

    // if(searchName === "0"){
    for (const nameElement of namesFromDOM) {
        // store name text and convert to lowercase
        let name = nameElement.textContent.toLowerCase();
        
        // compare current name to search input
        if (name.includes(searchQuery)) {
            // found name matching search, display it
            nameElement.parentNode.style.display = "flex";
            console.log(searchQuery);
            
        } else {
            // no match, don't display name
            nameElement.parentNode.style.display = "none";
            console.log("Not Matched");
            // searchName="1";
            // break;
        }
    } 
    // }
    // else{
    // for (const bookElement of booksFromDOM) {
    //     // store bookname text and convert to lowercase
    //     let bookname = bookElement.textContent.toLowerCase();

    //     // compare current bookname to search input
    //     if (bookname.startsWith(searchQuery)) {
    //         // found bookname matching search, display it
    //         bookElement.parentNode.style.display = "flex";
    //     } else {
    //         // no match, don't display bookname
    //         bookElement.parentNode.style.display = "none";
    //     }
    // }}

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
