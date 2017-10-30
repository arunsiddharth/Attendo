<?php
    include('../include/config.php');
    include('../include/helpers.php');

    $conn = dbconnect();
    if($conn->connect_error){
		die("Connection Failed".$conn->conncet_error);
	}
	else{
	    require('../views/header.php');
        $query = "SELECT * FROM classes WHERE tid=".$_SESSION['tid'];
        $results = $conn->query($query);
        if($results->num_rows>0){
            echo class_printer($results);
        }
        else{
            echo "You Have No Classes,Please Add Classes Using Add Classes";
        }
        require('../views/footer.php');
	}
?>
