
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
$img = $_POST['photo'];
$filename = $_POST['filename'];
$img = str_replace('data:image/png;base64,', '', $img);
$data = base64_decode($img);
file_put_contents('./img/'.$filename.'.png',$data);
}
else{
    $fp = fopen('jd.jpg','w');
    fclose($fp);
}

?>
