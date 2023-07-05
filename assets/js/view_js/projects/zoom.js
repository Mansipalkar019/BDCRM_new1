$(document).ready(function (e) {
    var swidth = screen.width;
     var height = screen.height;
    // alert(height)
    // alert(swidth)

    if(height==1080 && swidth==1920){
       // alert('jj')
        document.body.style.zoom="120%";  
    }else if(height==768 && swidth==1366){
        document.body.style.zoom="90%";
    }else if(height==768 && swidth==1024){
        document.body.style.zoom="90%";
    }
    else if(swidth!=1366){
    document.body.style.zoom="92%";
    }
    else if(height <= 768)
    {
       // alert('hhhhhh')
        document.body.style.zoom="88%";  
    }
    else{
        document.body.style.zoom="97%";
    }
    });