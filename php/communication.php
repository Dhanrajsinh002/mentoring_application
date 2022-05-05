<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/communication.css">
        <script>$(document).ready(function(){});</script>
        <script>
            var mentee_id;

            function mentee_comm(mentee_comm_msg) {
                if(mentee_comm_msg == "") {} else {
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {mnt_comm_msg: mentee_comm_msg}
                    })
                    .done(function (response) {alert(response)})
                }
            }

            function back() {
                $("#comm_msg").remove();
                window.location.reload(true);
            }

            function commMentee(comm_msg) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {post_comm_msg: comm_msg,post_ment_id: mentee_id}
                }).done(function (response) {alert(response)})
            }

            function pastComms() {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {pastMnteeComms: mentee_id}
                }).done(function (response) {
                    $("#mentor_messages").append(response);
                })
            }

            function communicate(id) {
                mentee_id = id;
                $("#comm_msg").append(`
                    <table width="100%"  align="center">
                        <tr>
                            <td>
                                <table id="mentor_messages"  style="width: 100%; height: 10px; overflow: auto">
                                    <!-- <tr>
                                        <td>
                                            for mentor_messages
                                        </td>
                                    </tr> -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="text-align: center">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <form height="max-content">
                                                    <table width="100%" style="vertical-align: center; text-align: center">
                                                        <tr>
                                                            <td>
                                                                <!-- for input field -->
                                                                <!-- <input type="text" name="todo_message" id="todo_message" required> -->
                                                                <textarea id="todo_message" name="todo_message" rows="4" cols="50" required></textarea>
                                                            </td>
                                                            <td>
                                                                <input type="submit" onclick="commMentee(document.getElementById('todo_message').value)" value="Post">
                                                            </td>
                                                            <td align="center">
                                                                <button onclick="back()">Close</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                `);
                pastComms();
            }
        </script>
    </head>
    <body>
        <table  width="100%">
            <tr>
                <td>
                    <div id="header">
                        <table  width="100%" style="text-align: center;">
                            <tr>
                                <td width="22%">
                                    <div id="h1">
                                        <img style="width: 200px;" src="../images/image-removebg-preview.png" alt="#LOGO">
                                    </div>
                                </td>

                                <td>
                                    <div id="h2"><h1>Communication</h1></div>
                                </td>

                                <td width="22%">
                                    <div id="h3">
                                        <table id="ht"  width="100%"></table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div style="border-radius: 15px; background-color: #333" id="menu"></div>
                </td>
            </tr>

            <tr>
                <td id="dynamic-portion"></td>
            </tr>
        </table>
        
        <?php 
        if(isset($_SESSION["role"])) {
            $table = $_SESSION["role"];
            $id = explode('_',$_SESSION["role"],2);
            $uid = $_SESSION["uid"];

            $server_name = "localhost";
            $user_name = "root";
            $password = "";
            $db_name = "mentoring_application";

            $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
            if(!$conn) {
                die("Connection Failed: ".mysqli_connect_error());
            } else {
                $sel = "SELECT first_name FROM $table WHERE ".$id[0]."_id = $uid";
                // $null = "SELECT * FROM $table WHERE middle_name = '' AND ".$id[0]."_id = $uid";
                $exe = $conn->query($sel);
                while($row = $exe->fetch_assoc()) {
                    ?>
                    <script>
                        $('#ht').html(`<tr> <td><p><?php echo ucwords($id[0])."&nbsp;".$row["first_name"] ?></p></td> <td align="right"><button onclick='window.location.href="./logout.php"'>Logout</button></td> </tr>`);
                        // document.getElementById("getdetail").style.display = 'block';
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'mentor_details') {
                    ?>
                    <script>
                        $("#dynamic-portion").html(`
                            <table width="100%"  style="text-align: center">
                                <tr>
                                    <td>
                                        <div id="main">
                                            <div id="list"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="comm_msg" style="text-align: center"></div>
                                    </td>
                                </tr>
                            </table>`
                        );
                    </script>
                    <script>
                        $("#menu").html(`
                            <table width="100%">
                                <tr style="border-collaps: collaps; list-style-type: none; margin: 0; padding: 0; overflow: hidden;">
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communicate With Mentees</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./private_communicate.php">Communicate With Parents</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></td>
                                </tr>
                            </table>
                        `);
                    </script>
                    <?php
                        $selmnt = "SELECT mentee_id, gr_no, enrollment_no, first_name, middle_name,
                                    last_name, mobile_no, dob, gender, semester, stream, department
                                    FROM mentee_details WHERE mentee_id IN 
                                    (SELECT mentee_id FROM group_member WHERE mentor_id = $uid)";
                        $exe = $conn->query($selmnt);
                        if($exe->num_rows > 0) {
                            ?>
                                <script>
                                    $("#list").html(`<table width="100%" id="listtable">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>GR No</th>
                                                            <th>Enrollment No</th>
                                                            <th>First Name</th>
                                                            <th>Middle Name</th>
                                                            <th>Last Name</th>
                                                            <th>Mobile No</th>
                                                            <th>Gender</th>
                                                            <th>Semester</th>
                                                            <th>Stream</th>
                                                            <th>Department</th>
                                                            <th>Communicate</th>
                                                        </tr>
                                                    </table>`);
                                </script>
                            <?php
                            while($row = $exe->fetch_assoc()) {
                                ?>
                                <script>
                                    $("#listtable").append(`<tr align="center">
                                                            <td><?php echo $row["mentee_id"]; ?></td>
                                                            <td><?php echo $row["gr_no"]; ?></td>
                                                            <td><?php echo $row["enrollment_no"]; ?></td>
                                                            <td><?php echo $row["first_name"]; ?></td>
                                                            <td><?php echo $row["middle_name"]; ?></td>
                                                            <td><?php echo $row["last_name"]; ?></td>
                                                            <td><?php echo $row["mobile_no"]; ?></td>
                                                            <td><?php echo $row["gender"]; ?></td>
                                                            <td><?php echo $row["semester"]; ?></td>
                                                            <td><?php echo $row["stream"]; ?></td>
                                                            <td><?php echo $row["department"]; ?></td>
                                                            <td><button onclick="communicate(<?php echo $row["mentee_id"]; ?>)">Communicate</button></td>
                                                        </tr>`);
                                </script>
                                <?php
                            }
                        }
                }

                if($_SESSION['role'] == 'mentee_details') {
                    ?>
                    <script>
                        $("#menu").html(`
                            <table width="100%">
                                    <tr style="border-collaps: collaps; list-style-type: none; margin: 0; padding: 0; overflow: hidden;">
                                        <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></td>
                                        <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></td>
                                        <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></td>
                                        <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></td>
                                        <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></td>
                                    </tr>
                                </table>`);
                        </script>
                        <script>
                            $("#dynamic-portion").html(`
                                <div id="mentee_part">
                                <table width="100%" >
                                    <tr>
                                        <td>
                                            <div>
                                                <table width="100%"  id="mentee_comm_msg" height="50%">
                                                    <tr>
                                                        <th colspan="4">
                                                            <h3>Your Messages will be Appear Here!⬇️</h3>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <table width="100%" >
                                                    <tr>
                                                        <td>
                                                            <form style="height: fit-content; text-align: center;">
                                                                <table width="100%"  align="center" style="vertical-align: center; text-align: center;">
                                                                    <tr>
                                                                        <td>
                                                                            <!-- for input field -->
                                                                            <textarea id="mentee_comm_message" name="mentee_comm_message" rows="4" placeholder="Your Message" cols="50" required></textarea>
                                                                            <!-- <input type="text" name="mentee_comm_message" id="mentee_comm_message" placeholder="Your Message" required> -->
                                                                        </td>
                                                                        <td>
                                                                            <input type="submit" onclick="mentee_comm(document.getElementById('mentee_comm_message').value)" value="Post">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                                `);
                        </script>
                    <?php
                    $selmntcommmsg = "SELECT (SELECT first_name FROM mentor_details WHERE mentor_id IN (SELECT mentor_id FROM communnication WHERE mentee_id = $uid)) AS Mentor_Name,
                                            (SELECT first_name FROM mentee_details WHERE mentee_id IN (SELECT mentee_id FROM communnication WHERE mentee_id = $uid)) AS Mentee_Name,
                                            comm, date, who FROM communnication WHERE mentee_id = $uid ORDER BY date DESC";
                    if($exe = $conn->query($selmntcommmsg)) {
                        ?>
                        <script>
                            $("#mentee_comm_msg").append(`
                                    <tr>
                                        <th width="13.01%">Date & Time</th>
                                        <th width="20%">Who</th>
                                        <th align='left'>Communication</th>
                                    </tr>
                                `);
                        </script>
                        <?php
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#mentee_comm_msg").append(`
                                        <tr>
                                            <td><?php echo $row["date"]; ?></td>
                                            <?php
                                                if($row["who"] == "mentor") {
                                                    echo "<td align='center'>Mentor ".$row["Mentor_Name"]."</td>";
                                                } else {
                                                    echo "<td align='center'>Mentee ".$row["Mentee_Name"]."</td>";
                                                }
                                            ?>
                                            <td><?php echo $row["comm"]; ?></td>
                                        </tr>
                                    `);
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'parent_details') {
                    ?>
                    <script>
                        $("#menu").html(`
                        <table width="100%">
                                <tr style="border-collaps: collaps; list-style-type: none; margin: 0; padding: 0; overflow: hidden;">
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./private_communicate.php">Communicate With Mentor</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><div onmouseout="this.style.color='#333'" onmouseover="this.style.background-color='yellow'"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='yellow'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></td>
                                </tr>
                            </table>
                        `);
                    </script>
                    <?php

                    $selprntcomm = "SELECT (SELECT first_name FROM mentor_details WHERE mentor_id IN (SELECT mentor_id FROM relation WHERE parent_id = $uid)) AS Mentor_Name,
                    (SELECT first_name FROM mentee_details WHERE mentee_id IN (SELECT mentee_id FROM relation WHERE parent_id = $uid)) AS Mentee_Name,
                    comm, date, who FROM communnication WHERE mentee_id IN (SELECT mentee_id FROM relation WHERE parent_id = $uid) ORDER BY date DESC";
                    if($exe = $conn->query($selprntcomm)) {
                        ?>
                        <script>
                        $("#dynamic-portion").append(`<table id="showPrntMsg">
                                                            <tr>
                                                                <th colspan="4"><h3>You can see your Son's/Daughter's Personal Communications With Mentor</h3></th>    
                                                            </tr>
                                                            <tr>
                                                                <th width="13.01%">Date & Time</th>
                                                                <th width="20%">Who</th>
                                                                <th align="left">Communication</th>
                                                            </tr>
                                                        </table>`);
                        </script>
                        <?php
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#showPrntMsg").append(`
                                    <tr>
                                        <td><?php echo $row["date"]; ?></td>
                                        <?php
                                            if($row["who"] == "mentor") {
                                                echo "<td align='center'>Mentor ".$row["Mentor_Name"]."</td>";
                                            } else {
                                                echo "<td align='center'>Mentee ".$row["Mentee_Name"]."</td>";
                                            }
                                        ?>
                                        <td><?php echo $row["comm"]; ?></td>
                                    </tr>`);
                            </script>
                            <?php
                        }
                    }
                }
            }
        }
        else {
            ?>
            <script>
                $('#ht').html(`<tr> <td><button onclick='window.location.href = "../signin.html"'>Sign IN</button></td> <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td><button onclick='window.location.href = "../signup.html"'>Sign UP</button></td> </tr>`);
            </script>
            <?php
        }
        ?>

    </body>
</html>