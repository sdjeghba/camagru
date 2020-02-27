var video = document.querySelector("#videoElement");

if (navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function (stream) {
      video.srcObject = stream;
    })
    .catch(function (err0r) {
      console.log("Error : Something went wrong!");
    });
}


// video.addEventListener('canplay', function(ev){
//   if (!streaming) {
//     height = video.videoHeight / (video.videoWidth/width);
//     video.setAttribute('width', width);
//     video.setAttribute('height', height);
//     canvas.setAttribute('width', width);
//     canvas.setAttribute('height', height);
//     streaming = true;
//   }
// }, false);

// function takepicture() {
//   canvas.width = width;
//   canvas.height = height;
//   canvas.getContext('2d').drawImage(video, 0, 0, width, height);
//   var data = canvas.toDataURL('image/png');
//   photo.setAttribute('src', data);
// }

// startbutton.addEventListener('click', function(ev){
//     takepicture();
//   ev.preventDefault();
// }, false);


// startbutton.addEventListener('click', function(ev){
//   takepicture();
//   ev.preventDefault();
// }, false);