<?php
$connect = mysqli_connect("localhost","root", "", "task");
if ($connect === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['btn-update'])) {

        // variables for input data
        $task = mysqli_real_escape_string($connect, $_POST['task']);
        $comment = mysqli_real_escape_string($connect, $_POST['text']);
        $date = mysqli_real_escape_string($connect, $_POST['date']);
        $priority = mysqli_real_escape_string($connect, $_POST['priority']);
         //$sql = "INSERT INTO description ( date) VALUES ('$date'))";

        $sql = "SELECT * FROM description";
        if ($result = mysqli_query($connect, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_array($result)) {
                    $myDateTime = DateTime::createFromFormat('Y-m-d', $row['date']);
                    $date = $myDateTime->format('d.m.Y');
                }
            }
        }


        $sql_query = "UPDATE description SET task = '$task', text = '$comment' , priority ='$priority', datetime = NOW() WHERE id = $id";
        $result = mysqli_query($connect,$sql_query);

        if ($result) {
            ?>
            <script type="text/javascript">
                alert('Data Are Updated Successfully');
                window.location.href = 'index.php';
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
if (isset($_POST['btn-cancel'])) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ToDo</title>

    <LINK REL=StyleSheet HREF="" TYPE="text/html" MEDIA=screen>

    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.css">

    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>

</head>
<body>
<div id="content">
    <form  method="post" action="" style="width: 500px; float: left;" >


        <div class="panel panel-default" style='width: 535px; margin-left: 400px; margin-top: 50px;'>
             <label style='margin-left: 225px;'>Update Data</label>
             <div class="panel-body" >
                    <input type="text" class="form-control" name="task" value="<?php echo $_GET['task'] ?>"   style="float: left; width: 250px;" />
                    <div><input type="text" class="form-control" name="text" value="<?php echo $_GET['text'] ?>"  style="float: left; width: 250px;" /></div>

                    <div class="form-group" style="margin-left: 50px;">
                         <div>
                             <select class="form-control"  style="width: 350px; margin-left: 100px; " name="priority">
                                 <option>urgent</option>
                                 <option>medium</option>
                                 <option>low</option>

                             </select>
                         </div>
                    </div>
                 <script>
                     $(function() {
                         $("#datepicker").datepicker();
                     });
                 </script>
                 <div class="form-group" style="float:left; margin-top: -50px; ">
                     <input class="form-control" style="width: 150px;" type="text" name="date" id="datepicker"  />
                 </div>

                  <div><input style="margin-left: 170px; margin-top: 20px;" class="btn btn-primary" type="submit" id="submit_contact" name="btn-update" value="Update" /></div>
                  <div><input style="margin-left: 250px; margin-top: -55px;" class="btn btn-primary" type="submit" id="submit_contact" name="btn-cancel" value="Cancel" /></div>
             </div>
        </div>
    </form>
</div>

</body>
</html>
