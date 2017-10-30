<?php

   include('../include/config.php');
   include('../include/helpers.php');


   $send_to_api_flag=0;
   if($_SERVER['REQUEST_METHOD']=="POST"){
           if($_SESSION['method']=="upload"){
            $datenow = (string)(date('d-m-Y'));
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
                        $_SESSION['today_image']=$target_file;
                    }
                }
            }
            else{
                echo "ERROR IN UPLOADING";
            }
            //for image finish

        }
        else if($_SESSION['method']=="webcam"){
            //save image from webcam
            $base64 = $_POST['photo'];
            $filename = $_POST['filename'];
            $img = str_replace('data:image/png;base64,', '', $base64);
            $data = base64_decode($img);
            file_put_contents('./img/'.$_SESSION['class']."/".$filename.'.png',$data);
            $_SESSION['today_image']='./img/'.$_SESSION['class']."/".$filename.'.png';
            $send_to_api_flag=1;
        }




        if($send_to_api_flag){
            $gallery_name = $_SESSION['class'];
            if($_SESSION['method']=="upload"){
            $path = $target_file;
            $type = $imageFileType;
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        //SEND IT TO API
        $request_url = API_URL . "/recognize";
        $request = curl_init($request_url);
        $request_body = array("image" => $base64, "gallery_name" => $gallery_name);
        $request_body = json_encode($request_body);
        //what to send
        $credentials = array(
                        "Content-type : application/json",
                        'Content-Length: ' . strlen($request_body),
                        "app_id:" . API_ID,
                        "app_key:" . API_KEY
                        );

        //set CURL options
        curl_setopt($request, CURLOPT_POST, TRUE);
        curl_setopt($request, CURLOPT_HTTPHEADER, $credentials);
        curl_setopt($request, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($request, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        //output in string response
        $response = curl_exec($request);
        //fed it back to file, response is in JSON
        #echo $response;
        curl_close($request);
        //parse response and return result

        $array_response = api_recognize_parser($response);
        $table = attendence_table_maker($array_response);

        $_SESSION['attendence_array']=$array_response;
        $_SESSION['table']=$table;
        redirect("show_faces_found.php");
        //final show it off to teacher before marking attendence
        //close curl session

        }
        else{
            echo "Send to api FALSE";
        }
   }
?>