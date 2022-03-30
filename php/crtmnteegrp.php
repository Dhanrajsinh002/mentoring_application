<?php
session_start();
?>
<html>
    <head>
        <title>Create Mentee Group</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div>
            <table border="1" id="mnlst">
                <!-- <tr>
                    <td>
                        <form action="" method="post">
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" name="gname" placeholder="Enter Group Name" pattern="[a-z]{1,15}" title="Only lower characters are allowed." required>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr> -->
                <tr> <td>ID</td> <td>GR</td> <td>Enrollment</td> <td>Name</td> <td>Stream</td> <td>Department</td> <td>ADD</td> </tr>
            </table>
        </div>
        <div>
            <table>
            <tr id="showstud"></tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <form action="./crtmnteegrp.php" method="post">
                            <input type="submit" value="Confirm to Add" name="cta" id="">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>

<?php
if(isset($_POST['gname'])) {
    ?>
    <script>
        localStorage.setItem("gname","<?php echo $_POST["gname"]; ?>");
    </script>
    <?php
}

if(isset($_POST["cta"])) {
    $stcnt = "<script>localStorage.length</script>";
    echo $stcnt;
    // $gname = $_POST["gname"];
    // $crt = "CREATE TABLE $gname (mentor_id,mentee_id)";
    // $ins = "INSERT INTO $gname VALUES"
}

$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);
if(!$conn) {
   die("Connection Failed: ".mysqli_connect_error());
} else {
    $sel = "SELECT mentee_id, gr_no, enrollment_no, first_name, stream, department from mentee_details where status = 1";
    $exe = $conn->query($sel);
    if($exe->num_rows > 0) {
        // echo "<table border=1 id='mnlst'> <tr> <td>ID</td> <td>GR</td> <td>Enrollment</td> <td>Name</td> <td>Stream</td> <td>Department</td> <td>ADD</td> </tr>";
        while($row = $exe->fetch_assoc()) {
        ?>
        <script>
            $("#mnlst").append(`<tr> <td> <?php echo $row["mentee_id"] ?> </td> <td> <?php echo $row["gr_no"]?> </td> <td> <?php echo $row["enrollment_no"]?> </td> <td> <?php echo $row["first_name"]?> </td> <td> <?php echo $row["stream"]?> </td> <td> <?php echo $row["department"]?> </td> <td><button onclick="addStud(<?php echo $row["mentee_id"] ?>)">ADD</button></td> </tr>`);
        </script>
        <script>
            function addStud(id) {
                localStorage.setItem("id"+id,id);
                $("#showstud").append("<td>"+localStorage.getItem("id"+id,id)+"</td>");
            }
        </script>
        <?php
        }
        // echo "</table>";
    }
    else {
        echo "00000";
    }
    
}
?>