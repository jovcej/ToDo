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
<div class="panel panel-primary" style="width: 600px; margin-left: 375px; margin-top: 20px; height: 525px;">

    <div class="panel-heading">Add new todo</div>
    <div class="panel-body">
        <form style="width: 500px; float: left;" id="contact-form" action="" method="POST">

            <div class="form-group" style="margin-left: 50px;">
                <label>Task name:</label>
                <input class="form-control" type="text" name="task" id="task" placeholder="Enter name...">
            </div>
            <div class="form-group" style="margin-left: 50px;">
                <label>Description:</label>
                <textarea class="form-control" style="max-width: 500px; min-height:150px; max-height: 150px;" name="comment" id="comment" placeholder="Enter description..."></textarea>
            </div>
            <script>
                $(function() {
                    $("#datepicker").datepicker();
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

            <div><input style="margin-left: 50px;" class="btn btn-primary" type="submit" id="submit_contact" name="submit" value="ADD" /></div>
            <div ><a href="search.php" class="btn btn-primary btn-lg active" style="margin-left: 400px; margin-top: -190px;  role="button">Search</a></div><br>
            <div ><a href="filter.php" class="btn btn-primary btn-lg active" style="margin-left: 400px; margin-top: -150px;  role="button">Filter by priority</a></div>
        </form>
    </div>
</div>

</body>
</html>

<?php

//conectiranje so bazata vo MySQL
$link = mysqli_connect("localhost", "root", "", "task");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//brisenje na vrednostite
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM description WHERE id = $id";
    $retval = mysqli_query($link, $sql);

    if (!$retval) {
        die('Could not delete data: ' . mysqli_error($link));
    }
}
if(isset($_POST['submit'])) {
    //Dodavanje na vrednosti vo bazata
    $task = mysqli_real_escape_string($link, $_POST['task']);
    $comment = mysqli_real_escape_string($link, $_POST['comment']);
    $date = mysqli_real_escape_string($link, $_POST['date']);
    $priority = mysqli_real_escape_string($link, $_POST['priority']);

    if ($_POST['task'] != "" or $_POST['comment'] != "" or $_POST['date'] != "" or $_POST['priority'] != "") {
        $sql = "INSERT INTO description (task, text, date, datetime, priority) VALUES ('$task' ,'$comment', STR_TO_DATE('$date', '%m/%d/%Y'), NOW(), '$priority')";

    } else {
        echo "Please fill all fields. ";
    }

    if (mysqli_query($link, $sql)) {
        echo "Records added successfully." ;
    } else {
        echo  "Please fill all fields ";
    }

}

//Dobivanje na vrednosti od bazata
$sql = "SELECT * FROM description";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {

        echo "<div class='panel panel-primary' style='width: 1200px; margin-left: 80px; margin-top: 50px;'>";
        echo "<div class='panel-heading'>List Todos<div style='float: right; margin: -6px !important;'></div></div>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<th>Title<th>";
        echo "<th>Description<th>";
        echo "<th>Created date<th>";
        echo "<th>Finish date<th>";
        echo "<th>Priority</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {

            //formatiranje na datumot
            $myDateTime = DateTime::createFromFormat('Y-m-d', $row['date']);
            $date = $myDateTime->format('d.m.Y');

            $time = strtotime($row['datetime']);
            $datetime = date(" H:i:s d.m.y", $time);

            //pecatenje na tabelata
            echo "<tr>";
            echo "<td>" . $row['task'] . "</td>" . "<td>";
            echo "<td>" . $row['text'] . "</td>" . "<td>";
            echo "<td>" . $datetime . "</td>" . "<td>";//datum i vreme
            echo "<td>" . $date . "</td>" . "<td>";//datum
            echo "<td>" . $row['priority'] . "</td>";//prioritet
            echo '<td><a href="index.php?id=' . $row['id'] . '">Delete</a></td>' . "<td>";//delete
            echo '<td><a href="edit.php?id=' . $row['id']. '&' . 'task=' . $row['task'] .'&' . 'text=' . $row['text'] .
                                        '&' . 'priority=' . $row['priority'] . '">Edit</a></td>' . "<td>";//update
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";

        mysqli_free_result($result);

    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }

mysqli_close($link);

?>
