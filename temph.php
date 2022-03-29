<!DOCTYPE html>
<html>
    <head>
        <title>TEMP</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./js/temp.js"></script>
    </head>
    <body>
        <table>
            <tr>
                <td>
                    <form action="./temp.php" method="POST">
                        <table border="1">
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uname" id="" placeholder="Username" pattern="[A-Za-z]{1,15}" title="Only lower characters are allowed." required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="email" id="" placeholder="Email ID" title="" oninput="checkmail(this)" required>
                                    <script>
                                        function checkmail(mail) {
                                            if(!((mail.value).match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))) {
                                                mail.setCustomValidity("Email ID format must be match!!");
                                            } else {
                                                mail.setCustomValidity("");
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="phone" id="" placeholder="Mobile No" pattern="[0-9]{10}" title="only 10 numerical value allowed." required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Date of Birth: </label>
                                </td>
                                <td>
                                    <input type="date" name="dob" id="" title="select your borth date." required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Gender: </label>
                                </td>
                                <td>
                                    <input type="radio" name="gender" id="" value="male" required>
                                    <label for="">Male</label>
                                    <input type="radio" name="gender" id="" value="female">
                                    <label for="">Female</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">As a: </label>
                                </td>
                                <td>
                                    <input type="radio" name="role" id="" value="mentor" required>
                                    <label for="">Mentor</label>
                                    <input type="radio" name="role" id="" value="mentee">
                                    <label for="">Mentee</label>
                                    <input type="radio" name="role" id="" value="parents">
                                    <label for="">Parents</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="password" name="pass" id="pass" placeholder="Password" 
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}"
                                    title="Password must contain: at least one number, at least one uppercase and lowercase letter, at least 8 or more character" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="password" name="cpass" id="cpass" placeholder="Confirm Password" required oninput="check(this)">
                                    <script>
                                        function check(inp) {
                                            if(inp.value != document.getElementById("pass").value) {
                                                inp.setCustomValidity("Password must be match!!");
                                            } else {
                                                inp.setCustomValidity("");
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="reset" value="Clear" id="">
                                </td>
                                <td>
                                    <input type="submit" value="SignUp" id="">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>

        <table id="paging">
            <!-- <tr>
                <td><a href="./temph.php?page=1">1</a></td>
                <td><a href="./temph.php?page=2">2</a></td>
                <td><a href="./temph.php?page=3">3</a></td>
                <td><a href="./temph.php?page=4">4</a></td>
            </tr> -->
        </table>

        <?php
        
            $server_name = "localhost";
            $user_name = "root";
            $password = "";
            $db_name = "mentoring_application";
        
            $conn = mysqli_connect($server_name, $user_name, $password, $db_name);
            if(!$conn) {
                die("Connection Failed: ".mysqli_connect_error());
            } else {
                $start = 0;
                $stop = 3;
                $cnt = "SELECT * FROM mentee_details WHERE status = 1";
                if($res = mysqli_query($conn,$cnt)) {
                    $row = mysqli_num_rows($res);
                    $round = ceil($row/$stop);
                    echo "<tr>";
                    for($i = 1; $i <= $round; $i++) {
                        ?>
                        <script>
                            $("#paging").append(`<td><a href='./temph.php?page=<?php echo $i ?>'><?php echo $i ?></a></td>`);
                        </script>
                        <?php
                    }
                    echo "</tr>";
                }
                
                if(isset($_GET["page"])) {
                    $start = (($_GET["page"])-1) * $stop;
                }

                if(isset($_GET["delete"])) {
                    $id = $_GET["delete"];
                    $upd = "UPDATE mentee_details SET status = 0 WHERE mentee_id = $id";
                    $conn->query($upd);
                }

                $sel = "SELECT mentee_id, first_name,email_id,mobile_no,dob,gender FROM mentee_details WHERE status = 1 LIMIT $start,$stop";
                $exe = $conn->query($sel);
                if($exe->num_rows > 0) {
                    
                    // $sela = "SELECT * FROM mentee_details";
                    // // $exea = $conn->query($sela);
                    // if($res = mysqli_query($conn,$sela)) {
                    //     $row = mysqli_num_rows($res);
                    
                    //     $start = 0;
                    //     $stop = 3;
                    //     if()
                    //     // echo "<br>".$row;
                    //     // while($row = $exea->fetch_assoc()) {
                    //     //     $total = $row[0];
                    //     //     echo "<br>".$total;
                    //     // }
                    // }
                    echo "<table border='1'><tr><th>ID</th> <th>UserName</th> <th>Email ID</th> <th>Phone</th> <th>Date of Birth</th> <th>Gender</th> <th>Operations</th></tr>";
                    while($row = $exe->fetch_assoc()) {
                        echo "<tr id=".$row["mentee_id"].">
                                <td>".$row["mentee_id"]."</td>
                                <td>".$row["first_name"]."</td>
                                <td>".$row["email_id"]."</td>
                                <td>".$row["mobile_no"]."</td>
                                <td>".$row["dob"]."</td>
                                <td>".$row["gender"]."</td>
                                <td><button onclick=location.href='./update.php?update=".$row["mentee_id"]."'>Update</button>
                                    <button onclick=location.href='./temph.php?delete=".$row["mentee_id"]."'>Delete</button></td>
                                </tr>";
                                //update(".$row["mentee_id"].")
                        // echo "<script type='text/javascript'>alert('User Already Exist with entered credentials!!');</script>";
                        //echo "User ID: ". $row["uname"] ."<br>User Name: ". $row["uphone"] ."<br>User Email: ". $row["umail"];
                    }
                    echo "</table>";

                    //header("Location:../signup.html");
                }
                else {
                    echo "could not fetch";
                    // $ins = "INSERT INTO mentee_details (first_name,email_id,mobile_no,dob,gender,password,status) VALUES ('$name','$mail',$phone,$dob,'$gender','$pass',1)";
                    // if($conn->query($ins) === True) {
                    //     echo "Record Successfully added!";
                    //     header("Location:../temp.html");
                    // } else {
                    //     echo "Error: ".$ins."<br>".$conn->error;
                    // }
                }
            }
        ?>
    </body>
</html>