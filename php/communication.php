<?php
session_start();
?>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/home.css">
    </head>
    <body>
        <div id="header">
            <div id="h1">
                <img src="../images/image-removebg-preview.png" alt="#LOGO">
            </div>
            <div id="h2">Communication</div>    
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

                /* if($exenull = mysqli_query($conn,$null)) {
                    $row = mysqli_num_rows($exenull);
                    // echo $row;
                    if($row != 0) {
                        $col = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'mentoring_application' AND TABLE_NAME = '$table'");
                        $type = $conn->query("DESCRIBE $table");
                        while($row = $type->fetch_assoc()) {
                            $res[] = $row;
                        }
                        $columnArr = array_column($res, 'COLUMN_NAME');
                        // print_r($columnArr);
                        // print_r(count($columnArr));
                        ?>
                            <script>
                                var form = document.createElement("form");
                                form.setAttribute("method","post");
                                form.setAttribute("action","#");
                            </script>
                        <?php

                        for($i = 1; $i < count($columnArr)-2; $i++) {
                            ?>
                            <script>
                                var <?php $columnArr[$i]?> = document.createElement("input");
                                <?php $columnArr[$i]?>.setAttribute("type","text");
                                form.appendChild(<?php $columnArr[$i]?>);
                            </script>
                            <?php
                        }
                        ?>
                        <script>
                            document.getElementsByTagName("body")[0].appendChild(form);
                        </script>
                        <?php
                    }
                    // if($exenull->num_rows > 0) {
                    //     while($nrow = $exenull->fetch_assoc()) {
                    //         echo $nrow;
                    //     }
                    // }
                } */

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