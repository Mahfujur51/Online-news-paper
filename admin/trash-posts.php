<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{
    header('location:index.php');
}
else{
    if($_GET['action']='restore' && $_GET['rid'])
    {
        $postid=intval($_GET['rid']);
        $sql="UPDATE tbl_post SET active='1' WHERE id='$postid'";
        $query=mysqli_query($con,$sql);
        if($query)
        {
            $msg="Post restored successfully ";
        }
        else{
            $error="Something went wrong . Please try again.";
        }
    }
// Code for Forever deletionparmdel
    if($_GET['action']='del' && $_GET['del'])
    {
        $id=intval($_GET['del']);
        $sql="DELETE FROM tbl_post WHERE id='$id'";
        $query=mysqli_query($con,$sql);
        if ($query) {
            $delmsg="Post deleted forever";
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
        <title>Newsportal | Manage Posts</title>
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="../plugins/morris/morris.css">
        <!-- jvectormap -->
        <link href="../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="assets/js/modernizr.min.js"></script>
</head>
<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php');?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
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
                                <h4 class="page-title">Trashed Posts </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">Posts</a>
                                    </li>
                                    <li class="active">
                                        Trashed Posts
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($delmsg){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <div class="table-responsive">
                                            <table class="table table-colored table-centered table-inverse m-0">
                                                <thead>
                                                    <tr>
                                                        <th>SlNo.</th>
                                                        <th>Title</th>
                                                        <th>Category</th>
                                                        <th>Subcategory</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql="SELECT tbl_post.id as pid,tbl_post.posttitle as ptitle,tbl_catagory.catname as cname,tbl_subcategory.subcatname as sname FROM tbl_post JOIN tbl_catagory on tbl_post.catid=tbl_catagory.id JOIN tbl_subcategory on tbl_subcategory.id=tbl_post.subcatid WHERE tbl_post.active='0'";
                                                    $query=mysqli_query($con,$sql);
                                                    $num=mysqli_num_rows($query);
                                                    if ($num>0) {
                                                        $cont=1;
                                                        while($row=mysqli_fetch_array($query))
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td> <?php echo $cont; ?></td>
                                                                <td><b><?php echo htmlentities($row['ptitle']);?></b></td>
                                                                <td><?php echo htmlentities($row['cname'])?></td>
                                                                <td><?php echo htmlentities($row['sname'])?></td>
                                                                <td><a href="?rid=<?php echo htmlentities($row['pid']);?>&&action=restore"><i class="ion-arrow-return-right" title="Restore this Post"></i></a>
                                                                    &nbsp;<a href="?del=<?php echo htmlentities($row['pid']);?>&&action=del" onclick="return confirm('Do you reaaly want to delete ?')"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
                                                                </tr>
                                                                <?php $cont++; } } else{
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="4" align="center"><h3 style="color:red">No record found</h3></td>
                                                                        </tr> <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                <!-- CounterUp  -->
                                <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
                                <script src="../plugins/counterup/jquery.counterup.min.js"></script>
                                <!--Morris Chart-->
                                <script src="../plugins/morris/morris.min.js"></script>
                                <script src="../plugins/raphael/raphael-min.js"></script>
                                <!-- Load page level scripts-->
                                <script src="../plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
                                <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
                                <script src="../plugins/jvectormap/gdp-data.js"></script>
                                <script src="../plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
                                <!-- Dashboard Init js -->
                                <script src="assets/pages/jquery.blog-dashboard.js"></script>
                                <!-- App js -->
                                <script src="assets/js/jquery.core.js"></script>
                                <script src="assets/js/jquery.app.js"></script>
                            </body>
                            </html>
                            <?php } ?>