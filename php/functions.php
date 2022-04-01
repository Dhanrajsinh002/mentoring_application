<?php
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);

if(isset($_POST["cta"])) {
    $mtid = $_POST["mentee_id"];
    $gid = $_SESSION['gid'];
    $mtrid = $_SESSION["uid"];
    $ins = "INSERT INTO group_member VALUES ($gid,$mtrid,$mtid)";
    $exe = $conn->query($ins);
    $upd = "UPDATE mentee_details SET in_group = 1 WHERE mentee_id = $mtid";
    $exe = $conn->query($upd);
}

if(isset($_POST["group_id"])) {
    $gpid = $_POST["group_id"];
    $sel = "SELECT discussion, sender_name FROM discussions WHERE group_id = $gpid";
    $exe = $conn->query($sel);
    if($exe->num_rows > 0) {
        while ($row = $exe->fetch_assoc()) {
            echo $row['sender_name']." : - ".$row['discussion'];
        }
    }
}

if(isset($_POST["msg"])) {
    $gid = $_POST['gp_id'];
    $msg = $_POST['msg'];
    $unm = $_SESSION["uname"];
    // echo "GID ".$gid."\n";
    // echo "MSG ".$msg."\n";
    // echo "UNM ".$unm."\n";
    // exit(0);
    $insd = "INSERT INTO discussions VALUES ($gid,'$msg','$unm')";
    $conn->query($insd);
}
?>