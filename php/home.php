<?php
session_start();
// $_SESSION["upd_arr"];
$arr = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/home.css">
        <script>$(document).ready(function(){});</script>
        
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
                                    <div id="h2"><h1>Welcome to Application</h1></div>
                                </td>

                                <td width="30%">
                                    <div id="h3">
                                        <table id="ht" border="1" width="100%">
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
                <td id="body"></td>
            </tr>
        </table>
        
        
        <!-- <div id="getdetail" style = "text-align: center; position: absolute; top: 50%; left: 50%; margin-top: -200px; 
                                    margin-left: -200px; height: 400px; width: 400px; 
                                    border-radius: 15px; background-color: white; display: none;">
            <form id="getdetails" ></form>
        </div> -->
        
        
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
            if(!$conn) 
            {
                die("Connection Failed: ".mysqli_connect_error());
            } 
            else 
            {
                $sel = "SELECT first_name FROM $table WHERE ".$id[0]."_id = $uid";
                $null = "SELECT * FROM $table WHERE middle_name = '' AND ".$id[0]."_id = $uid";
                $exe = $conn->query($sel);
                while($row = $exe->fetch_assoc())
                {
                    ?>
                    <script>
                        $('#ht').html(`<tr> <td><p><?php echo ucwords($id[0])."&nbsp;".$row["first_name"] ?></p></td> <td align="right"><button onclick='window.location.href="./logout.php"'>Logout</button></td> </tr>`);
                        // document.getElementById("getdetail").style.display = 'block';
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'mentor_details') 
                {
                    ?>
                    <script>
                        $("#menu").html(`
                            <table width="100%">
                                <tr style="border-collaps: collaps; list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communicate With Mentees</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communicate_with_mentor.php">Communicate With Parents</a></td>
                                    <td style="border-collaps: collaps;" width="16.6%"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='aquamarine'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></td>
                                </tr>
                            </table>
                        `);
                        /* $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='aquamarine'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='red'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication With Mentees</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communicate_with_mentor.php">Communicate With Parents</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`); */
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'mentee_details') 
                {
                    ?>
                    <script>
                        $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='aquamarine'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a onmouseout="this.style.color='white'" onmouseover="this.style.color='red'" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./discussion.php">Discussion</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`);
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'parent_details') 
                {
                    ?>
                    <script>
                        $("#menu").html(`
                        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;">
                        <li onmouseover="this.style.background-color='aquamarine'" style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./home.php">Home</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./to_do.php">To-Do</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communication.php">Communication</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./communicate_with_mentor.php">Communicate With Mentor</a></li>
                        <li style="float: left;"><a style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;" href="./profile.php">Profile</a></li>
                        </ul>`);
                    </script>
                    <?php
                }

                if($exenull = mysqli_query($conn,$null)) 
                {
                    $row = mysqli_num_rows($exenull);
                    // echo $row;
                    if($row != 0) 
                    {
                        $col = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'mentoring_application' AND TABLE_NAME = '$table'");
                        $type = $conn->query("DESCRIBE $table");
                        
                        while($rows = /* $type */ $col->fetch_assoc()) 
                        {
                            $res[] = $rows;
                        }

                        $columnArr = array_column($res, 'COLUMN_NAME');
                        // print_r($columnArr);
                        // print_r(count($columnArr));
                        ?>
                        <script>
                            // $("#getdetail").css("display","block");
                            // var form = document.getElementById("body");
                            var form = document.createElement("form");
                            // document.getElementById("getdetail").style.display = "block";
                            // $("#getdetail").append(`<table><form action="./functions.php" method="post" id="dtform"></form></table>`);
                        </script>
                        <?php
                        
                        while($nullrow = $exenull->fetch_assoc()) 
                        {
                            for($i = 1; $i < count($columnArr)-2; $i++) 
                            {
                                $data = $columnArr[$i];
                                array_push($arr,"document.getElementById('$data').value");
                                if(!($nullrow[$data])) 
                                {
                                    ?>
                                    <script>
                                        var el = document.createElement("input");
                                        el.type = "text";
                                        el.placeholder = "<?php echo $data; ?>";
                                        el.id = "<?php echo $data; ?>";
                                        el.style = "text-align: center; width: 80%; height: 30%; margin: 5px";
                                        el.value = "<?php echo $nullrow[$data] ?>";
                                        el.setAttribute("required","");
                                        // el.required = true;
                                        
                                        // var form = document.getElementById("body");
                                        form.appendChild(el);
                                        // $("#body").append(form);
                                    </script>
                                    <?php
                                }
                                
                                else
                                
                                {
                                    ?>
                                    <script>
                                        var el = document.createElement("input");
                                        el.type = "text";
                                        el.placeholder = "<?php echo $data; ?>";
                                        el.id = "<?php echo $data; ?>";
                                        el.style = "text-align: center; width: 80%; margin: 5px";
                                        el.value = "<?php echo $nullrow[$data] ?>";
                                        el.setAttribute("disabled","disabled");
                                        // el.setAttribute("required","required");

                                        // var form = document.getElementById("body");
                                        form.appendChild(el);
                                        // document.body.appendChild(form)
                                        // $("#body").append(form);
                                    </script>
                                    <?php
                                }
                            }
                            $_SESSION["upd_arr"] = $arr;
                        }
                        ?>
                            <script>
                                function updateValue() {
                                    var arr = [];
                                    <?php
                                    for($i = 0; $i < count($_SESSION["upd_arr"]); $i++) {
                                        ?>
                                        if(<?php echo $_SESSION["upd_arr"][$i] ?> == "") {
                                            return false;
                                        } else {
                                            arr.push(<?php echo $_SESSION["upd_arr"][$i] ?>)
                                        }
                                        <?php
                                    }
                                    ?>
                                    // console.log(arr);
                                    $.ajax({
                                        method: "post",
                                        url: "./functions.php",
                                        data: {upd_arr: arr}
                                    }).done(function (response) {
                                        location.reload();
                                        console.log(response)
                                    })
                                    // console.log("NJKBUIBWV");
                                    // alert("NJKBUIBWV");
                                }
                            </script>
                            <script>
                                var el = document.createElement("input");
                                el.type = "submit";
                                el.style = "text-align: center; width: 80%; margin: 5px";
                                el.value = "Update Info";
                                // el.onclick = "updateValue()";
                                el.setAttribute("onclick","updateValue()");
                                // var form = document.getElementById("body");
                                form.appendChild(el);
                                $("#body").append(form);
                            </script>
                        <?php
                        
                    }
                }
                else 
                {
                    ?>
                        <script>
                            // $("#getdetail").css("display","block");
                            document.getElementById("getdetail").style.display = "none";
                        </script>
                    <?php
                }
            }
        }
        else 
        {
            ?>
            <script>
                $('#ht').html(`<tr> <td><button onclick='window.location.href = "../signin.html"'>Sign IN</button></td> <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td><button onclick='window.location.href = "../signup.html"'>Sign UP</button></td> </tr>`);
            </script>
            <?php
        }
        ?>

    </body>
</html>