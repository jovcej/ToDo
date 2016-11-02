<?php

$connect = mysqli_connect("localhost","root", "", "task");
if ($connect === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$output = "";

if(isset($_POST['priority'])){
    $output = "";
    $searchq = $_POST['priority'];
    if (trim($_POST['priority'])=='') {
        echo "There was no search results!";

    } else {
        $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
        $sql = "SELECT * FROM description WHERE priority LIKE '%$searchq%'";
        $query = mysqli_query($connect, $sql) or die("could not search!");
        $count = mysqli_num_rows($query);

        if ($count == 0) {
            $output = '';

        } else {
            while ($row = mysqli_fetch_array($query)) {
                $task = $row['task'];
                $text = $row['text'];
                $date = $row['date'];
                $datetime = $row['datetime'];
                $priority = $row['priority'];

                //formatiranje na datumot
                $myDateTime = DateTime::createFromFormat('Y-m-d', $row['date']);
                $date = $myDateTime->format('d.m.Y');

                $time = strtotime($row['datetime']);
                $datetime = date("d.m.y H:i:s", $time);

                $output .=  "<div class='panel panel-primary' style='width: 50%; margin-left:320px; '>" .
                    "<div class='panel-heading'>List Todos</div>" .
                        "<table class='table'>" .
                            "<thead>" .
                                "<tr>" .
                                    "<th>Title</th>" .
                                    "<th>Description</th>" .
                                    "<th>Created date</th>" .
                                    "<th>Finish date</th>" .
                                    "<th>Priority</th>" .
                                    "<th></th>" .
                                    "<th></th>" .
                                "</tr>" .
                            "</thead>" .
                            "<tbody>" .
                                "<tr>" .
                                    "<td>" . $row['task'] . "</td>" .
                                    "<td>" . $row['text'] . "</td>" .
                                    "<td>" . $datetime . "</td>" .
                                    "<td>" . $date . "</td>" .
                                    "<td>" . $row['priority'] . "</td>" .
                                    '<td><a href="index.php?id=' . $row['id'] . '">Delete</a></td>' .
                                "</tr>" .
                            "</tbody>" .
                        "</table>" .
                    "</div>" .
                    "</div>";
            }
        }
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
<form action="" method="post">

    <div class="panel panel-default" style='width: 700px; margin-left: 310px; margin-top: 50px;'>
        <div class="panel-body" >
            <select class="form-control" name="priority" style="float: left; width: 250px;">
                <option>Filter...</option>
                <option>urgent</option>
                <option>medium</option>
                <option>low</option>
            </select>

            <button type="submit" name="submit" style='width: 40px;  margin-top: -1px; height:34px; margin-left: 6px;'>
                <span class="glyphicon glyphicon-search"></span>
            </button>

            <a class="btn btn-default" href="index.php" role="button" style='margin-left: 300px;'>Back</a>
        </div>
    </div>
    <hr>
    <?php echo ("$output"); ?>

</form>

</body>
</html>