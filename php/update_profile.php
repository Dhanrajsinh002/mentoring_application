<?php
session_start();

$table = $_SESSION["role"];
$id = explode('_',$_SESSION["role"],2);
$uid = $_SESSION["uid"];
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);

$arr = array();

if(count($_SESSION["col"]) > 0) {
    for($i = 0; $i < count($_SESSION["col"]); $i++) {
        $set = $_SESSION["col"][$i];
        $val = $_POST["$set"];
        echo "VAL ".$val."<br>";
        $col = $_SESSION["col"][$i];
        echo "COL ".$col."<br>";
        $upd = "UPDATE $table SET $col = $val WHERE ".$id[0]."_id = $uid";
        echo "UPDATE ".$upd;
        // unset($_SESSION["col"]);
        // // $conn->query($upd);
    }
}
?>

<html>
    <head>
        <title>Update Pending Profile</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>$(document).ready(function(){});</script>
    </head>
    <body>
        <div id="getdetail" style = "text-align: center; position: absolute; top: 50%; left: 50%; margin-top: -200px; 
                                    margin-left: -200px; height: 400px; width: 400px; 
                                    border-radius: 15px; background-color: white; display: none;">
            <form action="./update_profile.php" method="post" id="getdetails" ></form>
            <!-- <form id="getdetails" ></form> -->
        </div>
    </body>
</html>

<?php
$null = "SELECT * FROM $table WHERE middle_name = '' AND ".$id[0]."_id = $uid";
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
    document.getElementById("getdetail").style.display = "block";
    // $("#getdetail").append(`<table><form action="./functions.php" method="post" id="dtform"></form></table>`);
</script>
<?php

if($exenull = mysqli_query($conn,$null)) {

while($nullrow = $exenull->fetch_assoc()) 
{
    for($i = 1; $i < count($columnArr)-2; $i++) 
    {
        $data = $columnArr[$i];
        array_push($arr,$data);
        $_SESSION['col'] = $arr;
        if(!($nullrow[$data])) 
        {
            ?>
            <script>
                var el = document.createElement("input");
                el.type = "text";
                el.placeholder = "<?php echo $data; ?>";
                el.id = "<?php echo $data; ?>";
                el.style = "width: 80%; height: 8%; margin: 5px";
                el.value = "<?php echo $nullrow[$data] ?>";
                el.setAttribute("required","required");
                                        
                var form = document.getElementById("getdetails");
                form.appendChild(el);
                $("#getdetails").append();
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
            el.style = "width: 80%; margin: 5px";
            el.value = "<?php echo $nullrow[$data] ?>";
            el.setAttribute("disabled","disabled");

            var form = document.getElementById("getdetails");
            form.appendChild(el);
            $("#getdetails").append();
        </script>
        <?php
        }
    }    
}
?>
<script>
    var el = document.createElement("input");
    el.type = "submit";
    el.value = "Update Info";
    // el.setAttribute("onclick","updateValue()");
    var form = document.getElementById("getdetails");
    form.appendChild(el);
    $("#getdetails").append();
    </script>
<?php
}
?>