<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Table</title>

    <LINK REL=StyleSheet HREF="" TYPE="text/html" MEDIA=screen>

    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.css">

    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>

    <style>
        .scroll{
            max-height: 300px;
            max-width: 1200px;
            overflow: auto;
        }
    </style>
</head>

<body>
    <form action="table.php" method="post">
        <div style="margin-top: 40px; width: 160px;  margin-left: 1050px">
            <input class="form-control" type="text" name="valueToSearch" id="UserName"/>
            <input class="btn btn-success" type="submit" name="search" value="Filter" style="margin-left: 170px; margin-top: -57px;"/>
            <a href="index.php" class="btn btn-info" role="button" style="margin-left: -100px; margin-top: -96px">Add new</a>
        </div>
    </form>
</body>
</html>

<?php
//Delete items from table
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "DELETE FROM description WHERE id = $id";
    $search_result = filterTable($query);
}

//Search function
if(isset($_POST['search'])){
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM description WHERE CONCAT(task, priority) LIKE '%" .$valueToSearch ."%'";
    $search_result = filterTable($query);
}else{
    $query = "SELECT * FROM description ORDER BY datetime DESC";
    $search_result = filterTable($query);
}

function filterTable($query){
    $connect = mysqli_connect("localhost","root", "", "task");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

//Echo table
echo "<div class='panel panel-primary' style='width: 1200px; margin-left: 80px;'>";
    echo "<div class='panel-heading'>List Todos<div style='float: right; margin: -6px !important;'></div></div>";
    echo "<div class='scroll'>";
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
                while ($row = mysqli_fetch_array($search_result)) {
                    //formatting date and time
                    $myDateTime = DateTime::createFromFormat('Y-m-d', $row['date']);
                    $date = $myDateTime->format('d.m.Y');

                    $time = strtotime($row['datetime']);
                    $datetime = date(" H:i:s d.m.Y", $time);

                    echo "<tr>";
                    echo "<td>" . $row ['task'] . "</td>" . "<td>";
                    echo "<td>" . $row['text'] . "</td>" . "<td>";
                    echo "<td>" . $datetime . "</td>" . "<td>";
                    echo "<td>" . $date . "</td>" . "<td>";
                    echo "<td>" . $row['priority'] . "</td>";
                    echo '<td><a href="table.php?id=' . $row['id'] . '">Delete</a></td>' . "<td>";
                    echo '<td><a href="edit.php?id=' . $row['id'] . '&' . 'task=' . $row['task'] . '&' . 'text=' . $row['text'] .
                         '&' . 'priority=' . $row['priority'] . '&' . 'date=' . $row['date'] . '">Edit</a></td>' . "<td>";
                    echo "</tr>";
                }
            echo "</tbody>";
        echo "</table>";
    echo "</div>";
echo "</div>";

?>




