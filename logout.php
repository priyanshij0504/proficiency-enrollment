<?php
session_start();
include("includes/config.php");
$_SESSION['alogin'] = "";
date_default_timezone_set('Asia/Kolkata');
$ldate = date('d-m-Y h:i:s A', time());
$uid = $_SESSION['alogin'];
// mysqli_query($con, "UPDATE userlog SET logout = '$ldate' WHERE studentRegno = '$uid' ORDER BY id DESC LIMIT 1");
session_unset();
$_SESSION['errmsg'] = "You have successfully logged out";
?>
<script language="javascript">
    document.location = "index.php";
</script>
