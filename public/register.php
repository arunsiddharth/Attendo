<?php

    include("../include/config.php");
    include("../include/helpers.php");
    if(!empty($_SESSION['tid'])){
        redirect('classes.php');
    }
    else if($_SERVER["REQUEST_METHOD"]=='GET'){
        render("register_form.php",["title"=>"Register"]);
    }
    else if($_SERVER["REQUEST_METHOD"]=="POST"){
        //Mysql server connect
        $conn = dbconnect();
        if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		}
		else{
        //MYSQLI escape string
        $t_name = mysqli_real_escape_string($conn, $_POST['t_name']);
        $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if($password != $confirm_password){
            apologize("Password Not Matched");
        }

        $query = "INSERT INTO teacher(name, email_id, password) VALUES('".$t_name."','".$email_id."','".password_hash($_POST['password'], PASSWORD_DEFAULT)."')";
        $results = $conn ->query($query);
        if($results != 1){
            apologize("Email Id already Taken");
        }
        else{
            $t_id = $conn->insert_id;
            $_SESSION['tid'] = $t_id;
            $_SESSION['t_name'] = $t_name;
            redirect('classes.php');
        }
        }
    }
?>