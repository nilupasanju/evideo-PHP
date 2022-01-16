<?php
include 'header.php';
?>


<?php
    //$login = false;
    $password;
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        /*pass hidden input type as action and if value of action is login save values of user name and 
        password as $username & $password*/
        $username = $_POST['username'];
        //echo "</br >User name:". $username;
        $password = $_POST['loginpassword'];
        $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
        //coneected to databade
    
        if(mysqli_connect_errno()) {
            //if error
            //echo "</br>Failed to connect to Database".mysqli_connect_error();
        }else{
            //select from Login Staff query  save  as $sql
            $sql = "SELECT * FROM LoginStaff WHERE username='$username'";
            //query that from database using mysqli_query function ,save as $result
            $result = mysqli_query($con, $sql); 
            $row = mysqli_num_rows($result);
    
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $login_password = $row['loginpassword'];
    
                if ($password == $login_password) { 
                    $_SESSION["login_id"] = $row['login_id']; 
                    echo "<script>location.href='admin.php';</script>";
                   // $login = true;
                } 
            } 
            
            mysqli_close($con);
        }
    }
    
?>
<?php
    if(isset($_SESSION["login_id"])){
        include 'info.php';
    } else {
?>
 <!--Login-->
        <div id="login">
            <h1>Staff Login</h1>
            
            <form action="./admin.php" method="post">
                <input name="action" type="hidden" value="login">
                <input name="login" type="hidden" value="login">
                <table >
                    <tr>
                        <td >User name</td>
                        <td><input type="text" name="username" placeholder="User Name" size="50" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" name="loginpassword" placeholder="Password" size="50"required ></td>
                    </tr>
                
                    <tr>
                        <td><input type="submit" name="login" id="login" value="Login"></td>
                    </tr>
                </table>
            </form>
        </div>
<?php
   }
?>

<?php
include 'footer.php';
?>

    </body>
 </html>