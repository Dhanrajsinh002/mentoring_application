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
    // echo $row;
    if($row != 0) 
    {
        $col = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'mentoring_application' AND TABLE_NAME = '$table'");
        $type = $conn->query("DESCRIBE $table");
        
        while($rows = /* $type */ $col->fetch_assoc()) 
        {
            $res[] = $rows;

        $columnArr = array_column($res, 'COLUMN_NAME');
        // print_r($columnArr);
        // print_r(count($columnArr));
        ?>
        <script>
            // $("#getdetail").css("display","block");
            // var form = document.getElementById("body");
            var form = document.createElement("form");
            form.style = "text-align: center; width: 100%;"
            var h3 = document.createElement("h3");
            h3.textContent = "Complete Your Profile";
            form.appendChild(h3);
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
                        el.style = "text-align: center; width: 50%; height: 30%; margin: 5px";
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
                        el.style = "text-align: center; width: 50%; margin: 5px";
                        el.value = "<?php echo $nullrow[$data] ?>";
                        el.setAttribute("disabled","disabled");
                        // el.setAttribute("required","required
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
                        window.location.reload(true);
                        console.log(response)
                    })
                    // console.log("NJKBUIBWV");
                    // alert("NJKBUIBWV");
                }
            </script>
            <script>
                var el = document.createElement("input");
                el.type = "submit";
                el.style = "text-align: center; width: 50%; margin: 5px";
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
?>