<?php
session_start();
include('includes/config.php');

if (isset($_POST['submit'])) {
    $regno = $_POST['regno'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM students WHERE StudentRegno='$regno' AND password='$password'";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['alogin'] = $row['StudentRegno'];
        header("Location: http://localhost/onlinecourse/change-password.php");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid Reg no or Password";
        header("Location: index.php");
        exit();
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

    <title>Student Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include('includes/header.php');?>

    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                             <li><a href="admin/">Admin Login </a></li>
                             <li><a href="index.php">Student Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please Login To Enter </h4>
                </div>
            </div>
            <span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>
            <form name="admin" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label>Enter Reg no : </label>
                        <input type="text" name="regno" class="form-control"  />
                        <label>Enter Password :  </label>
                        <input type="password" name="password" class="form-control"  />
                        <hr />
                        <button type="submit" name="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Log Me In </button>&nbsp;
                    </div>
                </form>
                <!-- Removed the news section -->
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
