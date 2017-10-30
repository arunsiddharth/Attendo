<?php
require_once 'facepp_sdk.php';
########################
###     example      ###
########################

$facepp = new Facepp();
$facepp->api_key       = 'CPjTlofkavLeLHzYtqIA4G3wp_WkP6TL';
$facepp->api_secret    = 'dIlVkXW5p6ljBDDTuTacZnLFCm5EwPkL';
#detect local image 
$params['image_file']          = './img/joy.jpg';
$params['attribute']    = 'gender,age,race,smiling,glass,pose';
$response               = $facepp->execute('/detect',$params);
print_r($response);
echo "\n\n";
#detect image by url
/*
$params['url']          = 'http://www.faceplusplus.com.cn/wp-content/themes/faceplusplus/assets/img/demo/1.jpg';
*/
$params['image_url'] = 'https://vignette.wikia.nocookie.net/mtg/images/6/67/11062011217_600x600_500KB.jpg/revision/latest?cb=20110814154342';
$response               = $facepp->execute('/detect',$params);
print_r($response);
echo "\n\n";
if($response['http_code'] == 200) {
    #json decode 
    $data = json_decode($response['body'], 1);
    
    #get face landmark
    foreach ($data['face'] as $face) {
        $response = $facepp->execute('/detection/landmark', array('face_id' => $face['face_id']));
        print_r($response);
    }
    
    #create person 
    $response = $facepp->execute('/person/create', array('person_name' => 'unique_person_name'));
    print_r($response);
    #delete person
    $response = $facepp->execute('/person/delete', array('person_name' => 'unique_person_name'));
    print_r($response);
}
else{
    echo "Ho gyi gadbad";
}