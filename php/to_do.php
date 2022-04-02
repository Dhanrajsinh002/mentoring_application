<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/to_do.css">
        <script>
            var mnt_id;

            function assignTodo(mentee_id) {
                mnt_id = mentee_id;
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {post_mnt_id: mentee_id}
                }).done(function (response) {$("#messages").append(responses)})
                $("#mentor_part").css("display","block");
                // $("#messages").append(responses);
            }

            function asgnTodoMnt(todo_message) {
                $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {post_td_msg: todo_message,post_ment_id: mnt_id}
                }).done(function (response) {console.log(response)})
            }

            function back() {
                $("#mentor_part").css("display","none");
            }
        </script>
    </head>
    <body>
        <div id="header">
            <div id="h1">
                <img src="../images/image-removebg-preview.png" alt="#LOGO">
            </div>
            <div id="h2">To Do</div>    
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
        <div id="main">
            <div id="list"></div>
        </div>
        <div id="mentor_part">
            <table width="100%" height="100%" border="1">
                <tr>
                    <td>
                        <div>
                            <table id="messages">
                                <!-- <tr>
                                    <td>
                                        for messages
                                    </td>
                                </tr> -->
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            <table>
                                <tr>
                                    <td>
                                        <form action="">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <!-- for input field -->
                                                        <input type="text" name="todo_message" id="todo_message" required>
                                                    </td>
                                                    <td>
                                                        <input type="submit" onclick="asgnTodoMnt(document.getElementById('todo_message').value)" value="Post">
                                                    </td>
                                                    <td>
                                                        <input type="file" name="" id="">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                    <td>
                                        <button onclick="back()">Back</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- <div id="getdetail">
            <form action="">
                <table>
                </table>
            </form>
        </div> -->
        
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
                                                        <th>To-Do</th>
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
                                                        <td><button onclick="assignTodo(<?php echo $row["mentee_id"]; ?>)">Assign To-Do</button></td>
                                                    </tr>`);
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'mentee_details') {
                    
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