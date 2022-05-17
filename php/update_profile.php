<?php
session_start();
?>
<html>
    <head>
        <title>Update Profile</title>
    </head>
</html>
<?php
$table = $_SESSION["role"];
$id = explode('_',$_SESSION["role"],2);
$uid = $_SESSION["uid"];
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "mentoring_application";
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);

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
?>