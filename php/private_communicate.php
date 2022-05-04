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
            var parent_id;

            function back() {
                $("#comm_msg").remove();
                window.location.reload(true);
            }

            function commParent(comm_msg) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {parent_comm_msg: comm_msg,post_parent_id: parent_id}
                }).done(function (response) {alert(response)})
            }

            function pastComms() {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {pastParentComms: parent_id}
                }).done(function (response) {
                    $("#mentor_messages").append(response);
                })
            }
            
            function communicate(id) {
                parent_id = id;
                $("#comm_msg").append(`
                <table width="100%" border="1" align="center">
                        <tr>
                            <td>
                                <table id="mentor_messages" border="1" style="width: 100%; height: 10px; overflow: auto">
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
                                                                <!-- <input type="text" name="comm_message" id="comm_message" required> -->
                                                                <textarea id="comm_message" name="comm_message" rows="4" cols="50" required></textarea>
                                                            </td>
                                                            <td>
                                                                <input type="submit" onclick="commParent(document.getElementById('comm_message').value)" value="Post">
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
    <table border="1" width="100%">
            <tr>
                <td>
                    <div id="header">
                        <table border="1" width="100%" style="text-align: center;">
                            <tr>
                                <td width="22%">
                                    <div id="h1">
                                        <img style="width: 200px;" src="../images/image-removebg-preview.png" alt="#LOGO">
                                    </div>
                                </td>

                                <td>
                                    <div id="h2"></div>
                                </td>

                                <td width="22%">
                                    <div id="h3">
                                        <table id="ht" border="1" width="100%"></table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div style="background-color: #333" id="menu"></div>
                </td>
            </tr>

            <tr>
                <td id="dynamic-portion"></td>
            </tr>
        </table>

        <!-- <div id="getdetail">
            <form action="">
                <table>
                </table>
            </form>
        </div> -->
        
        <?php
        $table = $_SESSION["role"];
        $id = explode('_',$_SESSION["role"],2);
        $uid = $_SESSION["uid"];

        $server_name = "localhost";
        $user_name = "root";
        $password = "";
        $db_name = "mentoring_application";
        $conn = mysqli_connect($server_name, $user_name, $password, $db_name);

        if(isset($_SESSION["role"])) {
            if($_SESSION['role'] == 'mentor_details') {
                ?>
                <script>
                    $("#dynamic-portion").html(`
                        <table width="100%" border="1" style="text-align: center">
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
                    $("#h2").html("<h1>Communication with Parents</h1>");
                </script>
                <?php
                $selmnt = "SELECT parent_id, first_name, middle_name, last_name, mobile_no, gender,
                            occupation, email_id FROM parent_details WHERE parent_id IN 
                            (SELECT parent_id FROM relation WHERE mentor_id = $uid)";
                $exe = $conn->query($selmnt);
                if($exe->num_rows > 0) {
                    ?>
                        <script>
                            $("#list").html(`<table width="100%" id="listtable">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>First Name</th>
                                                    <th>Middle Name</th>
                                                    <th>Last Name</th>
                                                    <th>Mobile No</th>
                                                    <th>Gender</th>
                                                    <th>Occupation</th>
                                                    <th>Email</th>
                                                    <th>Communicate</th>
                                                </tr>
                                            </table>`);
                        </script>
                    <?php
                    while($row = $exe->fetch_assoc()) {
                        ?>
                        <script>
                            $("#listtable").append(`<tr align="center">
                                                    <td><?php echo $row["parent_id"]; ?></td>
                                                    <td><?php echo $row["first_name"]; ?></td>
                                                    <td><?php echo $row["middle_name"]; ?></td>
                                                    <td><?php echo $row["last_name"]; ?></td>
                                                    <td><?php echo $row["mobile_no"]; ?></td>
                                                    <td><?php echo $row["gender"]; ?></td>
                                                    <td><?php echo $row["occupation"]; ?></td>
                                                    <td><?php echo $row["email_id"]; ?></td>
                                                    <td><button onclick="communicate(<?php echo $row["parent_id"]; ?>)">Communicate</button></td>
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
                <?php
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
                        </table>`);
                    $("#h2").html("<h1>Communication with Mentor</h1>");
                </script>
                <?php
            }

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