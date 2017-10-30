
    var canvas,video,context;
    //store element into variables
    canvas = document.getElementById('canvas');
    video = document.getElementById('video');
    context = canvas.getContext('2d');

    //get correct get usermedia according to browser availble
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    var parameters = {video : true};
    var error_callback = function(e){
                                console.log('Rejected',e);
                          };
    var success_callback = function(stream){
                                video.src = window.URL.createObjectURL(stream);
                                video.onloadedmetadata = function (e) {
                                                            video.play();
                                                        };
                            };
    if(navigator.getUserMedia){
        navigator.getUserMedia(parameters, success_callback, error_callback);
    }
    else{
        console.log('OOPS !! getUserMedia Not Supported');
    }


    function take_photo(){
        context.drawImage(video,0,0,400,280);
    }

    function save_photo(){
        var d = canvas.toDataURL("image/png");
        var filename = $('#filename').val();
        $.ajax({
           type : "POST",
           data :{
              photo : d,
              filename : filename
           },
           url : "/recognize.php"
        }).done(function(o){
               console.log('Photo saved sucessfully');
            }
        );


    }
