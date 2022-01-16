<?php
include 'header.php';

if(isset($_SESSION["customer_id"])) {
    $customer_id = $_SESSION["customer_id"];
}

$id ;
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}

 if(isset($id)){
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

    if(mysqli_connect_errno()){
        echo "Failed to connect to Database".mysqli_connect_error();
    }else{
       // echo "Connected to Database @@@@@@</br>";
       // echo "Creating tables in EpicVideo database</br>";
       // echo $_POST['action'];

        if(isset($_POST['action']) && $_POST['action'] == 'submit'){
            //echo"hi 1 </br>";
            $rating = $_REQUEST['rating'];
            //echo "rating ". $rating . "</br>";
            $email = $_REQUEST['email'];
            //echo "email:". $email."</br>";
            $review = $_REQUEST['remark'];
            //echo "review ". $review ."</br>";

            $sql1 = "SELECT customer_id From Customers where email = '$email'";
            $customer_id_result = mysqli_query($con, $sql1);  
            if (mysqli_num_rows($customer_id_result) > 0) {
            //fetch result save on customer variable and display
            $row = mysqli_fetch_assoc($customer_id_result);
            echo "Customer_id : " .$row['customer_id']."<br>";
            $customer_id = $row['customer_id'];
            }
            
            $sql2 = "SELECT rating_id From Rating where rating = $rating ";
            $rating_id = mysqli_query($con, $sql2);
            $rating_id_result = mysqli_query($con, $sql2);  
            if (mysqli_num_rows($rating_id_result) > 0) {
            //fetch result save on customer variable and display
            $row1 = mysqli_fetch_assoc($rating_id_result);
            echo "rating_id : " .$row1['rating_id']."<br>";
            $rating_id = $row1['rating_id'];
            }
             //echo "movie_id " . $id . "<br>";
             //echo "Customer_id : " . $customer_id . "<br>";

            $sql = "INSERT into Customer_Rating(rating_id, movie_id, customer_id, review) values($rating_id,$id,$customer_id,'$review')";
            $result = mysqli_query($con, $sql);

            if ($result){
                echo'<p >rating add Successufully..</p>';                   
                echo"<script>location.href='movie.php';</script>";            
            }else{
                echo "<br>Error: couldnot able to execute .". mysqli_error($con);
            }            
             //close connection
        }
        mysqli_close($con);
    }
 }
?>
   


<div class="row">
    <h3><b>Rating & Reviews</b></h3>
</div>

<form method="post">
    <label for="rating"> Choose a rating:</label>
    <select name="rating" id="rating">
        <option value = "" selected> Select option </option>  
        <option value="1">Excelant</option>
        <option value="2">Good</option>
        <option value="3">Bad</option>
        <option value="4">Very Bad</option>
        
    </select>
    <div class="">
        <label for="email"> Email:</label><br>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email Id"><br>
        <label for="remark"> Review:</label><br>
        <textarea class="" rows="5" placeholder="Write your review here..." name="remark" id="remark" required></textarea><br>
        <button value="submit" name="submit"id="submit" method="post">Submit</button></br>
        <input name="action" type="hidden" value="submit">
    
    </div>
</form>



<?php
	include 'footer.php';
?>





