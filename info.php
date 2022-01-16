<?php
include_once 'header.php';
?>
        
       
        <div class="row">
            <form action="./info.php" method="POST">
                <label>Users</label>
                <button value="search2" name="search2"id="search2" method="post">Search</button></br>
                <input name="action" type="hidden" value="search2">
                
            </form>
            <br><br>

<?php

    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

    if(mysqli_connect_errno()) {
        echo "</br>Failed to connect to Database".mysqli_connect_error();
    }else{
        //echo "</br>connected to databse";
        

        if(isset($_POST['action']) && $_POST['action'] == 'search2'){
            
            $name=$_REQUEST['name'];

            $sql="SELECT * FROM Customers";
        
            $sql1 = "SELECT rm.rent_date, rm.due_date, c.first_name, c.phone, rs.status_description, m.title FROM Rent_Movie as rm
                    INNER JOIN Rental_Status as rs on rm.rent_status_id = rs.rent_status_id
                    INNER JOIN Customers as c on rm.customer_id = c.customer_id
                    INNER JOIN Movie_copies as mc on mc.copy_id = rm.copy_id
                    INNER JOIN Movies as m on m.movie_id = mc.movie_id where c.customer_id=1";
            
            //$sql= "SELECT * from rental_information";

            $result = $con->query($sql);
        
            if (mysqli_num_rows($result) > 0) {
                
                    echo "<table style=\"width:100%\">";
                    echo "<caption>Users</caption>";
                    echo "<tr>";
                    echo "<td> ID </td>";
                    echo "<td> First_Name </td>";
                    echo "<td> Last_Name </td>";
                    echo "<td> Contact </td>";
                    echo "<td> email Id </td>";
                    echo "<td> Action </td>";
                    echo "</tr>";
    
                    while($row=$result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" .$row['customer_id']. "</td>";
                    echo "<td>" .$row['first_name']. "</td>";
                    echo "<td>" .$row['last_name']. "</td>";
                    echo "<td>" .$row['phone']. "</td>";
                    echo "<td>" .$row['email']. "</td>";
                    echo "<td>
                            <table>
                                <tr>
                                    <td>"
                                    ?>
                                    
                                    <a href="rental.php?id=<?php echo $row['customer_id'];?>">Rental_Info</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <?
                    echo "</tr>";
                }
                
                
            }
            
        }
        
        mysqli_close($con);   

        
    }

?>             
        </div>
        <div>
            <form action="./info.php" method="POST">
                <label>Movie Information</label>
                <input name="action" type="hidden" value="view2">
                <button value="view2" name="view2"id="view2" method="post">View</button>
            </form>
            <br><br>
<?php

    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

    if(mysqli_connect_errno()) {
        echo "</br>Failed to connect to Database".mysqli_connect_error();
    }else{
        //echo "</br>connected to databse";
        

        if(isset($_POST['action']) && $_POST['action'] == 'view2'){
            echo "<br>Movie Information";
            
            $sql= "SELECT m.title, m.movie_length, m.movie_year, m.movie_description, m.daily_price, mf.format_typ  from Movies as m
            INNER JOIN Movie_copies as mc on mc.movie_id = m.movie_id
            INNER JOIN Movie_Format as mf on mf.format_id = mc.format_id";

            $result = mysqli_query($con,$sql);                
            if (mysqli_num_rows($result) > 0) {
                echo "<table style=\"width:100%\">";
    
                echo "<tr>";
                echo "<td> Title </td>";
                echo "<td> Movie length </td>";
                echo "<td> year</td>";
                echo "<td> Description </td>";
                echo "<td> Format</td>";
                echo "<td> Daily_Price </td>";

                echo "</tr>";

                while($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$row['title']. "</td>";
                echo "<td>" .$row['movie_length']. "</td>";
                echo "<td>" .$row['movie_year']. "</td>";
                echo "<td>" .$row['movie_description']. "</td>";
                echo "<td>" .$row['format_typ']. "</td>";
                echo "<td>" .$row['due_date']. "</td>";
                echo "<td>" .$row['daily_price']. "</td>";
                }
            }
        
        }
        
        mysqli_close($con);   

        
    }

?>

        </div>
<?php
include 'footer.php';
?>
        
        
       

