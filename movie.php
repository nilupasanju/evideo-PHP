<?php
include 'header.php';
?>
        <div class="rowm">
            <div class="row">
                <img src="images/genre/a1.jpeg" style="width:25%; height:auto">
                <img src="images/genre/r1.jpeg" style="width:25%; height:auto">
                <img src="images/genre/h1.jpeg" style="width:25%; height:auto">
                <img src="images/genre/k1.jpeg" style="width:25%; height:auto">
            </div>
        </div>
        <br><br>
       
        <div class="rowm">
            <form action="./movie.php" method="POST">
                <label>Title</label><br>
                <input name="action" type="hidden" value="search1">
                <input type="text" name="title" placeholder="" size="20" value="">
                
                <button value="search1" name="search1"id="search1" method="post">Search</button></br>
            </form>
            <br><br>
            <?php
            
            $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

            if(mysqli_connect_errno()) {
                //echo "</br>Failed to connect to Database".mysqli_connect_error();
            }else{
               // echo "</br>connected to databse";
                if(isset($_POST['action']) && $_POST['action'] == 'search1'){
                    //echo "<br>find Movies";
                    $title=mysqli_real_escape_string($con,$_POST['title']);
                    $sql = "SELECT* from Movies where title like'%$title'";
                   // echo "$sql";
                    $result = mysqli_query($con, $sql);
                    if($result->num_rows>0){
                        echo "<table style=\"width:100%\">";
                        echo "<caption> Movies </caption>";
                        echo "<tr>";
                        echo "<td>Title </td>";
                        echo "<td> Movie year </td>";
                        echo "<td> Description </td>";
                        echo "<td> Length </td>";
                        echo "<td> price </td>";
                        echo "<td> Action </td>";
                        echo "</tr>";
        
                        while($row=$result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" .$row['title']. "</td>";
                            echo "<td>" .$row['movie_year']. "</td>";
                            echo "<td>" .$row['movie_description']. "</td>";
                            echo "<td>" .$row['movie_length']. "</td>";
                            echo "<td>" .$row['daily_price']. "</td>";
                            echo "<td>
                                        <table>
                                            <tr>
                                                <td>"
                                                ?>
                                                
                                                <a href="rating.php?id=<?php echo $row['movie_id'];?>">Rating</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <?
                            echo "</tr>";
                        }

                        echo "</table>";
                    }
                    
                    
                }
                mysqli_close($con);
            }
        
            ?>
        </div> 
        <br><br>    

            
        <div class="rowm">  
            
            <form action="./movie.php" method="POST">
                <input name="action" type="hidden" value="search2">
                <label>Format(DVD/VHS)</label><br>
            
                <input type="text"  name="format" placeholder="" value="">
                <button value="search2" name="search2"id="search2" method="post">Search</button></br>
            </form>
            <br><br>
            <?php
                
                $con = mysqli_connect("127.0.0.1","root","","EpicVideo");

                if(mysqli_connect_errno()) {
                    echo "</br>Failed to connect to Database".mysqli_connect_error();
                }else{
                    //echo "</br>connected to databse";
                    

                    if(isset($_POST['action']) && $_POST['action'] == 'search2'){
                        
                        $format=$_REQUEST['format'];
                    
                        $sql = "SELECT Movies.title
                        FROM ((Movies
                        INNER JOIN Movie_Copies ON Movie_Copies.movie_id = Movies.movie_id)
                        INNER JOIN Movie_Format ON Movie_Format.format_id = Movie_Copies.format_id)
                        where  Movie_Format.format_typ = '$format';";
                    // echo $sql;
                        $result = mysqli_query($con, $sql);
                    
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table id='movies'>
                                    <tr>
                                        <td>";
                            while ($movie = mysqli_fetch_array($result)){
                                
                                echo "$movie[0]<br>";
                                echo "$movie[1]<br>";
                            }
                            
                        }
                        echo "</td></tr></table>";
                    }
                    
                    mysqli_close($con);

                    
                }
        
            ?>
        </div>
        <br><br>
        <div class="rowm">
          
            <form action="./movie.php" method="POST">
                <label for="genre"> Choose a genre:</label>
                <select name="genres" id="genre">
                    <option value = "" selected> Select option </option>  
                    <option value="Kids">Kids</option>
                    <option value="Romantic">Romantic</option>
                    <option value="Action">Action</option>
                    <option value="horror">Horror</option>
                    <option value="Commedy">Commedy</option>
                </select>
                <input type="submit" name="submit"value="Submit">
                <input type="hidden" name="action" value="submit">
            </form>
            <br><br>
            <?php


                    if(isset($_POST['submit'])){
                        if(!empty($_POST['genres'])) {
                            echo "<br>find Movies";
                            $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
                            
                            
                            $selected_genres = $_POST['genres'];
                            echo 'You have chosen: ' . $selected_genres;
                            $sql=  "SELECT m.title, m.movie_year, m.movie_length, mg.genre_description
                                FROM Movies as m
                                INNER JOIN Movie_genre as mg ON mg.genre_id = m.genre_id 
                                where mg.genre_description='$selected_genres'";

                            $result = mysqli_query($con, $sql);
                        
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table style=\"width:100%\">";
                    
                                echo "<tr>";
                                echo "<td> Title </td>";
                                echo "<td> Movie length </td>";
                                echo "<td> year</td>";
                                echo "<td> Description </td>";
                                
                                echo "</tr>";
                
                                while($row=$result->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>" .$row['title']. "</td>";
                                echo "<td>" .$row['movie_length']. "</td>";
                                echo "<td>" .$row['movie_year']. "</td>";
                                echo "<td>" .$row['genre_description']. "</td>";
                                
                                }
                            }
                            echo "</td></tr></table>";
                            mysqli_close($con);
                        }
                    } 
             
       
                
            
            
        ?>
        </div>
        
       
        <footer class="footer">
           
            <nav class="footer-nav">    
                <a href="https://www.facebook.com/ATMCSOCIAL/" class="fa fa-facebook"></a>
                <a href="https://twitter.com/atmc_australia?lang=en" class="fa fa-twitter"></a>
                
                <p>
                    Copyright &copy; 2021 by EpicVedio. All rights reserved.
                </p>
            
            </nav>
         </footer>
       

</body>
</html>