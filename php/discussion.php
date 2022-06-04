<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/discussion.css">
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>$(document).ready(function(){});</script>
        <script>
            var gid;
            var flag = 0;
            var True1 = "<?php echo ($_SESSION['role']); ?>";

            function createGroup(grp_name) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {gp_nm: grp_name}
                }).done(function (response) {console.log(response)})
            }

            function showChat(gpid) {
                gid = gpid;
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
            }

            function sendMenteeChat(mntmessage) {
                if(mntmessage == "") {} else {
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {mentee_msg: mntmessage}
                    })
                    .done(function (response) {alert(response)})
                }
            }

            function sendMentorChat(mntrmessage) {
                if(mntrmessage == "") {} else {
                    $.ajax({
                        method: "post",
                        url: "./functions.php",
                        data: {mntrmsg: mntrmessage,mntr_gp_id: gid}
                    })
                    .done(function (response) {console.log(response)})
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

            function addMnt(id) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {admntid: id, grp_id: gid}
                })
                .done(function (response) {
                    $(`#${id}`).remove();
                })
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
                                    <div id="h2"><h1>Discussion</h1></div>
                                </td>

                                <td width="22%">
                                    <div id="h3">
                                        <table id="ht"  width="100%">
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
                    <div style="border-radius: 15px; background-color: #333" id="menu"></div>
                </td>
            </tr>
        </table>
        
        
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
                $exe = $conn->query($sel);
                while($row = $exe->fetch_assoc()) {
                    ?>
                    <script>
                        $('#ht').html(`<tr> <td><p><?php echo ucwords($id[0])."&nbsp;".$row["first_name"] ?></p></td> <td align="right"><button onclick='window.location.href="./logout.php"'>Logout</button></td> </tr>`);
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
                                                    <div style="display: none; overflow: auto; width: 100%;" id="divmdgrp">
                                                        <table style="text-align: center;">
                                                            <tr>
                                                                <td>
                                                                    <table id="mdfygrp1" style="border: 1px solid black; border-radius: 10px; border-spacing: 15px;">
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

                    <script>
                        function createGroup() {
                            var grp = document.getElementById("gname").value;
                            if(grp =="") {} else {
                                $.ajax({
                                    method: "post",
                                    url: "./functions.php",
                                    data: {grp_nm: grp}
                                })
                                .done(function (response) {
                                    alert(response)
                                    window.location.reload(true);
                                })
                            }
                        }
                    </script>
                    
                    <script>
                        $("#mentor").show();
                        $('#bt').append('<tr>'+
                                        '<table>'+
                                        '<tr>'+
                                        '<td>'+
                                        // '<form action = "./crtmnteegrp.php" method = "post">'+
                                        '<form>'+
                                        '<table style="text-align: center;">'+
                                        '<tr>'+
                                        '    <td>'+
                                        `        <input type="text" name="gname" id="gname" placeholder="Enter Group Name" pattern="[a-zA-Z0-9\s]+" title="No White Space allowed." required>`+
                                        '    </td>'+
                                        '</tr>'+
                                        '<tr>'+
                                        '    <td>'+
                                        '        <input type="submit" onclick="createGroup()" value="Create Group">'+
                                        // '        <input type="submit" value="Create Group">'+
                                        '    </td>'+
                                        '</tr>'+
                                        '</table>'+
                                        '</form>'+
                                        '</td>'+
                                        '</tr>'+
                                        '</table>'+
                                        '</tr>');
                    </script>
                    <?php
                    $selgrp = "SELECT group_name, group_id FROM group_details WHERE group_id IN (SELECT group_id FROM group_details WHERE mentor_id = $uid)";
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
                    <?php
                    $uid = $_SESSION['uid'];
                    $selgrp = "SELECT group_id FROM group_member WHERE mentee_id = $uid";
                    $exe = $conn->query($selgrp);
                    if($exe->num_rows > 0) {
                        while($row = $exe->fetch_assoc()) {
                            $_SESSION['mnt_grp_id'] = $row['group_id'];
                        }
                    }
                    $sel = "SELECT discussion, sender_name, date_time FROM discussions WHERE group_id IN (SELECT group_id FROM group_member WHERE mentee_id = $uid) ORDER BY date_time DESC";
                    $exe = $conn->query($sel);
                    if($exe->num_rows > 0) {
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#showChatMant").append(`
                                    <tr> 
                                        <td> <b> [ </b><?php echo $row['date_time']; ?><b> ] </b></td>
                                        <td><b><?php echo $row['sender_name'];?></b></td>
                                        <td><?php echo $row['discussion']?></td>
                                    </tr>`);
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'parent_details') {
                    ?>
                    <div>
                        <table  width="100%">
                            <tr>
                                <td>
                                    <table  width="100%" id="showChatToParent">
                                        <tr>
                                            <th colspan="3"><h3>You can only see your Son's/Daughter's Discussions with Mentor & Other Mentees</h3></th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
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
                    $selprntgrp = "SELECT discussion, sender_name, date_time FROM discussions
                                    WHERE group_id IN (SELECT group_id FROM group_member WHERE mentee_id IN
                                    (SELECT mentee_id FROM relation WHERE parent_id = $uid)) ORDER BY date_time DESC";
                    if($exe = $conn->query($selprntgrp)) {
                        ?>
                        <script>
                            $("#showChatToParent").append(`<tr>
                                                            <th width="15%">Date & Time</th>
                                                            <th width="20%">Who</th>
                                                            <th>Discussion</th>
                                                        </tr>`);
                        </script>
                        <?php
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#showChatToParent").append(`<tr>
                                                                <td width="15%"> <b> [ </b><?php echo $row['date_time']; ?><b> ] </b></td>
                                                                <td><b><?php echo $row['sender_name'];?></b></td>
                                                                <td><?php echo $row['discussion']?></td>
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