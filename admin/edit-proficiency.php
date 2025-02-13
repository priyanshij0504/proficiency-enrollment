<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $id = intval($_GET['id']);
    date_default_timezone_set('Asia/Kolkata'); // change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    if (isset($_POST['submit'])) {
        $name = $_POST['coursecode']; // Updated field name
        $mincgpa = $_POST['coursename']; // Updated field name
        $ret = mysqli_query($con, "update proficiency set name='$name',mincgpa='$mincgpa' where id='$id'");
        if ($ret) {
            echo '<script>alert("Proficiency Updated Successfully !!")</script>';
            echo '<script>window.location.href=proficiency.php</script>';
        } else {
            echo '<script>alert("Error : Proficiency not Updated!!")</script>';
            echo '<script>window.location.href=proficiency.php</script>';
        }
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Proficiency</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php include('includes/header.php'); ?>
    <!-- LOGO HEADER END-->
    <?php if ($_SESSION['alogin'] != "") {
        include('includes/menubar.php');
    }
    ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Proficiency </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Proficiency
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                        <div class="panel-body">
                            <form name="dept" method="post">
                                <?php
                                $sql = mysqli_query($con, "select * from proficiency where id='$id'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <div class="form-group">
                                        <label for="coursecode">Proficiency Name </label>
                                        <input type="text" class="form-control" id="coursecode" name="coursecode" placeholder="Proficiency Name" value="<?php echo htmlentities($row['name']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="coursename">Minimum CGPA </label>
                                        <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Minimum CGPA" value="<?php echo htmlentities($row['mincgpa']); ?>" required />
                                    </div>

                                <?php } ?>
                                <button type="submit" name="submit" class="btn btn-default"><i class="fa fa-refresh "></i> Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
</body>

</html>
<?php } ?>
