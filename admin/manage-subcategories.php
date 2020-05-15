<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{
    header('location:index.php');
}
else{
    if($_GET['action']=='del' && $_GET['scid'])
    {
        $id=intval($_GET['scid']);
        $active=0;
        $sql="UPDATE tbl_subcategory SET active='$active' WHERE id='$id'";
        $query=mysqli_query($con,$sql);
        if ($query) {

          $msg="Category deleted !!";
      }

  }
// Code for restore
  if($_GET['resid'])
  {
    $id=intval($_GET['resid']);
    $sql="UPDATE tbl_subcategory set active='1' WHERE id='$id'";
    $query=mysqli_query($con,$sql);
    if ($query) {
       
        $msg="Category restored successfully";
    }
}
// Code for Forever deletionparmdel
if($_GET['action']=='perdel' && $_GET['scid'])
{
    $id=intval($_GET['scid']);
    $sql="DELETE FROM tbl_subcategory WHERE id='$id'";
    $query=mysqli_query($con,$sql);
    if ($query) {
        $delmsg="Category deleted forever";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> News | Manage SubCategories</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <script src="assets/js/modernizr.min.js"></script>
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
                                <h4 class="page-title">Manage SubCategories</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">SubCategory </a>
                                    </li>
                                    <li class="active">
                                        Manage SubCategories
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-sm-6">

                            <?php if($msg){ ?>
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                                </div>
                            <?php } ?>
                            <?php if($delmsg){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?></div>
                                <?php } ?>
                            </div>




                            <div class="row">
                                <div class="col-md-12">
                                    <div class="demo-box m-t-20">
                                        <div class="m-b-30">
                                            <a href="add-subcategory.php">
                                                <button id="addToTable" class="btn btn-success waves-effect waves-light">Add <i class="mdi mdi-plus-circle-outline" ></i></button>
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table m-0 table-colored-bordered table-bordered-primary">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Description</th>

                                                        <th>Posting Date</th>
                                                        <th>Last updation Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql="SELECT tbl_subcategory.id as sid, tbl_catagory.catname as cname,tbl_subcategory.subcatname as scatname,tbl_subcategory.subcatdescription as scatd,tbl_subcategory.createdate as cdate,tbl_subcategory.updatedate as udate FROM tbl_subcategory JOIN tbl_catagory ON tbl_catagory.id=tbl_subcategory.catid WHERE tbl_subcategory.active='1'";
                                                    $query=mysqli_query($con,$sql);
                                                    $num=mysqli_num_rows($query);
                                                    if ($num>0) {
                                                        $cont=1;
                                                        while ($result=mysqli_fetch_array($query)) {

                                                           ?>
                                                           <tr>
                                                            <th scope="row"><?php echo htmlentities($cont);?></th>
                                                            <td><?php echo htmlentities($result['cname']);?></td>
                                                            <td><?php echo htmlentities($result['scatname']);?></td>
                                                            <td><?php echo htmlentities($result['scatd']);?></td>
                                                            <td><?php echo htmlentities($result['cdate']);?></td>
                                                            <td><?php echo htmlentities($result['udate']);?></td>
                                                            <td><a href="edit-subcategory.php?scid=<?php echo htmlentities($result['sid']);?>"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a>
                                                                &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($result['sid']);?>&&action=del"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
                                                            </tr>
                                                            <?php
                                                            $cont++;
                                                        } } else{?>


                                                          <tr>
                                                            <td colspan="7" align="center"><h3 style="color:red">No record found</h3></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--- end row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="demo-box m-t-20">
                                        <div class="m-b-30">
                                            <h4><i class="fa fa-trash-o" ></i> Deleted SubCategories</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table m-0 table-colored-bordered table-bordered-danger">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> Category</th>
                                                        <th>Sub Category</th>
                                                        <th>Description</th>

                                                        <th>Posting Date</th>
                                                        <th>Last updation Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                 <?php
                                                 $sql="SELECT tbl_subcategory.id as sid, tbl_catagory.catname as cname,tbl_subcategory.subcatname as scatname,tbl_subcategory.subcatdescription as scatd,tbl_subcategory.createdate as cdate,tbl_subcategory.updatedate as udate FROM tbl_subcategory JOIN tbl_catagory ON tbl_catagory.id=tbl_subcategory.catid WHERE tbl_subcategory.active='0'";
                                                 $query=mysqli_query($con,$sql);
                                                 $num=mysqli_num_rows($query);
                                                 if ($num>0) {
                                                    $cont=1;
                                                    while ($row=mysqli_fetch_array($query)) {

                                                       ?>
                                                       <tr>
                                                        <th scope="row"><?php echo htmlentities($cont);?></th>
                                                        <td><?php echo htmlentities($row['cname']);?></td>
                                                        <td><?php echo htmlentities($row['scatname']);?></td>
                                                        <td><?php echo htmlentities($row['scatd']);?></td>
                                                        <td><?php echo htmlentities($row['cdate']);?></td>
                                                        <td><?php echo htmlentities($row['udate']);?></td>
                                                        <td><a href="manage-subcategories.php?resid=<?php echo htmlentities($row['sid']);?>"><i class="ion-arrow-return-right" title="Restore this SubCategory"></i></a>
                                                            &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($row['sid']);?>&&action=perdel"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
                                                        </tr>
                                                        <?php
                                                        $cont++;
                                                    } }?>
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
            <!-- App js -->
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>
        </body>
        </html>
        <?php } ?>