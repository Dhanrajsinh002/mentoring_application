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

if(isset($_POST["mntrmsg"])) {
    $gid = $_POST['mntr_gp_id'];
    $mntrmsg = $_POST['mntrmsg'];
    $unm = $_SESSION["uname"];
    // echo "GID ".$gid."\n";
    // echo "MSG ".$mntrmsg."\n";
    // echo "UNM ".$unm."\n";
    // exit(0);
    $insd = "INSERT INTO discussions VALUES ($gid,'$mntrmsg','$unm')";
    // echo $insd;
    // exit(0);
    $conn->query($insd);
}

if(isset($_POST["mentee_msg"])) {
    $gid = $_SESSION['mnt_grp_id'];
    $mntmsg = $_POST['mentee_msg'];
    $unm = $_SESSION["uname"];
    echo "GID ".$gid;
    echo "<br>MSG ".$mntmsg;
    echo "<br>UNM ".$unm;
    // exit(0);
    $insmenmsg = "INSERT INTO discussions VALUES ($gid,'$mntmsg','$unm')";
    echo "<br>".$insmenmsg;
    // exit(0);
    $conn->query($insmenmsg);
    header("Location:./discussion.php");
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

// MENTOR TO DO SELECT OLD CHATS

if(isset($_POST["post_mnt_id"])) {
    // echo $_POST["mnt_id"];
    $mid = $_POST["post_mnt_id"];
    $uid = $_SESSION["uid"];
    $role = $_SESSION["role"];
    $seltodo = "SELECT task, date, 
                (select first_name from mentee_details where mentee_id in 
                    (select mentee_id from to_do where mentee_id = $mid)) as Mentee_Name,
                (select first_name from mentor_details where mentor_id in
                    (select mentor_id from to_do where mentor_id = $uid)) as Mentor_Name
                FROM to_do";
    $exe = $conn->query($seltodo);
    if($exe->num_rows > 0) {
        // if($role == "mentor_details") {
            
        // }
        while($row = $exe->fetch_assoc()) {
            // echo "TASK ".$row["task"]."<br>"."DATE ".$row["date"]."<br>"."MNT-NAME ".$row["Mentee_Name"]."<br>"."MNTR-NAME ".;
            echo "<tr><td>(".$row['date'].")</td><td>".$row["Mentor_Name"]."</td><td>: - </td><td>".$row['task']."</td></tr>";
        }
    }

}

// MENTOR ASSIGN TODO TO MENTEE

if(isset($_POST["post_td_msg"])) {
    $msg = $_POST["post_td_msg"];
    $mnt_id = $_POST["post_ment_id"];
    $uid = $_SESSION["uid"];
    $dt = date('Y-m-d');
    $instodo = "INSERT INTO to_do VALUES ($uid,$mnt_id,'$msg','$dt')";
    $conn->query($instodo);
}
?>