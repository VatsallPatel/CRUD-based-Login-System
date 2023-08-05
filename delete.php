<?php

    include 'connection.php';

    $id = $_GET['id'];

    $query = "DELETE FROM user WHERE id = $id";

    $result = mysqli_query($db, $query);

    if($result)
    {
        header('Location: read.php?msg=Record deleted successfully');
    }
    else
    {
        echo mysqli_error($db);
    }

?>