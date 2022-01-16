<?php
$id ;
if(isset($_REQUEST['blog_id'])){
    $id = $_REQUEST['blog_id'];
}
?>
<?php
include 'header.php';
?>
        
<h3>Posts</h3>
                  
<?php
    
    if(isset($id)){
        //echo "hi";
        $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
        //select messages from Message tale where customer_id=login customer id
        $sql1="SELECT b.title, b.content, c.first_name, b.create_date FROM Blog as b                
        LEFT JOIN Customers as c ON c.customer_id = b.customer_id where blog_id = '$id'";
        //echo $id;
        //Save Result
        $result = mysqli_query($con, $sql1);
        foreach ($result as $q){
?>
                <div class="row">
                    <div class="card" >
                        <h2><?php echo $q['title'];?></h2>
                        <h5><?php echo $q['first_name'],$q['create_date']; ?></h5>
                        <div class="fakeimg" style="height:20x;">Image</div>
                        <p><?php echo $q['content'];?></p>
                    </div>
                    <label>Comments</label><br>
                    <form action="view.php" method="post">
                        <textarea id="comment" name="comment"></textarea>
                        <input type="submit" value="Submit">
                        <input type="hidden" name="action" value="insertcomment">
                        <input type="hidden" name="blog_id" value="<?php echo $id;?>" />
                    <form>
                </div>
                   
<?php 
        }
        
    }
?>
                    
<?php
if(isset($id) && isset($_POST['action']) && $_POST['action'] == 'insertcomment'){
    
    $con = mysqli_connect("127.0.0.1","root","","EpicVideo");
    $comment=$_REQUEST['comment'];
    $sql = "UPDATE Blog SET
    comment='$comment' where blog_id='$id'";
    //echo $comment;
    if(mysqli_query($con,$sql)){ 
        $sql1 = "SELECT * FROM Blog where blog_id='$id'"; 

        $result = mysqli_query($con,$sql1); 
    
        if (mysqli_num_rows($result)>0) { 

           
            
            while ($row = mysqli_fetch_array($result)){ 
            
            echo "REPLY: "; 
            
            echo $row[4]; 
            } 
        }
        mysqli_close($con); 
    }
}
?>

    
        <br><br>
    <?php
    include 'footer.php';
    ?>
          
   
