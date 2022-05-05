<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/profile.css">
        <script>$(document).ready(function(){});</script>
        <script>
            var flag = 0;

            function showMenteePrf(id) {
                // alert(id);
                if(flag == 0) {
                    $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {showmntpr: id}
                    }).done(function (response) {
                        flag = 1;
                        $("#showmntpr").append(response);
                    })
                }
                else {
                    flag = 0;
                    window.location.href = "./profile.php";
                }
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
                                    <div id="h2"><h1>Profile</h1></div>
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

                if($_SESSION['role'] == 'mentor_details') {
                    ?>
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
                        $("#dynamic-portion").html(`
                            <table width="100%" border="1" style="text-align: center">
                                <tr>
                                    <td>
                                        <div id="main"></div>
                                    </td>
                                </tr>
                            </table>`
                        );
                    </script>
                    <?php
                    
                    $selprf = "SELECT mentor_id, first_name, middle_name, last_name, mobile_no, dob, gender, department, stream,
                                qualification, email_id FROM mentor_details WHERE mentor_id = $uid";
                    if($exe = $conn->query($selprf)) {
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>
                                $("#main").append(`
                                    <table border="1" width="100%" align="center">
                                        <tr>
                                            <th colspan="2">My Profile</th>
                                        </tr>

                                        <tr>
                                            <th>First Name</th>
                                            <td><?php echo $row["first_name"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Middle Name</th>
                                            <td><?php echo $row["middle_name"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Last Name</th>
                                            <td><?php echo $row["last_name"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Mobile Number</th>
                                            <td><?php echo $row["mobile_no"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td><?php echo $row["dob"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Gender</th>
                                            <td><?php echo $row["gender"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Department</th>
                                            <td><?php echo $row["department"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Stream</th>
                                            <td><?php echo $row["stream"]?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Qualification</th>
                                            <td><?php echo $row["qualification"]?></td>
                                        </tr>
    
                                        <tr>
                                            <th>Email ID</th>
                                            <td><?php echo $row["email_id"]?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="2">
                                                <button onclick="./update_profile.php?mentor_id=<?php echo $row["mentor_id"]?>">Update Profile</button>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="2" id="otherProfiles"></td>
                                        </tr>
                                    </table>
                                `);
                            </script>
                            <?php
                            $selmntprf = "SELECT mentee_id, first_name FROM mentee_details WHERE mentee_id IN 
                                            (SELECT mentee_id FROM relation WHERE mentor_id = $uid)";
                            if($exe = $conn->query($selmntprf)) {
                                while($row = $exe->fetch_assoc()) {
                                    ?>
                                    <script>
                                        $("#otherProfiles").append(`
                                            <table border="1" width="100%" align="center">
                                                <tr>
                                                    <th colspan="2">Your Mentee's Profile</th>
                                                </tr>
                                                
                                                <tr>
                                                    <td><button onclick="showMenteePrf(<?php echo $row["mentee_id"]?>)"><?php echo $row["first_name"]?></button></td>
                                                </tr>

                                                <tr>
                                                    <td id="showmntpr"></td>
                                                </tr>
                                            </table>
                                        `);
                                    </script>
                                    <?php
                                }
                            }
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
                                </table>
                            `);
                    </script>
                    <?php
                }

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