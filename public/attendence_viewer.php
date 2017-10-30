<?php
    include("../include/config.php");
    include("../include/helpers.php");

    if($_SERVER['REQUEST_METHOD']=="GET"){
        $conn=dbconnect();
        if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		}
        else{
            $class = $_SESSION['class'];
            $query = "SELECT * FROM classes WHERE class_name = '".$_SESSION['class']."'";
            $results = $conn->query($query);
            $row = $results->fetch_assoc();
            $cid = $row['cid'];
            $query = "SELECT * FROM dates WHERE cid=".$cid;
            $results = $conn ->query($query);
            if($results->num_rows==0){
                    $flag=0;
                    $show ="NO CLASSES WHERE TAKEN BY YOU";
            }
            else{
                    $flag=1;
                while($row=$results->fetch_assoc()){
                    $show[$row['date']]=$row['image'];
                }
            }
            render("attendence_viewer_form.php",["title"=>Viewer,"show"=>$show,"flag"=>$flag]);
        }
    }
    else if($_SERVER['REQUEST_METHOD']=="POST"){
        $conn=dbconnect();
        if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		}
		else{
		    $view_date = $_POST['view_date'];
            $class = $_SESSION['class'];
            $query = "SELECT * FROM classes WHERE class_name = '".$_SESSION['class']."'";
            $results = $conn->query($query);
            $row = $results->fetch_assoc();
            $cid = $row['cid'];
            $query = "SELECT * FROM dates WHERE cid=".$cid." AND date='".$view_date."'";
            #echo $query;
            $results = $conn ->query($query);
            #print_r($results);
            if(1){
                $present=1;
                $row =$results->fetch_assoc();
                $did = $row['did'];
                $image_path = $row['image'];
                //Get sid
                $query = "SELECT * FROM attendence WHERE did=".$did;
                $results = $conn->query($query);
                //yehi pr table bna daali
                $table = "<table class ='table table-striped'><thead><tr><th>Student ID</th><th>Student Name</th><th>Student Image</th></tr></thead>";
                while($row = $results->fetch_assoc()){
                    $temp_sid = $row['sid'];
                    $query = "SELECT * FROM student WHERE sid = ".$temp_sid;
                    $temp_results=$conn->query($query);
                    $temp_row = $temp_results->fetch_assoc();
                    $table = $table."<tr align='left'><td>".$temp_row['sid']."</td><td>".$temp_row['name']."</td><td><img src='".$temp_row['img_path']."'width='45' height='50'/></td></tr>";
                }
                //show list of students with this sid
                $table=$table."</table>";
                #echo $table;
                render("attendence_viewer_show.php",["present"=>$present,"date"=>$view_date,"table"=>$table,"image_path"=>$image_path]);
            }
            else{
                $present=0;
                render("attendence_viewer_show.php",["present"=>$present]);
            }
		}
    }
?>