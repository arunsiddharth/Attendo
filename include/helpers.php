<?php
    function apologize($message){
        render("apologize.php", ["message" => $message]);
    }

    function redirect($location){
        header("Location: {$location}");
        exit;
    }

    function render($view, $values = []){

        if(file_exists("../views/{$view}")){
            // extract variables into local scope
            extract($values);

            // render view (between header and footer)
            require("../views/header.php");
            require("../views/{$view}");
            require("../views/footer.php");
            exit;
        }

        else{
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }

    function logout(){
        //unset session
        $_SESSION = [] ;

        //remove cookie
        if (!empty($_COOKIE[session_name()])){
            setcookie(session_name(),"",time()-42000);
        }

        session_destroy();
        redirect("index.php");
    }

    function student_printer($result){
        //get $result as arrays of rows each row containing same as row of table student write a code get help from class printer
        $final = "<table class = 'table table-stripped'><thead><tr><th>S.no.</th><th>Student ID</th><th>Student Name</th><th>Image</th><th>Attendence</th></tr></thead>";
        $i=1;
        while($row = $result ->fetch_assoc()){
            $final = $final ."<tr align = 'left'><td>".$i."</td><td>".$row["sid"]."</td><td>".$row["name"]."</td><td><img src='".$row["img_path"]."' width='50' height='50'></img></td><td>".$row["attendence"]."</td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
    }

    function class_printer($result){
        $final = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Class Name</th><th>No. of Students</th><th>GO to Class</th></tr></thead>";
        $i=1;
        while($row = $result->fetch_assoc()){
            $final = $final . "<tr align = 'left'><td>".$i."</td><td>".$row['class_name']."</td><td>".$row['count']."</td><td><a href='select_class.php?class=".$row['class_name']."'>GO</a></td></tr>";
            $i=$i+1;
        }
        $final = $final."</table>";
        return $final;
    }


    function subject_id_maker($subject_id){
        $subject_id = str_replace(' ', '', $subject_id);
        $subject_id = strtolower($subject_id);
        return $subject_id;
    }
    function get_name($subject_id){
        $name = str_replace('-',' ',$subject_id);
        return $name;
    }
    function get_subject_id($name){
        $subject_id = str_replace(' ','-',$name);
        return $subject_id;
    }

    function api_response_check($response){
        $response_object = json_decode($response);
        return intval(count($response_object->Errors))==0;
    }

    function api_recognize_parser($response){
        #$response = "'".$response."'";
        $response_object = json_decode($response);
        print_r($response_object);
        //count number of rows in images and error
        $images_array = $response_object -> images;
        $images_array_num_rows = count($images_array);
        $error_array = $response_object -> Errors;
        $error_array_num_rows = count($error_array);

        $result = [];
        $i = 0;
        if($error_array_num_rows==0){
            $result['error'] = 0;
            $result['faces'] = $images_array_num_rows;
            while($i < $images_array_num_rows){
              $transaction_status = $images_array[$i]->transaction->status;
              if((string)$transaction_status=="success"){
                 $subject_id = (string)$images_array[$i]->transaction->subject_id;
                 $confidence = floatval($images_array[$i]->transaction->confidence);
                 if($result[$subject_id]<$confidence)$result[$subject_id]=$confidence;
                 /*$j = 0;
                 $num_candidates = count($images_array[$i]->candidates);
                 $candidates_array = $images_array[$i]->candidates;
                 while($j < $num_candidates){
                    $subject_id =(string)$candidates_array[$j]->subject_id;
                    $confidence =floatval($candidates_array[$j]->confidence);
                    if($result[$subject_id]<$confidence)$result[$subject_id]=$confidence;
                    $j = $j + 1;
                 }*/
              }
              $i=$i+1;
            }
        }
        else{
          $result['error']=1;
          $result['faces']=0;
        }
        return $result;
    }
        function attendence_table_maker($array_response){
        $faces_detected = intval($array_response['faces']);
        $error_flag = intval($array_response['error']);
        if($error_flag==0){
            $i=1;
            $result = "<table class='table table-striped'><thead><tr><th>Sr. No.</th><th>Student Name</th><th>Confidence</th></tr></thead>";
            foreach($array_response as $key => $conf){
                if(!in_array($key,['error','faces'])){
                    $result = $result."<tr><td>{$i}</td><td>{$key}</td><td>{$conf}</td></tr>";
                    $i = $i + 1;
                }
            }
            $result= $result."</table>";
        }
        else{
            $result = "<b>No Faces Detected in the Image, Please Upload Image Again</b>";
        }
        return $result;
    }
    if (!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php"]))
    {
        if (empty($_SESSION["tid"]))
        {
            redirect("login.php");
        }
    }
?>