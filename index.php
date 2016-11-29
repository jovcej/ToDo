<?php
//connect to db
$link = mysqli_connect("localhost", "root", "", "task");
    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

//validation and insert
$errors ="";
if(isset($_POST['submit'])) {
    $task = mysqli_real_escape_string($link, $_POST['task']);
    $comment = mysqli_real_escape_string($link, $_POST['text']);
    $date = mysqli_real_escape_string($link, $_POST['date']);
    $priority = mysqli_real_escape_string($link, $_POST['priority']);

    if (trim($task) == "" || trim($comment) == "" || trim($date) == "") {
        echo '<div class="alert alert-danger">' . $errors .= " Please fill all fields" . '</div>';
    }else{
        $sql = "INSERT INTO description (task, text, date, datetime, priority) VALUES ('$task' ,'$comment', STR_TO_DATE('$date', '%d/%m/%Y'), NOW(), '$priority')";
        $result = mysqli_query($link,$sql);
        header("Location: table.php");
    }
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

<div class="panel panel-primary" style="width: 530px; margin-left: 375px; margin-top: 20px; height: 480px;">

    <div class="panel-heading">Add new todo</div>
    <div class="panel-body">
        <form style="width: 500px; float: left;" id="contact-form" action=""  method="post">

            <div class="form-group" style="margin-left: 50px; max-width: 400px;">
                <label>Task name:</label>
                <input class="form-control"  type="text" name="task" id="task"  placeholder="Enter name..." >
            </div>
            <div class="form-group" style="margin-left: 50px;">
                <label>Description:</label>
                <textarea class="form-control" style="max-width: 400px; min-height:75px; max-height: 75px;" name="text" id="comment" placeholder="Enter description..."></textarea>
            </div>
            <script>
                $(function() {
                    $("#datepicker").datepicker({ dateFormat: 'dd/mm/yy' }).val();
                });
            </script>
            <div class="form-group" style="margin-left: 50px;">
                <label>Expiry date of task:</label>
                <input class="form-control" style="width: 150px;" type="text" name="date" id="datepicker" placeholder="Date ">
            </div>
            <div class="form-group" style="margin-left: 50px;">
                <div>
                    <label>Enter priority:</label>
                    <select class="form-control" style="width: 150px;" name="priority">
                        <option>urgent</option>
                        <option>medium</option>
                        <option>low</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary btn-lg active" style="margin-left: 50px" name="submit">ADD</button>
        </form>
    </div>
</div>

</body>
</html>

