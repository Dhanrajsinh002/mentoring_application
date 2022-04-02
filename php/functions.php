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
            echo "<tr><td>".$row['sender_name']."</td><td> : - </td><td>".$row['discussion']."</td></tr>";
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

if(isset($_POST["mdfygrp"])) {
    $gpid = $_POST["gp_id"];
    $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name, last_name, mobile_no, dob, gender, semester, stream, department FROM mentee_details WHERE mentee_id IN (SELECT mentee_id FROM group_member WHERE group_id = $gpid)";
    $exe = $conn->query($selmnt);
    if($exe->num_rows > 0) {
        echo "<tr>
                <th>ID</th>
                <th>GR No.</th>
                <th>Enrollment No</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Mobile No</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Semester</th>
                <th>Stream</th>
                <th>Department</th>
                <th>Operation</th>
                </tr>";
        while($row = $exe->fetch_assoc()) {
            echo "<tr id=".$row["mentee_id"].">
                    <td>".$row["mentee_id"]."</td> 
                    <td>".$row["gr_no"]."</td> 
                    <td>".$row["enrollment_no"]."</td> 
                    <td>".$row["first_name"]."</td> 
                    <td>".$row["middle_name"]."</td> 
                    <td>".$row["last_name"]."</td> 
                    <td>".$row["mobile_no"]."</td> 
                    <td>".$row["dob"]."</td> 
                    <td>".$row["gender"]."</td> 
                    <td>".$row["semester"]."</td> 
                    <td>".$row["stream"]."</td> 
                    <td>".$row["department"]."</td>
                    <td><button onclick=rmvMnt(".$row['mentee_id'].")>Remove</button></td>
                    </tr>";
        }
    }

    $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name, last_name, mobile_no, dob, gender, semester, stream, department FROM mentee_details WHERE in_group = 0 AND status = 1";
    $exe = $conn->query($selmnt);
    if($exe->num_rows > 0) {
        while($row = $exe->fetch_assoc()) {
            echo "<tr id=".$row["mentee_id"].">
                    <td>".$row["mentee_id"]."</td> 
                    <td>".$row["gr_no"]."</td> 
                    <td>".$row["enrollment_no"]."</td> 
                    <td>".$row["first_name"]."</td> 
                    <td>".$row["middle_name"]."</td> 
                    <td>".$row["last_name"]."</td> 
                    <td>".$row["mobile_no"]."</td> 
                    <td>".$row["dob"]."</td> 
                    <td>".$row["gender"]."</td> 
                    <td>".$row["semester"]."</td> 
                    <td>".$row["stream"]."</td> 
                    <td>".$row["department"]."</td>
                    <td><button onclick=addMnt(".$row['mentee_id'].")>Add</button></td>
                    </tr>";
        }
    }
}

if(isset($_POST["rmmntid"])) {
    $id = $_POST["rmmntid"];
    // echo "\nMNTID ".$_POST["mntid"];
    $rmv = "DELETE FROM group_member WHERE mentee_id = $id";
    $conn->query($rmv);
    $setzero = "UPDATE mentee_details SET in_group = 0 WHERE mentee_id = $id";
    $conn->query($setzero);
}

if(isset($_POST["admntid"])) {
    // echo $_POST["admntid"];
    $mtid = $_POST["admntid"];
    $gid = $_SESSION['gid'];
    $mtrid = $_SESSION["uid"];
    $ins = "INSERT INTO group_member VALUES ($gid,$mtrid,$mtid)";
    $exe = $conn->query($ins);
    $upd = "UPDATE mentee_details SET in_group = 1 WHERE mentee_id = $mtid";
    $exe = $conn->query($upd);
}
?>