<?php

    //enroll.php
    include('../include/config.php');
    include('../include/helpers.php');

    $send_to_api_flag = 0;
    $api_response_flag = 0;

    $conn = dbconnect();
    if($conn->connect_error){
        die("CONNECTION FAILED".$conn->conncet_error);
    }
    else{
        $gallery_name = $_SESSION['class'];
        $subject_id = subject_id_maker($_POST['name']);
        $name = $_POST['name'];

            //for image ONLY
            $target_dir = "img/".$_SESSION['class']."/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                // Check if file already exists

                if (file_exists($target_file)) {
                    apologize("File already exists.");
                }
                // Check file size
                else if ($_FILES["image"]["size"] > 1000000) {
                    apologize("File is too large.");
                }
                // Check file extension

                else if($imageFileType != "jpg" && $imageFileType != "png") {
                    apologize("Only JPG, PNG files are allowed.");
                }
                // Upload file to server
                else {
                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        apologize("There was an error uploading your file.");
                    }
                    else{
                        $send_to_api_flag = 1;
                    }
                }
            }
            else{
                echo "ERROR IN UPLOADING";
            }
            //for image finish

        if($send_to_api_flag){
            $path = $target_file;
            $type = $imageFileType;
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $request_url = API_URL."/enroll";
            $request = curl_init($request_url);
            $request_body = array("image" => $base64, "subject_id" => $subject_id, "gallery_name" => $gallery_name);
            $request_body = json_encode($request_body);
            //what to send
            $credentials = array(
                        "Content-Type: application/json",
                        'Content-Length: ' . strlen($request_body),
                        "app_id : " . API_ID,
                        "app_key : " . API_KEY
                        );
            //set curl options

            curl_setopt($request, CURLOPT_POST, TRUE);
            curl_setopt($request, CURLOPT_HTTPHEADER, $credentials);
            curl_setopt($request, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($request, CURLOPT_POSTFIELDS, $request_body);
            curl_setopt($request, CURL_RETURNTRANSFER, TRUE);

            echo $credentials;
            $response = curl_exec($request);

            //fed back the result in JSON
            echo $response;

            //check for true in api response
            $api_response_flag = api_response_check($response);
            curl_close($request);

            if($api_resonse_flag){
                //get CID
                $query = "SELECT * FROM classes WHERE class_name = ".$_SESSION['class'];
                $results = $conn->query($query);
                $row = $results->fetch_assoc();
                $cid = $row['cid'];

                //add to db
                $query = "INSERT INTO student(name, img_path, subject_id, cid) VALUES('".$name."', '".$target_file."', '".$subject_id."',".$cid.")";
                $results = $conn->query($query);
                if($results != 1){
                    apologize("Student Already Present");
                }
                else{
                    redirect("modifier.php");
                }
            }
            else{
                echo "API RESPONSE IS FALSE";
            }
        }
    }
?>