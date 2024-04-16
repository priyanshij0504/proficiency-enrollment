<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else{
$studRegno = $_SESSION['alogin'];
$enrollmentCheck = mysqli_query($con, "SELECT pid FROM students WHERE studentRegno = '$studRegno'");
$enrollmentData = mysqli_fetch_assoc($enrollmentCheck);
$enrolledPid = $enrollmentData ? $enrollmentData['pid'] : null;

$proficiencySql = null;

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $cgpa = $_POST['cgpa'];

    // Fetch proficiencies based on CGPA criteria
    $proficiencySql = mysqli_query($con, "SELECT * FROM proficiency WHERE mincgpa <= '$cgpa'");
}

// Check if the enrollment form is submitted
if (isset($_POST['enroll'])) {
    $pid = $_POST['pid'];

    // Update students table with the enrolled proficiency ID
    $updateSql = "UPDATE students SET pid = '$pid' WHERE studentRegno = '$studRegno'";
    $updateResult = mysqli_query($con, $updateSql);

    if ($updateResult) {
        $_SESSION['msg'] = "Enrolled successfully!";
        // Redirect to prevent form resubmission
        header('Location: enroll-proficiency.php');
        exit();
    } else {
        $_SESSION['msg'] = "Error: Could not enroll. Please try again.";
        header('Location: enroll-proficiency.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Student | Enroll Proficiency</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Enroll Proficiency </h1>
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
                        <div class="panel-body">
                            <?php if (!$enrolledPid) { ?>
                                <form name="enrollProficiency" method="post">
                                    <div class="form-group">
                                        <label for="studRegno">Student Reg No </label>
                                        <input type="text" class="form-control" id="studRegno" name="studRegno" value="<?php echo $studRegno; ?>" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="cgpa">CGPA </label>
                                        <input type="text" class="form-control" id="cgpa" name="cgpa" placeholder="CGPA" required />
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-default">Show Proficiencies</button>
                                </form>

                                <?php
                                if ($proficiencySql && mysqli_num_rows($proficiencySql) > 0) {
                                    ?>
                                    <h4>Available Proficiencies:</h4>
                                    <ul class="list-group">
                                        <?php
                                        while ($proficiencyRow = mysqli_fetch_array($proficiencySql)) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="proficiency"><?php echo htmlentities($proficiencyRow['name']); ?></label>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <form method="post" style="display: inline;">
                                                            <input type="hidden" name="studRegno" value="<?php echo $studRegno; ?>" />
                                                            <input type="hidden" name="pid" value="<?php echo $proficiencyRow['id']; ?>" />
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
                                    echo "<p>No proficiencies available based on the provided CGPA.</p>";
                                }
                            } else {
                                // If the user is already enrolled, display the enrolled proficiency name
                                $enrolledProficiencyName = getProficiencyName($con, $enrolledPid);
                                echo "<h4>Enrolled Proficiency:</h4>";
                                echo "<p>$enrolledProficiencyName</p>";
                            }
                            ?>
                        </div>
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
