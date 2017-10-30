<?php

    include("../include/config.php");
    include("../include/helpers.php");

    $conn = dbconnect();
    if($conn ->connect_error){
        die("connection failed".$conn->connect_error);
    }
    else{
        require("../views/header.php");
        $query = "SELECT * FROM classes WHERE class_name = '".$_SESSION['class']."'";
        $results = $conn ->query($query);
        $row = $results->fetch_assoc();
        $cid = $row['cid'];


        $query = "SELECT * FROM student WHERE cid=".$cid;
        $results = $conn ->query($query);
        if($results->num_rows>0){
            echo student_printer($results);
        }
        else{
            echo "You haven't added students yet,Please add<br/><br/>";
        }

        /*See value inside Session['modifier']*/
        if($_SESSION['modifier']=='add'){
            include('../views/add_form.php');
        }
        else if($_SESSION['modifier']=='delete'){
            if($results->num_rows>0)
            include('../views/del_form.php');
            else
            echo "Please First Add Students<br/><br/>";
        }
        else if($_SESSION['modifier']=='update'){
            if($results->num_rows>0)
            include('../views/update_form.php');
            else
            echo "Please First Add Students<br/><br/>";
        }
        /*done*/
        include('../views/footer.php');
    }
?>