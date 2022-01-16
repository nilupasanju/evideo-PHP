<?php
include_once 'header.php';
if(isset($_SESSION["customer_id"])) {
    $customer_id = $_SESSION["customer_id"];

}
?>

<?php
//LOGIN MODULE



if(isset($customer_id) && isset($_POST['action']) && $_POST['action'] == 'addpost'){
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $date = date('Y-m-d H:i:s');

   // echo "Title is " . $title . "</br>";
   // echo "Content is " . $content . "</br>";
    //echo "Customer_id is " . $customer_id . "</br>";
   
    //inert in to blog Table
    $sql = "INSERT into Blog(customer_id,title,content,create_date) 
    values('$customer_id', '$title', '$content', '$date')";
    $result = mysqli_query($con, $sql);
   
    mysqli_close($con);
    
    if($result){
       // echo "Query Fine</br>";
        include 'blog.php';
        exit();
    } else {
        echo "hi hello</br>";
        echo $result;
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'login') {
    /*pass hidden input type as action and if value of action is login save values of user name and 
    password as $username & $password*/
    $username = $_POST['username'];
    //echo "</br >User name:". $username;
    $password = $_POST['password'];
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
    //coneected to databade

    if(mysqli_connect_errno()) {
        //if error
        //echo "</br>Failed to connect to Database".mysqli_connect_error();
    }else{
        //if not
       // echo "</br>connected to databse";
        //select from customers query  save  as $sql
        $sql = "SELECT * FROM Customers WHERE username='$username'";
        //query that from database using mysqli_query function ,save as $result
        $result = mysqli_query($con, $sql);
        
        $row = mysqli_num_rows($result);

        //echo "$username, $password";

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $customer_password = $row['customer_password'];

            if ($password == $customer_password) {  
                $customer_id = $row['customer_id'];
                
            } else {
                echo "</br>User name or Password Invalid ";
            }
        } else {
           // echo "</br>Invalid username or password";
        }
        
        mysqli_close($con);
    }
}
?>
<?php
if(!isset($_SESSION["customer_id"])) {
?>
 <!--Login-->
        <div id="login">
            <h1>Login</h1>
            
            <form method="post">
                <input name="action" type="hidden" value="login">
                <input name="login" type="hidden" value="login">
                <table >
                    <tr>
                        <td >User name</td>
                        <td><input type="text" name="username" placeholder="User Name" size="50" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" name="password" placeholder="Password" size="50"required ></td>
                    </tr>
                
                    <tr>
                        <td><input type="submit" name="login" id="login" value="Login"></td>
                    </tr>
                </table>
            </form>
        </div>
<?php
}else if(isset($_SESSION["customer_id"])) {
?>
    <div class="rowm">
    <h2>Create Post</h2>

    <div>
        <form action="createpost_v2.php" method="POST">
            <input type="hidden" name="action" value="addpost">
             <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /> 

            <input type="text" id="title" name="title" placeholder="Title">
            <textarea id="content" name="content"></textarea>
            
            <button value="addpost" name="addpost"id="addpost" method="post">Add Post</button>
        </form>
        <br><br>
    </div>
<?php


//Create Blog MOdule
}       
?>
<?php
include 'footer.php';
?>
 



    </body>
 </html>