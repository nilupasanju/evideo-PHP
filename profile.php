<?php
session_start();

if(isset($_SESSION["customer_id"])) {
    $customer_id = $_SESSION["customer_id"];
}

$con = mysqli_connect("127.0.0.1","root","","EpicVideo");

if(mysqli_connect_errno()) {
// echo "Failed to connect to Database".mysqli_connect_error();
} else{ //if (isset($_SESSION["customer_id"])) {
    //$customer_id = $_SESSION["customer_id"];
    //echo "Connected to Database</br>";
    //Checked it is with same customer id    
    //checked theres a value with update and value == update w(hidden action)
    if (isset($_POST['action']) && $_POST['action'] == 'Update') {
        $firstname = mysqli_real_escape_string($con,$_POST['firstname']);
        $lastname = mysqli_real_escape_string($con,$_POST['lastname']);
        $contactno = mysqli_real_escape_string($con,$_POST['contactno']);
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $selected_genres = $_POST['genre'];
        //echo $selected_genres;
        //Update Customer Table where customer_id=$customer_id
        $sql = "UPDATE Customers SET
                first_name='$firstname',
                last_name='$lastname',
                phone='$contactno',
                email='$email'
                WHERE customer_id='$customer_id'";
        $result = mysqli_query($con,$sql);
        //echo $result;
        //If query ok 
        if ($con->query($sql) === TRUE) {
            //echo "<p>Record updated Customer table successfully</p>";
        } else {
        //echo "Error updating record: " . $conn->error;
        }
        //Customer_genre all delete first  and then insert as it is easy rather than cheking one by one .
        $sql1 = "DELETE FROM Customer_genre WHERE customer_id=$customer_id";
        mysqli_query($con, $sql1);
        if ($con->query($sql1) === TRUE) {
            //echo "<br>Record deleted successfully";
        } else {
        //echo "Error updating record: " . $conn->error;
        }
        //save updated genre info in array and take inner value to insert Customer_genre table
        foreach($selected_genres as $key => $value) {
        $genre_sql = "INSERT INTO Customer_genre(genre_id, customer_id)
                    VALUES($value, $customer_id)";
                    $result1 = mysqli_query($con, $genre_sql);
        }
        
    }
    //PROFILE MODULE
    //Get all details from Customer table which is map to customer id
    $customer_sql = "SELECT * FROM Customers WHERE customer_id=$customer_id";
    //Get Customer_id from Customer_genre table and genre_id and genre_description from Movie_genre which is map to customer id
    $genre_sql = "SELECT Movie_genre.genre_id, Movie_genre.genre_description, Customer_genre.customer_id from Movie_genre
                    LEFT JOIN Customer_genre
                    ON Movie_genre.genre_id = Customer_genre.genre_id AND Customer_genre.customer_id = $customer_id";
    //Save query result of customer_sql
    $customer_result = mysqli_query($con, $customer_sql);
    //Save query result of movie_genre_sql
    $movie_genre_results = mysqli_query($con, $genre_sql);

    
    
    //Check result variable has any rows in it 
    if (mysqli_num_rows($customer_result) > 0) {
        //fetch result save on customer variable and display
        $customer = mysqli_fetch_assoc($customer_result);
        mysqli_close($con);
    }

    $movie_genres = [];
    $movie_genre_descriptions = [];
    $index = 0;

    while($genre = mysqli_fetch_array($movie_genre_results)) {
        $movie_genres[$index]['genre_id'] = $genre['genre_id'];
        $movie_genres[$index]['genre_description'] = $genre['genre_description'];
        $movie_genres[$index]['customer_id'] = $genre['customer_id'];
        $movie_genre_descriptions[$index] = $genre['genre_description'];
        $index++;
    }

    setcookie("movie_pref", serialize($movie_genre_descriptions), time()+(86400 * 30), "/");  
    include_once 'header.php';

?>
    <!--Profile-->
    <div class="container">
        <h1> My Profile</h1>
        <div class="rowh">
            
            <table class="Tform">
                <tr>
                    <th>Create your Own Account</th>
                </tr> 
                <tr>
                    <td class="tdform">
                        
                        <form id="update" action="./profile.php" method="post">
                            <input name="action" type="hidden" value="Update">

                            <pre>
                                <label for="name"><span class="form-data" >Customer_id:</span> </label>
                                <input type="text" name="customer_id" placeholder="" size="20" required value="<?php echo $customer['customer_id']; ?>">  
                                <label for="name"><span class="form-data" >First Name:</span> </label>
                                <input type="text" name="firstname" placeholder="" size="20" required value="<?php echo $customer['first_name']; ?>">
                                <label for="name"><span class="form-data" >Last Name:</span> </label>
                                <input type="text" name="lastname" placeholder="" size="20" required value="<?php echo $customer['last_name']; ?>">
                                <label for="mobile"><span class="form-data">Mobile Number:</span> </label>
                                <input type="Number" name="contactno" placeholder="" size="20" required value="<?php echo $customer['phone']; ?>">
                                <label for="Email"><span class="form-data">Email:</span> </label>
                                <input type="Email" name="email" placeholder="" size="20" required value="<?php echo $customer['email']; ?>">
                            
                                <label for="movie"><span class="form-data">Prefered Movies:</span> </label>

<?php
            //fetch genre id and genre description from database and if there is value checked(!=null) with 
            for($i = 0; $i < count($movie_genres); $i++) {
                
?>
                                <input name="genre[]" type="checkbox" id="<?php echo $movie_genres[$i]['genre_id']; ?>" value="<?php echo $movie_genres[$i]['genre_id']; ?>" 
                                <?php echo $movie_genres[$i]['customer_id'] != null ? "checked" : ""; ?>/>
                                <?php echo $movie_genres[$i]['genre_description']; ?>
                                </br>
<?php
            } 
?>
                                <input type="submit" id="Update" value="Update"> 
                            </pre>
                        </form>
                    </td> 
                </tr>  
            </table>
        </div> 
    </div>
<?php
}
?>

<?php
//If Customer_id set Message Module also display
if(isset($customer_id)){
?> 
        <div class="rowh">
            <div >
                <h3>Message</h3>
                <form action="./profile.php" method="POST">
                    <input name="action" type="hidden" value="insertmessage">
                    <input name="submit" type="hidden" value="insertmessage">
                    <input name="customer_id" type="hidden" value="<?php echo $customer_id; ?>">
                
                    <div >
                    <label>Message:
                        <input type="text" id="message" name="message" placeholder="" ></label>
                        <input name="date" type="hidden" value="<?php echo $date; ?>">

                    </div>
                    <div>
                    
                    <input type="submit" id="insertmessage" value="Submit">
                </form>
<?php
}
//MESSAGE MOdule
if(isset($customer_id)){
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
    if(mysqli_connect_errno()) {
        //echo "</br>Failed to connect to Database".mysqli_connect_error();
    }else{
    // echo"</br>Connected to database";
    //checked theres a value with insertmessage and value == insertmessage with(hidden action) when click on submit
    if(isset($_POST['action']) && $_POST['action'] == 'insertmessage'){
        //echo "<br>Insert messages to message table";
        $message = mysqli_real_escape_string($con,$_POST['message']);
        $date = date('Y-m-d H:i:s');
        //inert in to Message Table
        $sql = "INSERT into Messages(customer_id,message_description,messagedate) 
        values('$customer_id','$message','$date')";
        
        if (mysqli_query($con, $sql)) {
            echo'<p >Message Sent Successufully..</p>';
        }else{
            echo "</br>Error: couldnot able to execute $sql.". mysqli_error($con);
        }
    }
?>
            <h3>Message Histroy</h3>
<?php
{
    //select messages from Message tale where customer_id=login customer id
    $sql = "SELECT* from Messages where customer_id='$customer_id'";
    //Save Result
    $result = mysqli_query($con, $sql);
    //if result has many rows
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='messagehistroy'>
                <tr>
                    <td>";
                    //fetch results and save on message variable
        while ($message = mysqli_fetch_array($result)){
            //print index 2 and index 3 in message array
            echo "$message[2]<br>";
            echo "$message[3]<br>";
        }
    }
    echo "</td></tr></table>";
    }
        
    }
    mysqli_close($con);
}


?>            
            </div>
        </div> 
<?php
//if Customer_id variable set with login username
if(isset($customer_id)){
?> 
    <div>
        <h1>Image Galary</h1>
<?php
            
}

    //IMAGE BANNER Module
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
    $genre_description=$customer['genre_description'];
    //select  image_id from images where map to which customer_id
    $sql = "SELECT image_id from images 
    inner join Movie_genre on images.genre_id=Movie_genre.genre_id
    inner join Customer_genre on Customer_genre.genre_id=Movie_genre.genre_id 
    where customer_id='$customer_id'";
    //Save result
    $result = mysqli_query($con, $sql);

    if( $result->num_rows > 0) {
        echo '<div class="gallery">';
            while( $row = $result->fetch_assoc()){ 
                //take innervalue from array as saved images in images/genre/image_id.jpeg
                foreach($row as $key => $value) {
                    //$value=image_id; ex:$row=[a1,a2,a3,a4] ,image save as a1.jpeg,a2.jpeg
                }
                $path ="./images/genre/";
                $file = $value.".jpeg";
                echo '<img src="' . $path . $file.'" width="25%" height="60%">';

            }
        echo '</div> ';
    } else { 
        //echo '<p >Image(s) not found...</p>';
    
    }
    mysqli_close($con);  
?>
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


