<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    //Code for Insertion
    if (isset($_POST['submit'])) {
        $name = $_POST['name']; // Updated field name
        $mincgpa = $_POST['mincgpa']; // Updated field name
        $ret = mysqli_query($con, "insert into proficiency(name,mincgpa) values('$name','$mincgpa')");
        if ($ret) {
            echo '<script>alert("Proficiency Created Successfully !!")</script>';
            echo '<script>window.location.href=proficiency.php</script>';
        } else {
            echo '<script>alert("Error : Proficiency not created!!")</script>';
            echo '<script>window.location.href=proficiency.php</script>';
        }
    }

    //Code for deletion
    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from proficiency where id = '" . $_GET['id'] . "'");
        echo '<script>alert("Proficiency deleted!!")</script>';
        echo '<script>window.location.href=proficiency.php</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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
                                <div class="form-group">
                                    <label for="coursecode">Proficiency Name </label>
                                    <input type="text" class="form-control" id="coursecode" name="name" placeholder="Proficiency Name" required />
                                </div>

                                <div class="form-group">
                                    <label for="coursename">Minimum CGPA </label>
                                    <input type="text" class="form-control" id="coursename" name="mincgpa" placeholder="Minimum CGPA" required />
                                </div>
                                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?></font>
            <div class="col-md-12">
                <!--    Bordered Table  -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Proficiency
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Proficiency Name</th>
                                        <th>Minimum CGPA </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "select * from proficiency");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlentities($row['name']); ?></td>
                                            <td><?php echo htmlentities($row['mincgpa']); ?></td>
                                            <td>
                                                <a href="edit-proficiency.php?id=<?php echo $row['id'] ?>">
                                                    <button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                </a>
                                                <a href="proficiency.php?id=<?php echo $row['id'] ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                                    <button class="btn btn-danger">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  End  Bordered Table  -->
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
