<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>$(document).ready(function(){});</script>
        <script>
            var gid;
            var flag = 0;
            var True1 = "<?php echo ($_SESSION['role']); ?>";
            // alert("");

            function createGroup(grp_name) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {gp_nm: grp_name}
                }).done(function (response) {console.log(response)})
            }

            function showChat(gpid) {
                gid = gpid;
                // alert(gpid);
                $("#chat").css("display","block");
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {group_id: gpid}
                })
                .done(function (response) {
                    if(True1 == 'mentor_details') {
                        $("#showchats").html(response)
                    } else {
                        $("#showChatMant").html(response)
                    }
                })
                // document.getElementById("chat").style.display = 'block';
            }

            function sendMenteeChat(mntmessage) {
                // console.log("MENTEE_MSG CALLED");
                if(mntmessage == "") {} else {
                    // console.log("MENTEE_MSG CALLED");
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {mentee_msg: mntmessage}
                    })
                    .done(function (response) {alert(response)}) // $("#grps").html(response)
                    // console.log("MENTEE_MSG CALLED");
                    // $("#chat").css("display","block");
                }
            }

            function sendMentorChat(mntrmessage) {
                // alert(message);
                if(mntrmessage == "") {} else {
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {mntrmsg: mntrmessage,mntr_gp_id: gid}
                    })
                    .done(function (response) {console.log(response)}) //$("#grps").append(`<tr><td>${response}</td></tr>`)
                    // $("#chat").css("display","block");
                }
            }

            function back() {
                document.getElementById("chat").style.display = 'none';
            }

            function editGrp() {
                if(flag == 0) {
                    flag = 1;
                    $("#divmdgrp").css("display","block");
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {gp_id: gid,mdfygrp: 1}
                    })
                    .done(function (response) {
                        $("#mdfygrp1").html(response);
                    })
                } else {
                    flag = 0;
                    $("#divmdgrp").css("display","none");
                }
            }

            function rmvMnt(id) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data : {rmmntid: id}
                }).done(function (response) {
                    $(`#${id}`).remove();
                })
            }

            function addMnt(id) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {admntid: id, grp_id: gid}
                })
                .done(function (response) {
                    // alert(response);
                    $(`#${id}`).remove();
                })
            }

            // alert(gid+"\n"+msg);
        </script>
        <!-- <link rel="stylesheet" href="../css/home.css"> -->
        <link rel="stylesheet" href="../css/discussion.css">

    </head>
    <body>
        <div id="header">
            <div id="h1">
                <img src="../images/image-removebg-preview.png" alt="#LOGO">
            </div>
            <div id="h2">Discussion</div>    
            <div id="h3">
                <table id="ht">
                    <!-- <tr>
                        <td>
                            <button onclick="window.location.href = './signin.html'">Sign IN</button>
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            <button onclick="window.location.href = './signup.html'">Sign UP</button>
                        </td>
                    </tr> -->
                </table>
            </div>    
        </div>
        <div id="menu"></div>
        <?php
        if(isset($_SESSION["role"])) {
            ?>
            <?php
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
                        $('#ht').html(`<tr> <td><p><?php echo $row["first_name"] ?></p></td> <td><button onclick='window.location.href="./logout.php"'>Logout</button></td> </tr>`);
                        // document.getElementById("getdetail").style.display = 'block';
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'mentor_details') {
                    ?>

                    <div id="mentor">
                        <table>
                            <tr>
                                <td>
                                    <div id="chat">
                                        <table style="background: #e0e0e0; box-shadow:  20px 20px 60px #111111, -20px -20px 60px #ffffff;" width="100%" height="100%" >
                                            <tr>
                                                <td>
                                                    <div style="overflow: auto;">
                                                        <table id="showchats">
                                                            <!-- <tr></tr> -->
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table style="text-align: center;" width="100%" >
                                                        <tr>
                                                            <td>
                                                                <div style="overflow: auto;">
                                                                    <form>
                                                                    <!-- <form action="./functions.php" method="post"> -->
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <input type = "text" id="mentor_message" name="mentor_message" placeholder = "Enter Your Question" required>
                                                                                    <!-- <input type = "text" id="mentor_message" name="mntrmsg" placeholder = "Enter Your Question" required> -->
                                                                                </td>
                                                                                <td>
                                                                                    <input type="submit" value="Post" onclick="sendMentorChat(document.getElementById('mentor_message').value)" name="" id="">
                                                                                    <!-- <input type="submit" value="Post" name="" id=""> -->
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button onclick="editGrp()">Edit Group</button>
                                                            </td>
                                                            <td>
                                                                <button onclick="back()">Back</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <div style="display: none; overflow: auto; width: 100%" id="divmdgrp">
                                                        <table style="text-align: center">
                                                            <tr>
                                                                <td>
                                                                    <table id="mdfygrp1" >
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table id="mdfygrp2"></table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <table id="bt"></table>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <table id="grps">
                                            <tr>
                                                <th>Groups</th>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <script>
                        $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='red'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='red'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication With Mentees</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communicate_with_mentor.php">Communicate With Parents</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`);
                    </script>
                    <script>
                        /* $("#mentee").hide();
                        $("#mentor").show(); */
                        $('#bt').append('<tr>'+
                                        '<table>'+
                                        '<tr>'+
                                        '<td>'+
                                        '<form action = "./crtmnteegrp.php" method = "post">'+
                                        // '<form>'+
                                        '<table>'+
                                        '<tr>'+
                                        '    <td>'+
                                        '        <input type="text" name="gname" id="gname" placeholder="Enter Group Name" pattern="[a-z]{1,15}" title="Only lower characters are allowed." required>'+
                                        '    </td>'+
                                        '    <td>'+
                                        // '        <input type="submit" onclick="createGroup(document.getElementById("gname").value)" value="Create Group">'+
                                        '        <input type="submit" value="Create Group">'+
                                        '    </td>'+
                                        '</tr>'+
                                        '</table>'+
                                        '</form>'+
                                        '</td>'+
                                        '</tr>'+
                                        '</table>'+
                                        '</tr>');
                        // document.getElementById("getdetail").style.display = 'block';
                    </script>
                    <!-- <button>Create Group</button> -->
                    <?php
                    $selgrp = "SELECT group_name, group_id FROM group_details WHERE group_id IN (SELECT group_id FROM group_member WHERE mentor_id = $uid)";
                    $exeslgp = $conn->query($selgrp);
                    if($exeslgp->num_rows > 0) {
                        while($row = $exeslgp->fetch_assoc()) {
                            ?>
                            <script>
                                $("#grps").append("<tr> <td> <button onclick='showChat(<?php echo $row["group_id"]; ?>)'><?php echo $row["group_name"]; ?></button> </td> </tr>");
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'mentee_details') {
                    ?>

                    <div id="mentee">
                        <table>
                            <tr>
                                <td>
                                    <table id="showChatMant"></table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <form>
                                        <!-- <form action="./functions.php" method="post"> -->
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type = "text" id="mentee_message" name="mentee_message" placeholder = "Enter Your Question" required>
                                                        <!-- <input type = "text" id="mentee_message" name="mntmsg" placeholder = "Enter Your Question" required> -->
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="Post" onclick="sendMenteeChat(document.getElementById('mentee_message').value)" name="" id="">
                                                        <!-- <input type="submit" value="Post" name="" id=""> -->
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <script>
                        $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='red'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='red'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`);
                    </script>
                    <!-- <script>
                        $("#mentee").show();
                        $("#mentor").hide();
                    </script> -->
                    <?php
                    $uid = $_SESSION['uid'];
                    $selgrp = "SELECT group_id FROM group_member WHERE mentee_id = $uid";
                    $exe = $conn->query($selgrp);
                    if($exe->num_rows > 0) {
                        while($row = $exe->fetch_assoc()) {
                            $_SESSION['mnt_grp_id'] = $row['group_id'];
                            /* ?>
                                <script>alert(<?php echo $_SESSION['mnt_grp_id'];?>);</script>
                            <?php */
                        }
                    }
                    $sel = "SELECT discussion, sender_name, date_time FROM discussions WHERE group_id IN (SELECT group_id FROM group_member WHERE mentee_id = $uid)";
                    // echo $sel;
                    $exe = $conn->query($sel);
                    if($exe->num_rows > 0) {
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#showChatMant").append("<tr> <td> <b> [ </b><?php echo $row['date_time']; ?><b> ] </b></td> <td><b><?php echo $row['sender_name'];?></b></td> <td><?php echo $row['discussion']?></td> </tr>");
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'parent_details') {
                    ?>
                    <script>
                        $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='red'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communicate_with_mentor.php">Communicate With Mentor</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`);
                    </script>
                    <?php
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