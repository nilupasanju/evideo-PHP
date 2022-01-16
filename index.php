<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    /*pass hidden input type as action and if value of action is login save values of user name and 
    password as $username & $password*/
    $username = $_POST['username'];
    $password = $_POST['password'];
	
    $cookie_name = "user";
    //$cookie_name1 = "movie_pref";
    setcookie("user", $username, time() + (86400 * 30), "/"); // 86400 = 1 day
    //setcookie("movie_pref", $genre['genre_description'], time()+3600, "/", "",  0);
    if(!isset($_COOKIE[$cookie_name])) {
        echo "Cookie named '" . $cookie_name . "' is not set!";
    } else {
        echo "Cookie '" . $cookie_name . "' is set!<br>";
        echo "Value is: " . $_COOKIE[$cookie_name];
    }

    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
    //coneected to databade

    if (mysqli_connect_errno()) {
        //if error
        //echo "</br>Failed to connect to Database".mysqli_connect_error();
    } else {
        //if not
        // echo "</br>connected to databse";
        //select from customers query  save  as $sql
        $sql = "SELECT * FROM Customers WHERE username='$username'";
        //query that from database using mysqli_query function ,save as $result
        $result = mysqli_query($con, $sql);
        $row = mysqli_num_rows($result);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $customer_password = $row['customer_password'];
            
            if ($password == $customer_password) {
                $_SESSION["customer_id"] = $row['customer_id'];
               
                echo "<script>location.href='profile.php';</script>";
            } else {
               // echo "</br>Invalid username or password";
            }
        } else {
           // echo "</br>Invalid username or password";
        }
        
        mysqli_close($con);
    }
}

include 'header.php';
?>

<?php
    
    if(isset($_SESSION["customer_id"])){
       include 'profile.php'; 
        exit();
        //echo"<script>location.href='profile.php';</script>";
        //header('Location: profile.php'); 
    } else {
?>
    <div id="firstpage">
        <div class="row">
            <div class="main">

                <!--Login-->
                <div id="login">
                    <h1>Login</h1>
                    
                    <form action="./index.php" method="post">
                        <input name="action" type="hidden" value="login">
                        <input name="login" type="hidden" value="login">
                        <table >
                            <tr>
                                <td >User name</td>
                                <td><input type="text" name="username" placeholder="User Name" size="50" required></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="passoword" name="password" placeholder="Password" size="50"required ></td>
                            </tr>
                        
                            <tr>
                                <td><input type="submit" id="login" value="Login"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                    
                <div class="rowl">
                        <h1> Registration</h1>
                    <div class="rowh">
                        
                        <table class="Tform">
                            <tr>
                                <th>Create your Own Account</th>
                            </tr> 
                            <tr>
                                <td class="tdform">
                                
                                    <form action="./index.php" method="post">
                                        <input type="hidden" name="action" value="registration">
                                        <input name="Submit" type="hidden" value="registration">
                                        <pre>
                                            <label for="name"><span class="form-data" >First Name:</span> </label>
                                            <input type="text" name="firstname" placeholder="" size="20" required>
                                            <label for="name"><span class="form-data" >Last Name:</span> </label>
                                            <input type="text" name="lastname" placeholder="" size="20" required>
                                            <label for="mobile"><span class="form-data">Mobile Number:</span> </label>
                                            <input type="Number" name="contactno" placeholder="" size="20" required>
                                            <label for="Email"><span class="form-data">Email:</span> </label>
                                            <input type="Email" name="email" placeholder="" size="20" required>
                                            <label for="Address"><span class="form-data">Address:</span> </label>
                                            <input type="text" name="address1" placeholder="no" size="20" required>
                                            <input type="text" name="address2" placeholder="Street" size="20" required>
                                            <input type="text" name="address3" placeholder="Surbub" size="20" required>
                                            <input type="text" name="city" placeholder="City" size="20" required>
                                            <input type="text" name="state" placeholder="State" size="20" required>

                                            <label for="Username"><span class="form-data">Username:</span> </label>
                                            <input type="text" name="username" placeholder="" size="20" required>
                                            <label for="password"><span class="form-data">Password:</span> </label>
                                            <input type="password" name="password" placeholder="" size="20" required>
                                            
                                            <input type="submit" id="registration" value="Submit"> <input type="reset">
                                        </pre>
                                    </form>
                                </td> 
                            </tr>  
                        </table>
                    </div> 

                </div>
                </div>
            </div>
<?php

        //REGISTRATION MODULE
        $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

        if(mysqli_connect_errno()){
            // echo "Failed to connect to Database".mysqli_connect_error();
        } else {
       //echo "Connected to Database</br>";
      
            $firstname = mysqli_real_escape_string($con,$_POST['firstname']);
            $lastname = mysqli_real_escape_string($con,$_POST['lastname']);
            $contactno = mysqli_real_escape_string($con,$_POST['contactno']);
            $email = mysqli_real_escape_string($con,$_POST['email']);
            $username = mysqli_real_escape_string($con,$_POST['username']);
            $password =$_REQUEST['password'];
            $no=$_REQUEST['address1'];
            $street=$_REQUEST['address2'];
            $surbub=$_REQUEST['address3'];
            $city=$_REQUEST['city'];
            $state=$_REQUEST['state'];
            $addrss_type_id=1;


            //$customer_genre=$_POST('genre');
            // Insert in to Customers table
            $sql = "INSERT into Customers( first_name, last_name, phone, email, username, customer_password) 
            values('$firstname','$lastname','$contactno','$email','$username','$password')";

            $state_sql="SELECT state_id from States where state_name = '$state'";
            $city_id="SELECT city_id from Cities where city_name = '$city";

            $sql1="INSERT into addresses(address1,address2,address3,city_id,address_type_id)Values($no,'$street','$surbub','$city_id',$addrss_type_id";

            if (mysqli_query($con, $sql)) {
                echo'<p >You have Registerd  Successufully..</p>';
            }else{
                //echo "Record Could not insert";
            }

            



        }
       //close connection
        
       mysqli_close($con);
    
}
?>


                <!--Contact us-->
                
                <div class="side">
                    <div class="row">
                        <div class="col">
                            <div class="title ">
                                <p class="title-main"> Give Us a Call </p>
                                <h2 class="title-sub">SEND US A MESSAGE.</h2>
                            </div>
                        </div>
                    </div>
                    <div >
                        <div class="row">
                            <div >
                                <div >
                                    <div >
                                        <h3>Contact Us</h3>
                                        <p>Please fill out this form </p>
                                        <form id="contactform" action="./index.php" method="post" >
                                        <input type="hidden" name="action" value="submit">
                                        <div >
                                            <input type="text" name="name"  placeholder="Your name">
                                        </div>

                                        <div>
                                            <input type="number" name="mobile"  placeholder="Phone Number">
                                        </div>
                                        <div >
                                            <input type="email" name="email"  placeholder="Email">
                                        </div>
                                        <div >
                                            <textarea  id="comments" name="enquiry" placeholder="Message" ></textarea><br>
                                        </div>
                                        <input type="submit" value="SUBMIT" id="submit" >
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div >
                                <p>Contact us and we'll get back to you within 24 hours.</p>
                                <p><i ></i> Melbourne, Australia</p>
                                <p><i ></i> (03) 45326178</p>
                                <p><i ></i> info@epicvedio.com.au</p> 
                            </div>
                            
                        </div>
                    </div>
<?php

//CONTACT US Module
$con = mysqli_connect("127.0.0.1","root","","EpicVideo");

if(mysqli_connect_errno())
{
    // echo "Failed to connect to Database".mysqli_connect_error();
}else{
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $enquiry = mysqli_real_escape_string($con,$_POST['enquiry']);

    $sql = "INSERT into Enquiry(Cus_name, mobile, email, enquiry) 
    values('$name', '$mobile', '$email', '$enquiry')";

    //echo $sql;

    if (mysqli_query($con, $sql)) {
        echo "Thanks you for the Enquiry , One of our staff will be contact you soon!";
    }else{
        //echo "Error: couldnot able to execute .". mysqli_error($con);
    }
    //close connection

    mysqli_close($con);
}

?>
                </div>  
            </div>
        </div>
    </body>


    <footer class="footer">
       <nav class="footer-nav">    
           <a href="https://www.facebook.com/ATMCSOCIAL/" class="fa fa-facebook"></a>
           <a href="https://twitter.com/atmc_australia?lang=en" class="fa fa-twitter"></a>
           
           <p>
               Copyright &copy; 2021 by EpicVedio. All rights reserved.
           </p>
       </nav>
   </footer>
</html>