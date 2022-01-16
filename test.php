<?php
    session_start();

    if (isset($_POST['action']) && $_POST['action'] == 'registration') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $contactno = $_POST['contactno'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        register($firstname, $lastname, $contactno, $email, $username, $password);

    } else if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        login($username, $password);

    } else if (isset($_POST['action']) && $_POST['action'] == 'logout') {
        session_unset();
        session_destroy();
    }

    function login($username, $password) {
        $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

        if(mysqli_connect_errno()) {
            echo "Failed to connect to Database".mysqli_connect_error();
        }else{
            $sql = "SELECT customer_password FROM Customers WHERE username='$username'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_num_rows($result);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $customer_password = $row['customer_password'];

                if ($password == $customer_password) {
                    $_SESSION["loggedin"] = true;
                } else {
                    echo "Invalid username or password";
                }
            } else {
                echo "Invalid username or password";
            }

            mysqli_close($con);
        }
    }

    function register($firstname, $lastname, $contactno, $email, $username, $password) {
        $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

        if(mysqli_connect_errno()) {
            echo "Failed to connect to Database".mysqli_connect_error();
        }else{
            echo "Connected to Database</br>";
            echo "Creating tables in EpicVideo database</br>";

            

            $sql = "INSERT into Customers(first_name, last_name, phone, email, username, customer_password) 
            values('$firstname', '$lastname', '$contactno', '$email', '$username', '$password')";

            if (mysqli_query($con, $sql)) {
                echo "Records inserted Successfully";
            }else{
                echo "Error: couldnot able to execute $sql.". mysqli_error($con);
            }
            //close connection

            mysqli_close($con);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            main page
        </title>
        <link rel="stylesheet" href="spa.css">
    </head>

    <body>
        <!--Here is our main header which is used all the pages of our website-->
        <header>
            <!--Navigation-->
            <nav>
                <div class="rowh">
                    <!--Logo-->
                    <img src="epicvedio.jpeg" alt="epic logo" class="logo">
                    <!--List-->
                    <ul class="main-nav">
                        <li><a href="#">Movies  </a></li>
                        <li><a href="#">My Profile  </a></li>
                        <li><a href="#">Register   </a></li>
                        <li><a href="#" class="contact">Contact Us  </a></li>  
                    </ul>
                </div>
            </nav>
        </header>

<?php
    if (!isset($_SESSION["loggedin"])) {
?>
        <div id="firstpage">
            <div class="row">
                <div class="main">

                    <!--Registration-->
                    <div class="container">
                        <h1> Registration</h1>
                        <div class="rowh">
                            <!--Table for include form-->
                            <table class="Tform">
                                <tr>
                                    <th>Create your Own Account</th>
                                </tr> 
                                <tr>
                                    <td class="tdform">
                                        <!--Form For Product order-->
                                        <!-- onsubmit="return validateForm()" enctype="text/plain" -->
                                        <form action="./test.php" method="post">
                                            <input type="hidden" name="action" value="registration">
                                            <pre>
                                                <label for="name"><span class="form-data" >First Name:</span> </label>
                                                <input type="text" name="firstname" placeholder="Please enter your first name" size="20" required>
                                                <label for="name"><span class="form-data" >Last Name:</span> </label>
                                                <input type="text" name="lastname" placeholder="Please enter your first name" size="20" required>
                                                <label for="mobile"><span class="form-data">Mobile Number:</span> </label>
                                                <input type="Number" name="contactno" placeholder="Please enter your mobile number" size="20" required>
                                                <label for="Email"><span class="form-data">Email:</span> </label>
                                                <input type="Email" name="email" placeholder="Please enter your email" size="20" required>
                                                <label for="Username"><span class="form-data">Username:</span> </label>
                                                <input type="text" name="username" placeholder="Please enter your username" size="20" required>
                                                <label for="password"><span class="form-data">Password:</span> </label>
                                                <input type="text" name="password" placeholder="Please enter your password" size="20" required>
                                                
                                                <input type="submit" value="Submit"> <input type="reset">
                                            </pre>
                                        </form>
                                    </td> 
                                </tr>  
                            </table>
                        </div> 
                    </div>

                    <!--Login-->
                    <div id="login">
                        <h1>Login</h1>

                        <form action="./test.php" method="post">
                            <input name="action" type="hidden" value="login">
                            <table>
                                <tr>
                                    <td >User name</td>
                                    <td><input type="text" name="username" placeholder="User Name" size="50" required></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><input type="text" name="password" placeholder="Password" size="50"required ></td>
                                </tr>

                                <tr>
                                    <td><input type="submit" id="login" value="Login" onclick()="showhide" ></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] = true) {
?>
    <!-- need to write html code related for logged status -->
    <form action="./test.php" method="POST">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>

    
<?php
    }
?>
    </body>
</html>