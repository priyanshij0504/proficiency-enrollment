<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else{
    $proficiencySql = null;

    // Check if the student is already enrolled
    if (isset($_POST['submit'])) {
        $studRegno = $_POST['studRegno'];
        $studName = $_POST['studentname'];
        $semester = $_POST['semester'];

        // Retrieve proficiency ID from students table
        $proficiencyIdSql = mysqli_query($con, "SELECT pid FROM students WHERE StudentRegno='$studRegno'");
        $proficiencyIdData = mysqli_fetch_assoc($proficiencyIdSql);
        $pid = $proficiencyIdData['pid'];

        // Modify the SQL query to join proficiency table
        $proficiencySql = mysqli_query($con, "SELECT c.*, p.name as proficiencyName FROM course c JOIN proficiency p ON c.proficiency = p.id WHERE c.semester = '$semester' AND p.id = '$pid'");
    }

    if (isset($_POST['enroll'])) {
        $studRegno = $_POST['studRegno'];
        $semester = $_POST['semester'];
        $cid = $_POST['cid'];

        // Update students table with the enrolled proficiency ID
        $updateSql = "INSERT INTO courseenrolls(StudentRegno, semester, course) VALUES ('$studRegno', '$semester', '$cid')";
        $updateResult = mysqli_query($con, $updateSql);

        if ($updateResult) {
            // Display a success message or reload the current page
            echo '<script>alert("Enrolled successfully!");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        } else {
            $_SESSION['msg'] = "Error: Could not enroll. Please try again.";
            // Display an error message or reload the current page
            echo '<script>alert("Error: Could not enroll. Please try again.");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        }
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Student | Enroll Elective</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php include('includes/header.php');?>
    <?php if($_SESSION['alogin']!="")
    {
     include('includes/menubar.php');
    }
     ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Enroll Elective </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enroll Proficiency
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                        <?php
            $sql = mysqli_query($con, "SELECT s.*, p.name as proficiencyName FROM students s JOIN proficiency p ON s.pid = p.id WHERE s.StudentRegno='" . $_SESSION['alogin'] . "'");
            $cnt = 1;
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <div class="panel-body">
                    <form name="dept" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="studentname">Student Name </label>
                            <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']); ?>" />
                        </div>

                        <div class="form-group">
                            <label for="studentregno">Student Reg No </label>
                            <input type="text" class="form-control" id="studentregno" name="studRegno" value="<?php echo htmlentities($row['StudentRegno']); ?>" placeholder="Student Reg no" readonly />
                        </div>

                        <div class="form-group">
                            <label for="semester">Semester </label>
                            <input type="text" class="form-control" id="semester" name="semester" placeholder="Semester" required />
                        </div>

                        <!-- Display Proficiency Name in the Form -->
                        <div class="form-group">
                            <label for="proficiencyName">Proficiency Name </label>
                            <input type="text" class="form-control" id="proficiencyName" name="proficiencyName" value="<?php echo htmlentities($row['proficiencyName']); ?>" readonly />
                        </div>

                        <button type="submit" name="submit" id="submit" class="btn btn-default">Show Courses</button>
                    </form>
                </div>

                            <?php
                            if (isset($proficiencySql)) {
                                $proficiencyRows = mysqli_num_rows($proficiencySql);
                                if ($proficiencyRows > 0) {
                                    ?>
                                    <h4>Available Electives:</h4>
                                    <ul class="list-group">
                                        <?php
                                        while ($proficiencyRow = mysqli_fetch_array($proficiencySql)) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="course"><?php echo htmlentities($proficiencyRow['courseName']); ?></label>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <form method="post" style="display: inline;">
                                                            <input type="hidden" name="studRegno" value="<?php echo $studRegno; ?>" />
                                                            <input type="hidden" name="semester" value="<?php echo $semester; ?>" />
                                                            <input type="hidden" name="cid" value="<?php echo $proficiencyRow['id']; ?>" />
                                                            <button type="submit" name="enroll" id="enroll" class="btn btn-success">Enroll</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                <?php
                                } else {
                                    echo "<p>No electives available based on the selected semester and proficiency.</p>";
                                }
                            }
                            ?>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
</body>

</html>
<?php } ?>
<?php  
function getProficiencyName($con, $pid)
{
    $proficiencySql = mysqli_query($con, "SELECT name FROM proficiency WHERE id = '$pid'");
    $proficiencyData = mysqli_fetch_assoc($proficiencySql);
    return $proficiencyData ? htmlentities($proficiencyData['name']) : '';
}
?>
