<?php
//connect to db
$connect = mysqli_connect("localhost","root", "", "task");
    if ($connect === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['btn-update'])) {

        //update values
        $errors = "";
        $task = mysqli_real_escape_string($connect, $_POST['task']);
        $comment = mysqli_real_escape_string($connect, $_POST['text']);
        $date = mysqli_real_escape_string($connect, $_POST['date']);
        $priority = mysqli_real_escape_string($connect, $_POST['priority']);

        if (trim($task) == "" || trim($comment) == "" || trim($date) == "") {
            echo '<div class="alert alert-danger">' . $errors .= " Please fill all fields" . '</div>';
        }else {
            $sql_query = "UPDATE description SET task = '$task', text = '$comment', date = STR_TO_DATE('$date', '%Y-%m-%d') ,
                          priority ='$priority', datetime = NOW() WHERE id = $id";
            $result = mysqli_query($connect,$sql_query);

            if ($result) {
                ?>
                <script type="text/javascript">
                    alert('Data Are Updated Successfully');
                    window.location.href = 'table.php';
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert('error occured while updating data');
                </script>
                <?php
            }
        }
    }
}
if (isset($_POST['btn-cancel'])) {
    header("Location: table.php");
}

?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Edit</title>

    <LINK REL=StyleSheet HREF="" TYPE="text/html" MEDIA=screen>

    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.css">

    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>

</head>
<body>

<div id="content">
    <form  method="post" action="" >
        <div class="panel panel-primary" style='width: 535px; height:270px; margin-left: 400px; margin-top: 40px;'>
             <div class='panel-heading'>Update data<div style='float: left; margin-left: 50px ;'></div></div>

             <div><input type="text" class="form-control" name="task" value="<?php echo $_GET['task'] ?>"   style="float: left; width: 250px; margin-left: 135px;margin-top: 10px;" /></div><br><br>
             <div><textarea class="form-control" name="text"  style="float: left; max-width: 250px; min-height:10px; max-height: 55px; margin-left: 135px; margin-top: 10px;" ><?php echo $_GET['text'] ?></textarea></div>

             <div class="form-group" style="margin-left: 50px;">
                 <div>
                     <select class="form-control"  style="width: 140px; margin-left: 195px;margin-top: 75px; " name="priority">
                         <option><?php echo $_GET['priority'] ?></option>
                         <option>urgent</option>
                         <option>medium</option>
                         <option>low</option>
                     </select>
                 </div>
             </div>
             <script>
                 $(function() {
                     $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' }).val();
                 });
             </script>
             <div class="form-group" style="float:left; margin-top: -49px; margin-left: 135px; ">
                 <input class="form-control" style="width: 100px;" type="text" name="date" id="datepicker" placeholder="Date" value="<?php echo $_GET['date'] ?>"/>
             </div>

             <div style="margin-left: 185px; margin-top: 20px;">
                 <input  class="btn btn-primary" type="submit" id="submit_contact" name="btn-update" value="Update" />
                 <input  class="btn btn-primary" type="submit" id="submit_contact" name="btn-cancel" value="Cancel" />
             </div>
        </div>
    </form>
</div>

</body>
</html>
