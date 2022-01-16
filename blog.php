<?php
include_once 'header.php';
?>
        <div>
            <input name="action" type="hidden" value="create">
            <button ><a href="./createpost_v2.php">+ Create Post</a></button>
        </div>           
<?php
$con = mysqli_connect("127.0.0.1","root","","EpicVideo");

//echo "hiiiii  1";
//select Blog from Blog table 
$sql= "SELECT * FROM Blog";
$sql1="SELECT b.title, b.content, c.first_name, b.create_date, b.blog_id FROM Blog as b                
LEFT JOIN Customers as c ON c.customer_id = b.customer_id";
//Save Result
$result = mysqli_query($con, $sql1);
//if result has many rows

foreach ($result as $q){
// echo $q['title'];
    
?>
        <div class="row">
            <div class="card" >
                <h2><?php echo $q['title'];?></h2>
                <h5><?php echo $q['first_name'],$q['create_date']; ?></h5>
                <div class="fakeimg" style="height:20x;">Image</div>
                <p><?php echo $q['content'];?></p>
                <a href="view.php?blog_id=<?php echo $q['blog_id'];?>">Comment</a>
            </div>
        </div> 
        </br>            
<?
}
?>
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