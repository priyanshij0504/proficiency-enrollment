<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    $id = intval($_GET['id']);
    date_default_timezone_set('Asia/Kolkata'); // change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if(isset($_POST['submit'])) {
        $coursecode = $_POST['coursecode'];
        $coursename = $_POST['coursename'];
        $proficiency = $_POST['proficiency'];
        $semester = $_POST['courseunit']; // Corrected form field name
        $credits = $_POST['seatlimit']; // Corrected form field name

        $ret = mysqli_query($con, "UPDATE course SET courseCode='$coursecode', courseName='$coursename', proficiency='$proficiency', semester='$semester', credits='$credits' WHERE id='$id'");
        
        if($ret) {
            echo '<script>alert("Elective Updated Successfully !!")</script>';
            echo '<script>window.location.href="course.php"</script>'; // Corrected redirect
        } else {
            echo '<script>alert("Error : Elective not Updated!!")</script>';
            echo '<script>window.location.href="course.php"</script>'; // Corrected redirect
        }
    }

    $sql = mysqli_query($con, "SELECT * FROM course WHERE id='$id'");
    $row = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Elective</title>
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
                    <h1 class="page-head-line">Elective </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Elective
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                        <div class="panel-body">
                            <form name="dept" method="post">
                                <?php
                                // Fetching proficiency data
                                $proficiencySql = mysqli_query($con, "SELECT * FROM proficiency");
                                $proficiencyOptions = '';
                                while ($proficiencyRow = mysqli_fetch_array($proficiencySql)) {
                                    $selected = ($proficiencyRow['id'] == $row['proficiency']) ? 'selected="selected"' : '';
                                    $proficiencyOptions .= '<option value="' . htmlentities($proficiencyRow['id']) . '" ' . $selected . '>' . htmlentities($proficiencyRow['name']) . '</option>';
                                }
                                ?>

                                <div class="form-group">
                                    <label for="coursecode">Elective Code </label>
                                    <input type="text" class="form-control" id="coursecode" name="coursecode" placeholder="Elective Code" value="<?php echo htmlentities($row['courseCode']); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="coursename">Elective Name </label>
                                    <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Course Name" value="<?php echo htmlentities($row['courseName']); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="proficiency">Proficiency </label>
                                    <select class="form-control" name="proficiency" required="required">
                                        <option value="">Select Proficiency</option>
                                        <?php echo $proficiencyOptions; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="courseunit">Semester </label>
                                    <input type="text" class="form-control" id="courseunit" name="courseunit" placeholder="Semester" value="<?php echo htmlentities($row['semester']); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label for="seatlimit">Credits </label>
                                    <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Credits" value="<?php echo htmlentities($row['credits']); ?>" required />
                                </div>

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
