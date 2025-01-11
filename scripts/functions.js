let msgCodeVError = document.querySelector('.message');
function CodeVerifError(msgCodeVError){
  msgCodeVError.style.opacity = '1';
  msgCodeVError.innerHTML = "Vous avez saisi un code incorrect , Veuillez ressayer !";
}

function message(msg,className) {
    let msgElement = document.querySelector(`.${className}`);
    msgElement.innerHTML = `<div style="position: absolute; top: 80%; left:20%;padding: 10px; max-width: 90%; word-wrap: break-word; background-color:rgba(255, 15, 11, 0.46)"><p>${msg}</p></div>`;
}

function deconnecter() {
    window.location.href = 'controller/logout.php';
}

function suppr_cmpt() {
    window.location.href = 'suppr_cmpt.php';
}

function recu() {
    window.location.href = 'pdf_gen.php';
}



