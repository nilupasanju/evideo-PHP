<?php
include 'header.php';
?>
<?php
$id ;
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}
?>
<?php
 if(isset($id)){
   $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

   if(mysqli_connect_errno()){
       echo "Failed to connect to Database".mysqli_connect_error();
   }else{
       echo "Connected to Database</br>";
       echo "Creating tables in EpicVideo database</br>";


       $sql = "SELECT rm.rent_date, rm.due_date, c.first_name, c.phone, rs.status_description, m.title FROM Rent_Movie as rm
                                INNER JOIN Rental_Status as rs on rm.rent_status_id = rs.rent_status_id
                                INNER JOIN Customers as c on rm.customer_id = c.customer_id
                                INNER JOIN Movie_copies as mc on mc.copy_id = rm.copy_id
                                INNER JOIN Movies as m on m.movie_id = mc.movie_id where c.customer_id='$id'";

        $result = mysqli_query($con,$sql);                
            if (mysqli_num_rows($result) > 0) {
                echo "<table style=\"width:100%\">";
                echo "<caption>Users</caption>";
                echo "<tr>";
                echo "<td> ID </td>";
                echo "<td> First_Name </td>";
                echo "<td> Phone</td>";
                echo "<td> Movie </td>";
                echo "<td> Rent date </td>";
                echo "<td> Due date </td>";
                echo "<td> Renatl Status</td>";
                echo "</tr>";

                while($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$row['customer_id']. "</td>";
                echo "<td>" .$row['first_name']. "</td>";
                echo "<td>" .$row['phone']. "</td>";
                echo "<td>" .$row['title']. "</td>";
                echo "<td>" .$row['rent_date']. "</td>";
                echo "<td>" .$row['due_date']. "</td>";
                echo "<td>" .$row['status_description']. "</td>";
                }
            }
       }
       //close connection

       mysqli_close($con);
}
 
?>


        