<?php

            //enroll.php
            include('../include/config.php');

            $request_url = API_URL."/enroll";
            $request = curl_init($request_url);
            $request_body = array("image" => $_POST['image'], "subject_id" => $_POST['subject_id'], "gallery_name" => $_POST['gallery_name']);
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
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($request, CURLOPT_POSTFIELDS, $request_body);
            curl_setopt($request, CURL_RETURNTRANSFER, TRUE);

            echo $credentials;
            $response = curl_exec($request);

            //fed back the result in JSON
            echo $response;
            curl_close($request);
?>