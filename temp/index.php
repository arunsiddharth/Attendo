<!DOCTYPE html>
<html>
    <head>
        <title>
            attendo
        </title>
        
    </head>
    <body>
        <div style="width:100%; margin:0 auto;">
        <div width="45%" style="float:left;border:2px solid red;margin-right=2px;padding:4px 4px 4px 4px">
            <video id='video' width='400' height='280'></video>     </br><center>
            <button id='btn_snap' onclick='take_photo()'>Cheese</button></center>
        </div>
        <div width = "45%" style = 'float:right;border:2px solid green;padding:4px 4px 4px 4px'>
            <canvas id='canvas' width='400' height='280' ></canvas>      </br><center>
            <input type='text' name='filename' id='filename' >&nbsp;&nbsp;
            <button id='btn_save' onclick='save_photo()' >Save</button></center>
        </div>
        </div>
        
        <script src = "/js/jquery-1.11.3.min.js"></script>
        <script src = "/js/scripts.js"></script>
    </body>
</html>