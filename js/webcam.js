let width = 320,
    height = 240,
    filter = "none",
    streaming = false,
    video = document.getElementById('video'),
    canvas = document.getElementById('canvas'),
    photos = document.getElementById('photos'),
    photoButton = document.getElementById('photo-button'),
    saveButton = document.getElementById('save-button'),
    photoFilter = document.getElementById('photo-filter'),
    imgsrc = document.getElementById('imgsrc'),
    img1 = document.getElementById('img1'),
    img2 = document.getElementById('img2'),
    img3 = document.getElementById('img3'),
    uploadimg = document.getElementById('uploadimg'),
    submitUpload = document.getElementById('submitupload'),
    filter_selected = 0,
    data_picture = 0;
    data_upload = 0;
    disabledError = 0;
    
// get the webcam onto the browser
navigator.mediaDevices.getUserMedia({video:true,audio:false}
)
.then(function(stream){
     video.srcObject = stream;
     video.play(); 
})
.catch(function(err){
    console.log(`Error: ${err}`);
});

//play when ready
video.addEventListener('canplay', function(e) {
  if (!streaming) {
    if (window.screen.width < 330) {
      video.setAttribute('width', 256);
      video.setAttribute('height', 192);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height); 
    }
    else {
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
    }


    streaming = true;
  }
})
 
//function: merge two pictures calling merge_pictures.php, display the response
function mergePD(picture) {
  let dataPicture = picture.replace("data:image/png;base64,", "");
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "/library/merge_pictures.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("picture="+encodeURIComponent(dataPicture)+"&filter="+filter_selected);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      response = "data:image/png;base64,"+response;
      data_picture =  response;
      let image = new Image();
      image.src = response;
      image.onload = function() {
        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
        canvas.toDataURL('image/png');
      }
    }
  }
}

//function: take picture if flow == 1 else upload picture
function takeSnapshot(flow) {
    if (filter_selected != 0) {
      let newcanvas = document.createElement('canvas');
      newcanvas.width = width;
      newcanvas.height = height;
      if (flow == 1) {
        newcanvas.getContext('2d').drawImage(video, 0, 0, width, height);
        let picture = newcanvas.toDataURL('image/png');
        mergePD(picture);
      }
      else {
        let image = new Image();
        image.src = data_upload;
        image.onload = function() {
          newcanvas.getContext('2d').drawImage(image, 0, 0, width, height);
          let picture = newcanvas.toDataURL('image/png');
          mergePD(picture);
        }
      }
    }
    else {
      console.log("No picture");
    }
}

//diplay the miniatures filtered lively;
function displayMiniatures(id, data) {
  let div = document.createElement("DIV");
  div.setAttribute("class", "display_min");
  let picture = document.createElement("IMG");
  picture.setAttribute("src", data);
  picture.setAttribute("class", "miniature");
  let close = document.createElement("IMG");
  close.setAttribute("src", "/content/images/redcross.png");
  close.setAttribute("class", "delete_picture");
  close.setAttribute("id", "delete_"+id);
  close.setAttribute("onclick", "deletePicture("+id+")");
  let miniature = document.getElementById('side');
  miniature.insertBefore(div, miniature.childNodes[0]);
  div.insertBefore(picture, div.childNodes[0]);
  div.insertBefore(close, div.childNodes[0]);
}

//function: save picture to the database and call the displayMiniatures function
function savePicture(data) {
  let picData = data.replace("data:image/png;base64,", "");
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "/library/save_picture.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("pic="+encodeURIComponent(picData));
  xhr.onreadystatechange = function () {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      let id_pic = response['id_picture'];
      displayMiniatures(id_pic, data);
    }
  }
}

//addEventlistenner for clicks 
photoButton.addEventListener('click', function(e) {
  if (streaming == true) {
      takeSnapshot(1);
      saveButton.removeAttribute("disabled");
  }
  else {
    console.log("No video");
  }
  e.preventDefault();
}, false);

saveButton.addEventListener('click', function(e) {
  if (!data_picture)
    console.log("Nothing to save");
  else
    savePicture(data_picture);
  e.preventDefault();
}, false);

submitupload.addEventListener('click', function(ev) {
  if (data_upload == 0)
    console.log("You have to upload a picture");
  else {
    saveButton.removeAttribute("disabled");
    takeSnapshot(0);
  }
}, false);

//function: handle radio buttons and activate snapshot-merger button when filter selected
function radio_selected(value) {
  if (value === 1) {
    filter_selected = 1;
    imgsrc.setAttribute("src", "/content/filters/img"+value+".png");
  }
  else if (value === 2) {
    filter_selected = 2;
    imgsrc.setAttribute("src", "/content/filters/img"+value+".png");
  }
  else if (value === 3) {
    filter_selected = 3;
    imgsrc.setAttribute("src", "/content/filters/img"+value+".png");
  }
  photoButton.removeAttribute("disabled");
  if (data_upload) {
    submitupload.setAttribute("class", "submitbutton");
    submitupload.removeAttribute("disabled");
  }
  if (disabledError) {
    submitupload.setAttribute("class", "submitbutton submitdisabled");
    submitupload.disabled = true;
  }
}

function changeLabel() {
  label = document.getElementById('uploadimg').files[0].name;
  document.getElementById('labeltext').innerHTML = label;
}

//handle the upload button eventlistener
uploadimg.addEventListener('change', function(e) {
  let file = this.files[0];
  let imageType = /image.*/;
  if (file.type.match(imageType) && file.size < 1500000) {
    let reader = new FileReader();
    reader.addEventListener('load', function() {
    data_upload = reader.result;
    if (filter_selected) {
      submitupload.setAttribute("class", "submitbutton");
      submitupload.removeAttribute("disabled");
    }
  }, false);
  reader.readAsDataURL(file);
  }
  else {
    document.getElementById('labeltext').innerHTML = "Mauvais format, ou fichier trop volumineux";
    submitupload.setAttribute("class", "submitbutton submitdisabled");
    submitupload.disabled = true;
    disabledError = 1;
  }
}, false);

function deletePicture(id) {
  document.getElementById('delete_'+id).parentNode.remove();
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/library/delete_picture.php?id_pic="+id, true);
  xhr.send();
}