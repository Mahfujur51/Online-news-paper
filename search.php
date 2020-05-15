<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>News Portal | Search  Page</title>
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
        if($_POST['searchtitle']!=''){
          $st=$_SESSION['searchtitle']=$_POST['searchtitle'];
        }
        $st;

        if (isset($_GET['page'])) {
          $page=$_GET['page'];

        }
        else {
          $page=1;
        }
        $num_per_page=05;
        $start_from=($page-1)*05;
        $sql="SELECT tbl_post.id as pid,tbl_post.posttitle as posttitle,tbl_post.postimage as pimage,tbl_catagory.catname as cname,tbl_catagory.id as cid,tbl_subcategory.subcatname as sname,tbl_subcategory.id as sid,tbl_post.postdatils as pdetils,tbl_post.postingdate as pdate FROM tbl_post JOIN tbl_catagory ON tbl_catagory.id=tbl_post.catid JOIN tbl_subcategory ON tbl_subcategory.id=tbl_post.subcatid WHERE tbl_post.active='1' AND tbl_post.posttitle LIKE '%$st%' LIMIT $start_from,$num_per_page";
        $query=mysqli_query($con,$sql);
        $rowcount=mysqli_num_rows($query);
        if($rowcount==0)
        {
          echo "Search Result Not found";
        }
        else {
          while ($row=mysqli_fetch_array($query)) {
            ?>
            <div class="card mb-4">

              <div class="card-body">
                <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>

                <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on <?php echo htmlentities($row['pdate']);?>

              </div>
            </div>
          <?php } ?>
          <center>

      <?php
      $pr_query="SELECT * FROM tbl_post WHERE active='1'";
      $pr_result=mysqli_query($con,$pr_query);
      $total_record=mysqli_num_rows($pr_result);
      $total_page=ceil($total_record/$num_per_page);

      if ($page>1) {

        echo "<a href='search.php?page=".($page-1)."' class='btn btn-danger'>Previous</a>";

      }
      for ($i=1; $i <$total_page ; $i++) {
        echo "<a href='search.php?page=".$i."' class='btn btn-primary'>$i</a>";
      }
      if ($i>$page) {

        echo "<a href='search.php?page=".($page+1)."' class='btn btn-danger'>Next</a>";

      }


      ?>
    </center>
        <?php } ?>


        <!-- Pagination -->
      </div>
      <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php');?>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
  <!-- Footer -->
  <?php include('includes/footer.php');?>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>
</body>
</html>