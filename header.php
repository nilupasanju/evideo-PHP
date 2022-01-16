<?php
session_start();
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
                        <li><a href="admin.php">Information </a></li>
                        <li><a href="blog.php">Blog  </a></li>
                        <li><a href="movie.php">Movies  </a></li>
                        <li><a href="index.php">Home  </a></li>
                    </ul>
                </div>
            </nav>
        </header>
   
<?php
if (isset($_SESSION["customer_id"]) || isset($_SESSION["login_id"])){
?>
    <!-- logout -->
    <form action="./logout.php" method="POST">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>
<?php
}
?>
