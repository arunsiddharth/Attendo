<?php
    if($present==1){
        echo "DATE : ".$date;
        echo $table;
        echo "<br/></br>";
        echo "Image taken By You is :<br/>";
        echo "<img src={$image_path} width='600'>" ;
    }
    else{
        echo "No Student Was Present That Day";
    }
?>