<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            var gid;
            var flag = 0;
            var True = "<?php echo ($_SESSION['role']); ?>";
            // alert("");
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
                    if(True == 'mentor_details') {
                        $("#showchats").html(response)
                    } else {
                        $("#showChatMant").html(response)
                    }
                })
                // document.getElementById("chat").style.display = 'block';
            }

            function sendMenteeChat(message) {
                if(mntmsg == "") {} else {
                    $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {msg: message,gp_id: gid}
                    })
                    .done(function (response) {$("#grps").html(response)})
                    // $("#chat").css("display","block");
                }
                
            }

            function sendMentorChat(message) {
                // alert(message);
                if(message == "") {} else {
                    $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {msg: message,gp_id: gid}
                    })
                    .done(function (response) {alert(response)}) //$("#grps").append(`<tr><td>${response}</td></tr>`)
                    $("#chat").css("display","block");
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
                    data: {admntid: id}
                })
                .done(function (response) {
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
                                <table>
                                    <tr>
                                        <td>
                                            <input type = "text" id="mentee_message" name="mentee_message" placeholder = "Enter Your Question" required>
                                        </td>
                                        <td>
                                            <input type="file" name="mfile" id="">
                                        </td>
                                        <td>
                                            <input type="submit" value="Post" onclick="sendMenteeChat(sendMenteeChat(document.getElementById('mentee_message').value)" name="" id="">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="mentor">
            <table border="1">
                <tr>
                    <td>
                        <div id="chat">
                            <table border="1">
                                <tr>
                                    <td>
                                        <div style="overflow: auto;">
                                            <table border="1" id="showchats">
                                                <!-- <tr></tr> -->
                                            </table>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: none; overflow: auto; width: 540px" id="divmdgrp">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <table id="mdfygrp1" border="1">
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table id="mdfygrp2" border="1"></table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="overflow: auto;">
                                            <form>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <input type = "text" id="mentor_message" name="mentor_message" placeholder = "Enter Your Question" required>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="myfile" id="">
                                                        </td>
                                                        <td>
                                                            <input type="submit" value="Post" onclick="sendMentorChat(document.getElementById('mentor_message').value)" name="" id="">
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
        
        <script>$(document).ready(function(){});</script>
        <?php 
        if(isset($_SESSION["role"])) {
            ?>
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
                    <script>
                        $("#mentee").hide();
                        $("#mentor").show();
                        $('#bt').append('<tr>'+
                                        '<table>'+
                                        '<tr>'+
                                        '<td>'+
                                        '<form action = "./crtmnteegrp.php" method = "post">'+
                                        '<table>'+
                                        '<tr>'+
                                        '    <td>'+
                                        '        <input type="text" name="gname" placeholder="Enter Group Name" pattern="[a-z]{1,15}" title="Only lower characters are allowed." required>'+
                                        '    </td>'+
                                        '    <td>'+
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
                    <script>
                        $("#mentee").show();
                        $("#mentor").hide();
                    </script>
                    <?php
                    $uid = $_SESSION['uid'];
                    $sel = "SELECT discussion, sender_name FROM discussions WHERE group_id IN (SELECT group_id FROM group_member WHERE mentee_id = $uid)";
                    // echo $sel;
                    $exe = $conn->query($sel);
                    if($exe->num_rows > 0) {
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#showChatMant").append("<tr> <td><b><?php echo $row['sender_name'];?></b></td> <td><?php echo $row['discussion']?></td> </tr>");
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