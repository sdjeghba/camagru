// Allow the camera access

var video = document.querySelector("#videoElement");

//Acess for camera for browsers

if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia ({
        video:true
        //after allowing the camera, start the video stream
    }).then(function(stream) {
        video.srcObject = stream
        video.play(); 
    }).catch(function(error) {
        console.log(error);
    });
}

var image = document.getElementById('picture'),
    context = image.getContext('2d');

document.getElementById('capture').addEventListener('click', function() {
    context.drawImage(video, 0, 0, image.width, image.height);
});