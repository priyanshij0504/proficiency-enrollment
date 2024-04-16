<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if(isset($_GET['submit'])) {
        $courseId = $_GET['proficiency'];

        // Fetch the elective name using the selected course ID
        $sqlCourse = mysqli_query($con, "SELECT * FROM course WHERE id='$courseId'");
        $courseRow = mysqli_fetch_assoc($sqlCourse);
        $coursename = $courseRow['courseName'];
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Admin | Students Enrolled</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php include('includes/header.php'); ?>
    <!-- LOGO HEADER END-->
    <?php if($_SESSION['alogin'] != "") {
        include('includes/menubar.php');
    } ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Students Enrolled </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Enrolled
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                        <div class="panel-body">
                            <form name="dept" method="get" action="students-enrolled.php">
                                <div class="form-group">
                                    <label for="proficiency">Elective Name </label>
                                    <select class="form-control" name="proficiency" required="required">
                                        <option value="">Select Elective</option>
                                        <?php
                                        $sql = mysqli_query($con, "select * from course");
                                        while($row = mysqli_fetch_array($sql)) {
                                            ?>
                                            <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['courseName']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Check if $courseId is set before displaying students
            if (isset($courseId)) {
                // SQL query to join courseenrolls and students based on course ID
                $sql = "SELECT ce.id, ce.studentRegno, ce.semester, s.studentName
                        FROM courseenrolls ce
                        JOIN students s ON ce.studentRegno = s.studentRegno
                        WHERE ce.course = '$courseId'";

                $result = mysqli_query($con, $sql);

                if ($result) {
            ?>

                    <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?></font>
                    <div class="col-md-12">
                        <!-- Bordered Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Students Enrolled in <?php echo $coursename; ?>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Registration No.</th>
                                                <th>Student Name</th>
                                                <th>Semester</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo htmlentities($row['studentRegno']); ?></td>
                                                    <td><?php echo htmlentities($row['studentName']); ?></td>
                                                    <td><?php echo htmlentities($row['semester']); ?></td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Bordered Table -->
                    </div>
            <?php
                } else {
                    echo "Error in query: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.js"></script>
</body>

</html>
<?php } ?>
