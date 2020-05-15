<?php
session_start();
include('includes/config.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_POST['submit']))
{
//Verifying CSRF Token
  if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
      $name=$_POST['name'];
      $email=$_POST['email'];
      $comment=$_POST['comment'];
      $postid=intval($_GET['nid']);
      $status='0';
      $query=mysqli_query($con,"INSERT INTO  tbl_comments(postid,name,email,comment,status) values('$postid','$name','$email','$comment','$status')");
      if($query):
        echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
        unset($_SESSION['token']);
      else :
        echo "<script>alert('Something went wrong. Please try again.');</script>";
      endif;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>News Portal | Home Page</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <?php include('includes/header.php');?>
  <!-- Page Content -->
  <div class="container">
    <div class="row" style="margin-top: 4%">
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <!-- Blog Post -->
        <?php
        $pid=intval($_GET['nid']);
        $sql="SELECT tbl_post.id as pid,tbl_post.posttitle as posttitle,tbl_post.postimage as pimage,tbl_catagory.catname as cname,tbl_catagory.id as cid,tbl_subcategory.subcatname as sname,tbl_subcategory.id as sid,tbl_post.postdatils as pdetils,tbl_post.postingdate as pdate FROM tbl_post JOIN tbl_catagory ON tbl_catagory.id=tbl_post.catid JOIN tbl_subcategory ON tbl_subcategory.id=tbl_post.subcatid WHERE tbl_post.id='$pid'";
        $query=mysqli_query($con,$sql);
        while ($row=mysqli_fetch_array($query)) {
          ?>
          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
              <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['cname']);?></a> |
                <b>Sub Category : </b><?php echo htmlentities($row['sname']);?> <b> Posted on </b><?php echo htmlentities($row['pdate']);?></p>
                <hr />
                <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['pimage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                <p class="card-text"><?php
                $pt=$row['pdetils'];
                echo  (substr($pt,0));?></p>
              </div>
              <div class="card-footer text-muted">
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- Sidebar Widgets Column -->
        <?php include('includes/sidebar.php');?>
      </div>
      <!-- /.row -->
      <!---Comment Section --->
      <div class="row" style="margin-top: -8%">
        <div class="col-md-8">
          <div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form name="Comment" method="post">
                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="Enter your fullname" required>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Enter your Valid email" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
            </div>
          </div>
          <!---Comment Display Section --->
          <?php
          $status=1;
          $postid=intval($_GET['nid']);
          $query=mysqli_query($con,"SELECT * FROM tbl_comments WHERE status='$status' AND postid='$postid' ");
          while ($row=mysqli_fetch_array($query)) {
            ?>
            <div class="media mb-4">
              <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
              <div class="media-body">
                <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                  <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingdate']);?></span>
                </h5>
                <?php echo htmlentities($row['comment']);?>            </div>
              </div>
            <?php } ?>

          </div>
        </div>
      </div>
      <?php include('includes/footer.php');?>
      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>