<?php

    include("../include/config.php");
    include("../include/helpers.php");

    if($_SERVER['REQUEST_METHOD']=="GET"){
        if($_GET["method"]=="webcam"){
            $_SESSION['attendence_method']='webcam';
            render("attendence_webcam.php",["title"=>"Webcam"]);
        }
        else{
            $_SESSION["method"]='upload';
            render("attendence_upload_form.php",["title"=>"Upload"]);
        }
    }
    else if($_SERVER['REQUEST_METHOD']=="POST"){
        if($_POST['reply']=="yes"){
            $conn = dbconnect();
            if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		    }
		    else{
		        $attendence_array = $_SESSION['attendence_array'];
		        print_r($attendence_array);
		        $class = $_SESSION['class'];
                $query = "SELECT * FROM classes WHERE class_name = '".$_SESSION['class']."'";
                $results = $conn->query($query);
                $row = $results->fetch_assoc();
                $cid = $row['cid'];

                $today = (string)date('d-m-Y');
                //getdid
                $query = "INSERT INTO dates(date,cid) VALUES('".$today."', ".$cid.")";
                $results=$conn->query($query);
                if($results != 1){
                   apologize("Attendence Mark Failure");
                }
                else{
                    //LOTS OF ERROR POSSIBLE
                    $did = $conn->insert_id;
		            foreach($attendence_array as $key => $value){
		                //fetch sid and update his attendence

		                if(!in_array($key,['faces','error'])){

                        $query = "UPDATE student SET attendence=attendence+1 WHERE cid=".$cid." AND subject_id = '".$key."'";
                        echo $query;
                        $conn->query($query);
                        $query = "SELECT * FROM student WHERE cid=".$cid." AND subject_id='".$key."'";
                        echo $query;
                        $results = $conn->query($query);
                        $row = $results ->fetch_assoc();
                        $sid = $row['sid'];
                        $query ="INSERT INTO attendence(did,sid) VALUES(".$did.", ".$sid.")";
                        $results = $conn->query($query);
                        $query = "UPDATE dates SET present=present+1 WHERE did=".$did;
                        $conn->query($query);
		                }
		            }
                }
		    }
        }
        else{
            echo "No reply";
        }
        redirect("classes.php");
    }
?>