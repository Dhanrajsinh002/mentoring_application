<?php
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);

$today = date("Y-m-d H:i:s");
$id = explode('_',$_SESSION["role"],2);
$uid = $_SESSION["uid"];
$role = $_SESSION["role"];

if(isset($_POST["cta"])) {
    $mtid = $_POST["mentee_id"];
    $gid = $_SESSION['gid'];
    $ins = "INSERT INTO group_member VALUES ($gid,$uid,$mtid)";
    $exe = $conn->query($ins);
    $upd = "UPDATE mentee_details SET in_group = 1 WHERE mentee_id = $mtid";
    $exe = $conn->query($upd);
}

if(isset($_POST["group_id"])) {
    $gpid = $_POST["group_id"];
    $sel = "SELECT discussion, sender_name, date_time FROM discussions WHERE group_id = $gpid ORDER BY date_time DESC";
    // $sel = "SELECT discussion, sender_name, date_time FROM discussions WHERE group_id IN (SELECT group_id FROM group_member WHERE mentee_id = $uid)";
    $exe = $conn->query($sel);
    if($exe->num_rows > 0) {
        while ($row = $exe->fetch_assoc()) {
            echo "<tr> <td> <b> [ </b>".$row['date_time']."<b> ] </b></td> <td><b>".$row['sender_name']."</b></td><td> : - </td><td>".$row['discussion']."</td></tr>";
        }
    }
}

if(isset($_POST["gp_nm"])) {
    $nm = $_POST["gp_nm"];
    $ins = "INSERT INTO group_details (group_name) VALUES ('$nm')";
    echo $ins;
    // $conn->query($ins);
}

if(isset($_POST["mntrmsg"])) {
    $gid = $_POST['mntr_gp_id'];
    $mntrmsg = $_POST['mntrmsg'];
    $unm = $_SESSION["uname"];
    $insd = "INSERT INTO discussions VALUES ($gid,'$mntrmsg','$unm',current_timestamp())";
    $conn->query($insd);
}

if(isset($_POST["mentee_msg"])) {
    $gid = $_SESSION['mnt_grp_id'];
    $mntmsg = $_POST['mentee_msg'];
    $unm = $_SESSION["uname"];
    $insmenmsg = "INSERT INTO discussions VALUES ($gid,'$mntmsg','$unm',current_timestamp())";
    $conn->query($insmenmsg);
}

if(isset($_POST["mdfygrp"])) {
    $gpid = $_POST["gp_id"];
    $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name, last_name, mobile_no, dob, gender, semester, stream, department FROM mentee_details WHERE mentee_id IN (SELECT mentee_id FROM group_member WHERE group_id = $gpid)";
    $exe = $conn->query($selmnt);
    echo "<tr style='border: 1px solid black; border-radius: 10px;'>
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
    if($exe->num_rows > 0) {
        while($row = $exe->fetch_assoc()) {
            echo "<tr style='border: 1px solid black; border-radius: 10px;' id=".$row["mentee_id"].">
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
                    <td><button style='width: 100%; background-color: red; border-radius: 5px; border: none; color: white; height: 100%' onclick=rmvMnt(".$row['mentee_id'].")>Remove</button></td>
                    </tr>";
        }
    }

    $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name, last_name, mobile_no, dob, gender, semester, stream, department FROM mentee_details WHERE in_group = 0 AND status = 1";
    $exe = $conn->query($selmnt);
    if($exe->num_rows > 0) {
        while($row = $exe->fetch_assoc()) {
            echo "<tr style='border: 1px solid black; border-radius: 10px;' id=".$row["mentee_id"].">
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
                    <td><button style='width: 100%; background-color: lightskyblue; border-radius: 5px; border: none; color: white; height: 100%' onclick=addMnt(".$row['mentee_id'].")>Add</button></td>
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
    $gid = $_POST['grp_id'];
    $ins = "INSERT INTO group_member VALUES ($gid,$uid,$mtid)";
    // echo $ins;
    $exe = $conn->query($ins);
    $upd = "UPDATE mentee_details SET in_group = 1 WHERE mentee_id = $mtid";
    // echo $upd;
    $exe = $conn->query($upd);
}

// MENTOR TO DO SELECT OLD CHATS

if(isset($_POST["post_mnt_id"])) {
    // echo $_POST["mnt_id"];
    $mid = $_POST["post_mnt_id"];
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
    $dt = date('Y-m-d');
    $instodo = "INSERT INTO to_do VALUES ($uid,$mnt_id,'$msg','$dt')";
    $conn->query($instodo);
}

if(isset($_POST["upd_arr"])) {
    // $split = $_SESSION["upd_arr"][0];
    // $res = preg_match("/'([^']+)'/", $_SESSION["upd_arr"][0], $m);
    // $updv = $m[1];
    // // exit(0);
    $table = $_SESSION['role'];
    for($i = 0; $i < count($_POST["upd_arr"]); $i++) {
        $res = preg_match("/'([^']+)'/", $_SESSION["upd_arr"][$i], $m);
        $updv = $m[1];
        // echo $updv."->".$_POST["upd_arr"][$i]."\n";
        $data = $_POST["upd_arr"][$i];
        $upd = "UPDATE $table SET $updv = '$data' WHERE ".$id[0]."_id = $uid";
        // echo $upd."\n";
        $conn->query($upd);
    }
    // echo $id[0]."_id = ".$uid;
}

if(isset($_POST["pname"])) {
    $pnm = $_POST["pname"];
    $pno = $_POST["pphone"];

    // echo $pnm."\n".$pno;
    $sel = "SELECT parent_id FROM parent_details WHERE first_name = '$pnm' AND mobile_no = $pno";
    if($exe = $conn->query($sel)) {
        while($row = $exe->fetch_assoc()) {
            $pid = $row["parent_id"];
            $ins = "UPDATE relation SET parent_id = $pid WHERE mentee_id = $uid";
            $conn->query($ins);
        }
    }
    else {
        echo "No Results Found";
    }
}

if(isset($_POST["grp_nm"])) {
    $gp_nm = $_POST["grp_nm"];
    // echo $gp_nm;
    $selgrp = "SELECT group_name FROM group_details WHERE group_name = '$gp_nm'";
    $exe = $conn->query($selgrp);
    if($exe->num_rows > 0) {
        echo "Group $gp_nm is already Created!!\nTry give different name!!";
    }
    else {
        $ins = "INSERT INTO group_details (mentor_id,group_name) VALUES ($uid,'$gp_nm')";
        // echo $ins;
        $exeins = $conn->query($ins);
        echo "Group $gp_nm Created Successfully";
    }
}
?>