<?php
session_start();
$arr = array();
$connarr = array();
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
                                    <div id="h2"><h1>Welcome to Application</h1></div>
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
                <td id="body"></td>
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
                    </script>
                    <?php
                }

                if($_SESSION['role'] == 'mentor_details') 
                {
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
                    <?php
                }

                if($_SESSION['role'] == 'mentee_details') 
                {
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
                            </table>
                        `);
                    </script>
                    <script>

                    </script>
                    <?php
                    $sel = "SELECT mentee_id FROM relation WHERE mentee_id = $uid AND parent_id = 0";
                    if($exe = $conn->query($sel)) {
                        while($row = $exe->fetch_assoc()) {
                            ?>
                            <script>

                                function connectParent() {
                                    var pnm = document.getElementById("pname").value;
                                    var pno = document.getElementById("pphone").value;

                                    $.ajax({
                                        method: "post",
                                        url: "./functions.php",
                                        data: {pname: pnm, pphone: pno}
                                    }).done(function (response) {console.log(response)})
                                }

                                $("#body").append(`<form>
                                                        <table width="100%" style="text-align:center">
                                                            <tr>
                                                                <td>
                                                                    <h3>Enter Details to Connect Your Parents</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input style="text-align:center; width: 50%;" type="text" name="pname" id="pname" placeholder="Parent Name" pattern="[a-z]{1,15}" title="Only lower characters are allowed." required>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input style="text-align:center; width: 50%;" type="text" name="phone" id="pphone" placeholder="Mobile No" pattern="[0-9]{10}" title="only 10 numerical value allowed." required>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="submit" value="Connect Parent" onclick="connectParent()" id="">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>`);
                            </script>
                            <?php
                        }
                    }
                }

                if($_SESSION['role'] == 'parent_details') 
                {
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

                if($exenull = mysqli_query($conn,$null)) 
                {
                    $row = mysqli_num_rows($exenull);
                    if($row != 0) 
                    {
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
                            form.style = "text-align: center; width: 100%;"
                            var h3 = document.createElement("h3");
                            h3.textContent = "Complete Your Profile";
                            form.appendChild(h3);
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
                                        el.style = "text-align: center; width: 50%; height: 30%; margin: 5px";
                                        el.value = "<?php echo $nullrow[$data] ?>";
                                        el.setAttribute("required","");                                        
                                        form.appendChild(el);
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
                                        el.style = "text-align: center; width: 50%; margin: 5px";
                                        el.value = "<?php echo $nullrow[$data] ?>";
                                        el.setAttribute("disabled","disabled");
                                        form.appendChild(el);
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
                                    $.ajax({
                                        method: "post",
                                        url: "./functions.php",
                                        data: {upd_arr: arr}
                                    }).done(function (response) {
                                        window.location.reload(true);
                                        console.log(response)
                                    })
                                }
                            </script>
                            <script>
                                var el = document.createElement("input");
                                el.type = "submit";
                                el.style = "text-align: center; width: 50%; margin: 5px";
                                el.value = "Update Info";
                                el.setAttribute("onclick","updateValue()");
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