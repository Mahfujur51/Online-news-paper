<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{
    header('location:index.php');
}
else{
    if(isset($_POST['update']))
    {
     $id=intval($_GET['pid']);
     $posttitle=$_POST['posttitle'];
     $catid=$_POST['catid'];
     $subcatid=$_POST['subcatid'];
     $postdatils=mysqli_real_escape_string($con,$_POST['postdatils']);
     $arr = explode(" ",$posttitle);
     $posturl=implode("-",$arr);
     $status=1;

     $usql="UPDATE tbl_post SET posttitle='$posttitle',catid='$catid',subcatid='$subcatid',postdatils='$postdatils',active='$status',posturl='$posturl' WHERE id='$id'";

     $uquery=mysqli_query($con,$usql);
     if($uquery)
     {
        $msg="Post updated ";
    }
    else{
        $error="Something went wrong . Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App title -->
    <title>Newsportal | Add Post</title>
    <!-- Summernote css -->
    <link href="../plugins/summernote/summernote.css" rel="stylesheet" />
    <!-- Select2 -->
    <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Jquery filer css -->
    <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
    <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <script src="assets/js/modernizr.min.js"></script>
    <script>
        function getSubCat(val) {
            $.ajax({
                type: "POST",
                url: "get_subcategory.php",
                data:'catid='+val,
                success: function(data){
                    $("#subcategory").html(data);
                }
            });
        }
    </script>
</head>
<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php');?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Edit Post </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#"> Posts </a>
                                    </li>
                                    <li class="active">
                                        Add Post
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <!---Success Message--->
                            <?php if($msg){ ?>
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                                </div>
                            <?php } ?>
                            <!---Error Message--->
                            <?php if($error){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $id=intval($_GET['pid']);
                        $sql="SELECT tbl_post.id as pid,tbl_post.postimage as pimage,tbl_post.postdatils as pdetails,tbl_post.posttitle as ptitle,tbl_catagory.catname as cname,tbl_catagory.id as cid,tbl_subcategory.id as sid,tbl_subcategory.subcatname as sname FROM tbl_post JOIN tbl_catagory on tbl_post.catid=tbl_catagory.id JOIN tbl_subcategory on tbl_subcategory.id=tbl_post.subcatid WHERE tbl_post.active='1' AND tbl_post.id='$id'";
                        $query=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($query))
                        {
                            ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="p-6">
                                        <div class="">
                                            <form name="addpost" method="post">
                                                <div class="form-group m-b-20">
                                                    <label for="exampleInputEmail1">Post Title</label>
                                                    <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['ptitle']);?>" name="posttitle" placeholder="Enter title" required>
                                                </div>
                                                <div class="form-group m-b-20">
                                                    <label for="exampleInputEmail1">Category</label>
                                                    <select class="form-control" name="catid" id="category" onChange="getSubCat(this.value);" required>
                                                        <option value="<?php echo htmlentities($row['cid']);?>"><?php echo htmlentities($row['cname']);?></option>
                                                        <?php
                                    // Feching active categories
                                                        $csql="SELECT * FROM tbl_catagory WHERE active='1'";
                                                        $cquery=mysqli_query($con,$csql);
                                                        while($result=mysqli_fetch_array($cquery))
                                                        {
                                                            ?>
                                                            <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['catname']);?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group m-b-20">
                                                    <label for="exampleInputEmail1">Sub Category</label>
                                                    <select class="form-control" name="subcatid" id="subcategory" required>
                                                        <option value="<?php echo htmlentities($row['sid']);?>"><?php echo htmlentities($row['sname']);?></option>
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card-box">
                                                            <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                                                            <textarea class="summernote" name="postdatils" required><?php echo htmlentities($row['pdetails']);?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card-box">
                                                            <h4 class="m-b-30 m-t-0 header-title"><b>Post Image</b></h4>
                                                            <img src="postimages/<?php echo htmlentities($row['pimage']);?>" width="300"/>
                                                            <br />
                                                            <br>
                                                            <a href="change-image.php?pid=<?php echo $row['pid']; ?>" class="btn btn-primary">Change image</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update </button>
                                        </div>
                                    </div> <!-- end p-20 -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                    <?php include('includes/footer.php');?>
                </div>
                <!-- ============================================================== -->
                <!-- End Right content here -->
                <!-- ============================================================== -->
            </div>
            <!-- END wrapper -->
            <script>
                var resizefunc = [];
            </script>
            <!-- jQuery  -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/detect.js"></script>
            <script src="assets/js/fastclick.js"></script>
            <script src="assets/js/jquery.blockUI.js"></script>
            <script src="assets/js/waves.js"></script>
            <script src="assets/js/jquery.slimscroll.js"></script>
            <script src="assets/js/jquery.scrollTo.min.js"></script>
            <script src="../plugins/switchery/switchery.min.js"></script>
            <!--Summernote js-->
            <script src="../plugins/summernote/summernote.min.js"></script>
            <!-- Select 2 -->
            <script src="../plugins/select2/js/select2.min.js"></script>
            <!-- Jquery filer js -->
            <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
            <!-- page specific js -->
            <script src="assets/pages/jquery.blog-add.init.js"></script>
            <!-- App js -->
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>
            <script>
                jQuery(document).ready(function(){
                    $('.summernote').summernote({
            height: 240,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
            // Select2
            $(".select2").select2();
            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });
        });
    </script>
    <script src="../plugins/switchery/switchery.min.js"></script>
    <!--Summernote js-->
    <script src="../plugins/summernote/summernote.min.js"></script>
</body>
</html>
<?php } ?>