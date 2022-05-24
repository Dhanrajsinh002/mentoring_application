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
$unm = $_SESSION["uname"];
$role = $_SESSION["role"];
$who = "";
if($role == "mentor_details") {
    $who = "Mentor ".$unm;
} else {
    $who = "Mentee ".$unm;
}
$target_dir = "../uploaded_files";

// displaying past discussion of mentor and mentee

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

// send discussion chats by mentor

if(isset($_POST["mntrmsg"])) {
    $gid = $_POST['mntr_gp_id'];
    $mntrmsg = $_POST['mntrmsg'];    
    $insd = "INSERT INTO discussions VALUES ($gid,'$mntrmsg','$who',current_timestamp())";
    $conn->query($insd);
}

// send discussion chats by mentee

if(isset($_POST["mentee_msg"])) {
    $gid = $_SESSION['mnt_grp_id'];
    $mntmsg = $_POST['mentee_msg'];
    $insmenmsg = "INSERT INTO discussions VALUES ($gid,'$mntmsg','$who',current_timestamp())";
    $conn->query($insmenmsg);
}

// modify group portion handled by mentor

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

    $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name, last_name, mobile_no, dob, 
                gender, semester, stream, department FROM mentee_details WHERE in_group = 0 AND status = 1";
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

// add mentee from group by mentor

if(isset($_POST["admntid"])) {
    $mtid = $_POST["admntid"];
    $gid = $_POST['grp_id'];
    $ins = "INSERT INTO group_member VALUES ($gid,$uid,$mtid)";
    $conn->query($ins);
    $upd = "UPDATE mentee_details SET in_group = 1 WHERE mentee_id = $mtid";
    $conn->query($upd);
    $updrel = "UPDATE relation SET mentor_id = $uid WHERE mentee_id = $mtid";
    $conn->query($updrel);
}

// remove mentee from group by mentor

if(isset($_POST["rmmntid"])) {
    $id = $_POST["rmmntid"];
    $rmv = "DELETE FROM group_member WHERE mentee_id = $id";
    $conn->query($rmv);
    $setzero = "UPDATE mentee_details SET in_group = 0 WHERE mentee_id = $id";
    $conn->query($setzero);
    $updrel = "UPDATE relation SET mentor_id = 0 WHERE mentee_id = $id";
    $conn->query($updrel);
}

// displaying past to do of mentor and mentee

if(isset($_POST["post_mnt_id"])) {
    // echo $_POST["mnt_id"];
    $mid = $_POST["post_mnt_id"];
    $seltodo = "SELECT task, file, date, who,
                (select first_name from mentee_details where mentee_id in 
                    (select mentee_id from to_do where mentee_id = $mid)) as Mentee_Name,
                (select first_name from mentor_details where mentor_id in
                    (select mentor_id from to_do where mentor_id = $uid)) as Mentor_Name
                FROM to_do WHERE mentee_id = $mid ORDER BY date DESC";
    $exe = $conn->query($seltodo);
    if($exe->num_rows > 0) {
        echo "<tr>
                <th width='14%'>Date & Time</th>
                <th width='15%'>Who</th>
                <th></th>
                <th>To Do Tasks</th>
                <th width='25%'>Files</th>
            </tr>";
        while($row = $exe->fetch_assoc()) {
            // echo "TASK ".$row["task"]."<br>"."DATE ".$row["date"]."<br>"."MNT-NAME ".$row["Mentee_Name"]."<br>"."MNTR-NAME ".;
            if($row["who"] == "mentor") {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td>Mentor ".$row["Mentor_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['task']."</td>
                    <td>".$row['file']."</td>
                </tr>";
            } else {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td>Mentee ".$row["Mentee_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['task']."</td>
                    <td>".$row['file']."</td>
                </tr>";
            }
        }
    }
}

// displaying past communication of mentor and mentee

if(isset($_POST["pastMnteeComms"])) {
    // echo $_POST["mnt_id"];
    $mid = $_POST["pastMnteeComms"];
    $seltodo = "SELECT comm, date, who, 
                (select first_name from mentee_details where mentee_id in 
                    (select mentee_id from communnication where mentee_id = $mid)) as Mentee_Name,
                (select first_name from mentor_details where mentor_id in
                    (select mentor_id from communnication where mentor_id = $uid)) as Mentor_Name
                FROM communnication WHERE mentee_id = $mid ORDER BY date DESC";
    $exe = $conn->query($seltodo);
    if($exe->num_rows > 0) {
        echo "<tr>
                <td width='20%'><b>Date & Time</b></td>
                <td><b>Mentee Name</b></td>
                <td width='2.5%'></td>
                <td><b>Conversation</b></td>
            </tr>";
        while($row = $exe->fetch_assoc()) {
            // echo "TASK ".$row["task"]."<br>"."DATE ".$row["date"]."<br>"."MNT-NAME ".$row["Mentee_Name"]."<br>"."MNTR-NAME ".;
            if($row["who"] == "mentor") {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td>Mentor ".$row["Mentor_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['comm']."</td>
                </tr>";
            } else {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td> Mentee".$row["Mentee_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['comm']."</td>
                </tr>";
            }
        }
    }
}

// displaying past communication of mentor and parents

if(isset($_POST["pastParentComms"])) {
    // echo $_POST["mnt_id"];
    $mid = $_POST["pastParentComms"];
    $seltodo = "SELECT comm, date, who,
                (select first_name from parent_details where parent_id in 
                    (select parent_id from parents_communnication where parent_id = $mid)) as Parent_Name,
                (select first_name from mentor_details where mentor_id in
                    (select mentor_id from parents_communnication where mentor_id = $uid)) as Mentor_Name
                FROM parents_communnication WHERE parent_id = $mid ORDER BY date DESC";
    $exe = $conn->query($seltodo);
    if($exe->num_rows > 0) {
        echo "<tr>
                <td width='20%'><b>Date & Time</b></td>
                <td><b>Who</b></td>
                <td width='2.5%'></td>
                <td><b>Conversation</b></td>
            </tr>";
        while($row = $exe->fetch_assoc()) {
            // echo "TASK ".$row["task"]."<br>"."DATE ".$row["date"]."<br>"."MNT-NAME ".$row["Mentee_Name"]."<br>"."MNTR-NAME ".;
            if($row["who"] == "mentor") {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td>Mentor ".$row["Mentor_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['comm']."</td>
                </tr>";
            } else {
                echo "<tr>
                    <td><b>[</b>".$row['date']."<b>]</b></td>
                    <td>Parent ".$row["Parent_Name"]."</td>
                    <td>: - </td>
                    <td>".$row['comm']."</td>
                </tr>";
            }
        }
    }
}

// MENTOR ASSIGN TODO TO MENTEE with file(not working)

if(isset($_POST["post_td_msg"])) {
    $msg = $_POST["post_td_msg"];
    $mnt_id = $_POST["post_ment_id"];
    $_FILES["upld_file"]["name"] = $_POST["upld_file"];
    $file = basename($_FILES["upld_file"]["name"]);
    // $file = (string)rand(10,1000)."_".(string)date("d/m/Y")."_".basename($_FILES["upld_file"]["name"]);
    $target_file = $target_dir.$file;
    // exit(0);
    if(move_uploaded_file($_FILES["upld_file"]["tmp_name"], $target_file)) {
        $instodo = "INSERT INTO to_do VALUES ($uid,$mnt_id,'$msg','$file','$today','mentor')";
        // echo $msg."\n".$mnt_id."\n".$instodo;
        if ($conn->query($instodo)) {
            ?>
            <script>
                alert("File Uploaded Successfully✅");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("File Upload Failed⚠️");
            </script>
            <?php
        }
    } else {
        ?>
            <script>
                alert("File can not be move to desired location⚠️");
            </script>
        <?php
    }
}

// first time profile update

if(isset($_POST["upd_arr"])) {
    $table = $_SESSION['role'];
    for($i = 0; $i < count($_POST["upd_arr"]); $i++) {
        $res = preg_match("/'([^']+)'/", $_SESSION["upd_arr"][$i], $m);
        $updv = $m[1];
        $data = $_POST["upd_arr"][$i];
        $upd = "UPDATE $table SET $updv = '$data' WHERE ".$id[0]."_id = $uid";
        $conn->query($upd);
    }
}

// connect mentee and their parents

if(isset($_POST["pname"])) {
    $pnm = $_POST["pname"];
    $pno = $_POST["pphone"];

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

// add new group created by mentee and check if it is exists or not

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

// add communication message by mentor to mentee

if(isset($_POST["post_comm_msg"])) {
    $comm_msg = $_POST["post_comm_msg"];
    $mentee_id = $_POST["post_ment_id"];
    $inscomm = "INSERT INTO communnication VALUES ($uid,$mentee_id,'$comm_msg','$today','mentor')";
    $conn->query($inscomm);
}

// add communication message by mentor to parents

if(isset($_POST["parent_comm_msg"])) {
    $comm_msg = $_POST["parent_comm_msg"];
    $parent_id = $_POST["post_parent_id"];
    $inscomm = "INSERT INTO parents_communnication VALUES ($uid,$parent_id,'$comm_msg','$today','mentor')";
    $conn->query($inscomm);
}

// add communication message by mentee to mentor

if(isset($_POST["mnt_comm_msg"])) {
    $mntr_id = 0;
    $msg = $_POST["mnt_comm_msg"];
    $sel_mntr_id = "SELECT mentor_id FROM relation WHERE mentee_id = $uid";
    if($exe = $conn->query($sel_mntr_id)) {
        while($row = $exe->fetch_assoc()) {
            $mntr_id = $row["mentor_id"];
        }
    }
    $ins_comm_msg = "INSERT INTO communnication VALUES ($mntr_id,$uid,'$msg','$today','mentee')";
    $conn->query($ins_comm_msg);
}

// add communication message by parent to mentor

if(isset($_POST["prnt_comm_msg"])) {
    $prntmsg = $_POST["prnt_comm_msg"];
    $mntrid = 0;
    $selmntrid = "SELECT mentor_id FROM mentor_details WHERE mentor_id IN (SELECT mentor_id FROM relation WHERE parent_id = $uid)";
    if($exe = $conn->query($selmntrid)) {
        while($row = $exe->fetch_assoc()) {
            $mntrid = $row["mentor_id"];
        }
        $sendprntcomm = "INSERT INTO parents_communnication VALUES ($mntrid,$uid,'$prntmsg','$today','parent')";
        $conn->query($sendprntcomm);
    }
}

// show mentee profiles when mentor is login

if(isset($_POST["showmntpr"])) {
    $mntId = $_POST["showmntpr"];
    $prntprf;
    $selprf = "SELECT gr_no, enrollment_no, first_name, middle_name, last_name,
                mobile_no, dob, gender, semester, stream, department, email_id
                FROM mentee_details WHERE mentee_id = $mntId";
    if($exe = $conn->query($selprf)) {
        while($row = $exe->fetch_assoc()) {
            $prntprf = $row["first_name"];
            echo "<table width='100%'>
                        <tr>
                            <th colspan='2'>".$row["first_name"]."'s Profile</th>
                        </tr>
                        <tr>
                            <th width='20%' >GR Number</th>
                            <td>".$row['gr_no']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Enrollment Number</th>
                            <td>".$row['enrollment_no']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >First Name</th>
                            <td>".$row['first_name']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Middle Name</th>
                            <td>".$row['middle_name']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Last Name</th>
                            <td>".$row['last_name']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Mobile Number</th>
                            <td>".$row['mobile_no']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Date of Birth</th>
                            <td>".$row['dob']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Gender</th>
                            <td>".$row['gender']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Semester</th>
                            <td>".$row['semester']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Stream</th>
                            <td>".$row['stream']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Department</th>
                            <td>".$row['department']."</td>
                        </tr>
                        <tr>
                            <th width='20%' >Email ID</th>
                            <td>".$row['email_id']."</td>
                        </tr>
                        <tr>
                            <td colspan='2' id='prntPrf'></td>
                        </tr>
                    </table>";
        }

        $selprntprf = "SELECT first_name, middle_name, last_name, mobile_no, dob, gender, occupation, email_id
                        FROM parent_details WHERE parent_id IN (SELECT parent_id FROM relation WHERE mentee_id = $mntId)";
        if($exeprntprf = $conn->query($selprntprf)) {
            while($row = $exeprntprf->fetch_assoc()) {
                ?>
                <script>
                    $("#prntPrf").html(`<table  width='100%'>
                                            <tr>
                                                <th colspan="2"><?php echo $prntprf?>'s Parent Profile</th>
                                            </tr>

                                            <tr>
                                                <th width='20%' >First Name</th>
                                                <td><?php echo $row["first_name"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Middle Name</th>
                                                <td><?php echo $row["middle_name"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Last Name</th>
                                                <td><?php echo $row["last_name"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Mobile Number</th>
                                                <td><?php echo $row["mobile_no"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Date of Birth</th>
                                                <td><?php echo $row["dob"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Gender</th>
                                                <td><?php echo $row["gender"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Occupation</th>
                                                <td><?php echo $row["occupation"];?></td>
                                            </tr>
                                            <tr>
                                                <th width='20%' >Email ID</th>
                                                <td><?php echo $row["email_id"];?></td>
                                            </tr>
                                        </table>`);
                </script>
                <?php
            }
        }
    }
}
?>