<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/users.css">
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
                    <li class="focus"><a href="../Pages/users.php">Users</a></li>
                    <li><a href="../Pages/manage.php">Records</a></li>
                </ul>
            </div>
            
        </div>
        <!-- Contains all the infromation of Dashboard to be displayed -->

        <div class="contents">
            
            <div class="addUsersBtn">
                <h3>Users</h3>
                <input type="button" value="Add User" id="AddNewUser">
            </div>
            <div class="divider"></div>


             <div class="organizeUsers">
                <section class="searchSection">
                    <input type="search" name="searchUser" id="searchUser" placeholder="Search Users...">
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
            

            <div class="users" id="users">
<?php 
$Users = getUsers();
while($userData=mysqli_fetch_assoc($Users)){
?>
<section class="user<?php echo $userData['User_Name'];?>Data userStyle">

    <span class="image">
        <img src="../Photos/Profile_Pic/<?php echo $userData['Profile_Pic'];  ?>" alt="user" height="100px" width="100px">
    </span>
    <span class="data">
        <span class="fname"><?php echo $userData['Full_Name'];  ?></span>
        <span class="uname info"><?php echo $userData['User_Name'];  ?></span>
        <span class="roll info">Roll: <?php echo $userData['Roll'];  ?></span>
        <span class="sclass info">Class: <?php echo $userData['SClass'];  ?></span>
        <span class="department info"><?php echo $userData['Department'];  ?></span>
        <span class="email info"><?php echo $userData['Email'];  ?></span>
        <span class="phone info">No: <?php echo $userData['Phone'];  ?></span>
    </span>
    
<form action="../Databases/deletData.php" method="post">
    <input type="text" name="uname" value="<?php echo $userData['User_Name'];?>" style="display:none" readonly>
    <input type="submit" value="Delete">
</form>
</section>
<?php } ?>
</div>



            <div class="form" id="frm">
                <form action="../Databases/InsertData.php" method="post" enctype="multipart/form-data">
                <span class="frm-header"><h1><center> Add Users</center></h1><span class="close" id="close-frm"><img src="../Photos/redClose.png" width="25px" height="25px"> </span></span><br>

                <div class="data-field"> 
                    <span>Full Name</span>
                    <input type="text" name="name" id="name" required><br>
                </div>
                <div class="data-field"> 
                    <span>User Name</span>
                    <input type="text" name="Uname" id="Uname" pattern="[A-Za-z0-9 ]+" required><br>
                </div>

                <div class="group-data-field">
                <div class="data-field"> 
                    <span>Class</span>
                    <input type="number" name="sclass" id="sclass" style="width:100px" required><br>
                </div>
                <div class="data-field"> 
                    <span>Department</span>
                    <input type="text" name="department" id="department" required><br>
                </div>
                </div>

                <div class="group-data-field">
                    <div class="data-field" > 
                        <span>Roll</span>
                        <input type="number" name="roll" id="roll" style="width:100px" required><br>
                    </div>
                    <div class="data-field"> 
                        <span>Section</span>
                        <input type="text" name="section" id="section" required><br>
                    </div>
                </div>

                <div class="data-field"> 
                    <span>Email</span>
                    <input type="emial" name="email" id="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"  required><br>
                </div>
                <div class="group-data-field">
                    <div class="data-field"> 
                        <span>Phone No.</span>
                        <input type="number" name="phone" id="phone" required><br>
                    </div>
                    <div class="data-field"> 
                        <span>Profile Picture</span>
                        <input type="file" name="profilePic" id="profilePic" accept="image/png, image/gif, image/jpeg" style="padding: 7px;" required><br>
                    </div>
                </div>
                <div class="data-field btns"> 
                    <input type="submit" value="AddUser" name="submit" id="addBtn">
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
    include_once '../Databases/conn.php';
    $conn = getConn();

    $UserQuery = "SELECT * FROM `users` ORDER BY Full_Name";
    $Users=mysqli_query($conn,$UserQuery);
    return $Users;
}

?>


<script>

    var addUser = document.getElementById("AddNewUser");
    var form = document.getElementById("frm");
    var closefrm = document.getElementById("close-frm");
    var users = document.getElementById("users");

    addUser.addEventListener("click",showForm);
    closefrm.addEventListener("click",hideForm)

    function showForm(){
        form.style.position="absolute";
        form.style.display="block";
        form.style.top="150px";
        form.style.right="0";
        form.style.left="280px";
        form.style.marginLeft="auto";
        form.style.marginRight="auto";
        users.style.filter="blur(6px)";
    }

    function hideForm(){
        form.style.position="none";
        form.style.display="none";
        form.style.top="0";
        form.style.right="0";
        form.style.left="0";
        form.style.marginLeft="0";
        form.style.marginRight="0";
        users.style.filter="blur(0)";
    }

    var searchInput = document.getElementById("searchUser");
    const namesFromDOM = document.getElementsByClassName("fname");


    searchInput.addEventListener("keyup", (event) => {
        const { value } = event.target;
    
    // get user search input converted to lowercase
    const searchQuery = value.toLowerCase();
    // console.log(searchQuery);

    for (const nameElement of namesFromDOM) {
        // store name text and convert to lowercase
        let name = nameElement.textContent.toLowerCase();
        
        // compare current name to search input
        if (name.includes(searchQuery)) {
            // found name matching search, display it
            nameElement.parentNode.parentNode.style.display = "flex";
            console.log(searchQuery);
        } else {
            // no match, don't display name
            nameElement.parentNode.parentNode.style.display = "none";
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