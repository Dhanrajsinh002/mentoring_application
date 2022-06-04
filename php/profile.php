<?php
session_start();
$arr = array();
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
                if(flag == 0) {
                    $.ajax({
                    method: "post",
                    url: "./functions.php",
                    data: {showmntpr: id}
                    }).done(function (response) {
                        // console.log(response);
                        $("#showmntpr").html(response);
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
                                    <div id="h2"><h1>Profile</h1></div>
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
                <td id="dynamic-portion">
                    <table width="100%"  style="text-align: center">
                        <tr>
                            <td>
                                <div id="main"></div>
                            </td>
                        </tr>
                    </table>
                </td>
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

                $selPrf = "SELECT * FROM $table WHERE ".$id[0]."_id = $uid";

                    if($exe = mysqli_query($conn,$selPrf)) {
                        $row = mysqli_num_rows($exe);

                        if($row != 0) {
                            $col = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'mentoring_application' AND TABLE_NAME = '$table'");
                            $type = $conn->query("DESCRIBE $table");

                            while($rows = $col->fetch_assoc()) 
                            {
                                $res[] = $rows;
                            }

                            $columnArr = array_column($res, 'COLUMN_NAME');
                            ?>
                            <script>
                                var form = document.createElement("form");
                                form.style = "text-align: center; width: 100%;";
                                var tb = document.createElement("table");
                                // tb.setAttribute("id","mtb");
                                tb.style = "width: 100%; text-align: center; border: 2px solid black; border-radius: 15px; font-size: 20px;";
                                form.appendChild(tb);
                                $("#main").append(form);
                                // var h3 = document.createElement("h3");
                                // h3.textContent = "My Profile";
                                // form.appendChild(h3);
                            </script>
                            <?php

                            while($row = $exe->fetch_assoc()) 
                            {
                                for($i = 1; $i < count($columnArr)-2; $i++) 
                                {
                                    $data = $columnArr[$i];
                                    array_push($arr,"document.getElementById('$data').value");
                                    // echo $data;
                                    if($data == "password") 
                                    {
                                        ?>
                                        <script>
                                            var tr1 = document.createElement("tr");
                                            tb.appendChild(tr1);

                                            var td1 = document.createElement("th");
                                            td1.style = "width: 20%";
                                            tr1.appendChild(td1);

                                            var lb = document.createElement("label");
                                            // lb.setAttribute("hidden","");
                                            td1.appendChild(lb);
                                            // form.appendChild(lb);

                                            var td2 = document.createElement("td");
                                            tr1.appendChild(td2);

                                            var el = document.createElement("input");
                                            el.type = "text";
                                            el.placeholder = "<?php echo $data; ?>";
                                            el.id = "<?php echo $data; ?>";
                                            el.style = "text-align: center; width: 50%; margin: 5px";
                                            el.value = "<?php echo $row[$data]; ?>";
                                            el.setAttribute("hidden","");
                                            td2.appendChild(el);
                                            // form.appendChild(el);
                                        </script>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            var tr1 = document.createElement("tr");
                                            tb.appendChild(tr1);

                                            var td1 = document.createElement("th");
                                            td1.style = "width: 20%";
                                            tr1.appendChild(td1);

                                            var lb = document.createElement("label");
                                            lb.innerHTML = "<?php echo $data; ?>";
                                            td1.appendChild(lb);
                                            // form.appendChild(lb);

                                            var td2 = document.createElement("td");
                                            tr1.appendChild(td2);

                                            var el = document.createElement("input");
                                            el.type = "text";
                                            el.placeholder = "<?php echo $data; ?>";
                                            el.id = "<?php echo $data; ?>";
                                            el.style = "text-align: center; width: 50%; margin: 5px";
                                            el.value = "<?php echo $row[$data]; ?>";
                                            el.setAttribute("required","");
                                            td2.appendChild(el);
                                            // form.appendChild(el);
                                        </script>
                                        <?php
                                    }
                                }
                                $_SESSION["upd_prf"] = $arr;
                            }
                            ?>
                            <script>
                                function updateValue() {
                                    var arr = [];
                                    <?php
                                    for($i = 0; $i < count($_SESSION["upd_prf"]); $i++) {
                                        ?>
                                        if(<?php echo $_SESSION["upd_prf"][$i] ?> == "") {
                                            return false;
                                        } else {
                                            arr.push(<?php echo $_SESSION["upd_prf"][$i] ?>)
                                        }
                                        <?php
                                    }
                                    ?>
                                    $.ajax({
                                        method: "post",
                                        url: "./functions.php",
                                        data: {upd_prf: arr}
                                    }).done(function (response) {
                                        alert(response);
                                        window.location.reload(true);
                                        
                                    })
                                }
                            </script>
                            <script>
                                var tr1 = document.createElement("tr");
                                tb.appendChild(tr1);

                                var td3 = document.createElement("td");
                                td3.setAttribute("colspan","2");
                                tr1.appendChild(td3);

                                var el = document.createElement("input");
                                el.type = "submit";
                                el.style = "text-align: center; width: 50%; margin: 5px";
                                el.value = "Update Profile";
                                el.setAttribute("onclick","updateValue()");
                                td3.appendChild(el);
                                // form.appendChild(el);
                                // $("#body").append(form);
                            </script>
                        <?php

                        }

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
                        $("#dynamic-portion").append(`
                        <table id="mtb" width="100%"  style="text-align: center; border: 2px solid black; border-radius: 15px">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                        `);
                        $("#mtb").append(`
                            <tr>
                                <td colspan="2" id="otherProfiles"></td>
                            </tr>
                        `);
                    </script>
                    <?php
                    }
                    $selmntprf = "SELECT mentee_id, first_name FROM mentee_details WHERE mentee_id IN 
                                    (SELECT mentee_id FROM relation WHERE mentor_id = $uid)";
                    if($exe = $conn->query($selmntprf)) {
                        ?>
                        <script>
                            $("#otherProfiles").append(`
                                <table id="appendRow" width="100%" align="center">
                                    <tr>
                                        <th colspan="2">Your Mentee's Profile</th>
                                    </tr>
                                    <tr id="appendCol"></tr>
                                </table>
                            `);
                        </script>
                        <?php
                        $num_rec = 0;
                        while($row = $exe->fetch_assoc()) {
                            $num_rec += 1;
                            ?>
                            <script>
                                $("#appendCol").append(`
                                    <th><button onclick="showMenteePrf(<?php echo $row["mentee_id"]?>)"><?php echo $row["first_name"]?></button></th>
                                `);
                            </script>
                            <?php
                        }
                        ?>
                        <script>
                            $("#appendRow").append(`
                                
                                <tr>
                                    <td colspan="<?php echo $num_rec?>" id="showmntpr"></td>
                                </tr>
                            `);
                        </script>
                        <?php
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
                $exe = $conn->query($sel);
                while($row = $exe->fetch_assoc()) {
                    ?>
                    <script>
                        $('#ht').html(`<tr> <td><p><?php echo ucwords($id[0])."&nbsp;".$row["first_name"] ?></p></td> <td align="right"><button onclick='window.location.href="./logout.php"'>Logout</button></td> </tr>`);
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