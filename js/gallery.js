function addLike(id) {
    let src = document.getElementById('like_'+id).attributes.getNamedItem("src").value;
    if (src == "/content/images/unliked.png") {
        document.getElementById('like_'+id).src = "/content/images/liked.png";
        document.getElementById('modal_like_'+id).src = "/content/images/liked.png";
        let element = document.getElementById('likes_number'+id);
        let numb = element.innerHTML;
        numb = parseInt(numb);
        numb++;
        element.innerHTML = numb+' j\'aime';
        let modal_elem = document.getElementById('modal_likes_number_'+id);
        let modal_number = numb;
        modal_elem.innerHTML = modal_number+' j\'aime';
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/library/add_like.php?id_picture="+id, true);
        xhr.send();
    }
    else if (src == "/content/images/liked.png") {
        document.getElementById('like_'+id).src = "/content/images/unliked.png";
        document.getElementById('modal_like_'+id).src = "/content/images/unliked.png";
        let element = document.getElementById('likes_number'+id);
        let numb = element.innerHTML;
        numb = parseInt(numb);
        numb--;
        element.innerHTML = numb+' j\'aime';
        let modal_elem = document.getElementById('modal_likes_number_'+id);
        let modal_number = numb;
        modal_elem.innerHTML = modal_number+' j\'aime';
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/library/delete_like.php?id_picture="+id, true);
        xhr.send();
    }
}

function addComment(id, comment, username) {
    comment = htmlEntities(comment.value);
    if (comment.trim() === "")
        return ;
    let element = document.getElementById('modal_comments_n_'+id);
    let nbc_modal = element.innerHTML;
    nbc_modal = parseInt(nbc_modal);
    nbc_modal++;
    element.innerHTML = nbc_modal+' commentaires';
    let element2 = document.getElementById('comments_number_'+id);
    let nbc = element2.innerHTML;
    nbc = parseInt(nbc);
    nbc++;
    element2.innerHTML = nbc+' commentaires';
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/library/add_comment.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id_picture="+id+"&comment="+comment);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let par = document.createElement("p");
            par.setAttribute("class", "comment");
            par.innerHTML = "<b> "+username+": </b>"+comment;
            let p = document.getElementById('first_comment_'+id);
            document.getElementById('first_comment_'+id).appendChild(par);
            document.getElementById('new_comment_'+id).value = "";
        }
    }
}

function deletePicture(id) {
    var elem = document.getElementById('delete_'+id).parentNode.remove();
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/library/delete_picture.php?id_pic="+id, true);
    xhr.send();
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}