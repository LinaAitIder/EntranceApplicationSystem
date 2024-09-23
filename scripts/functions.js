let msgCodeVError = document.querySelector('.message');
function CodeVerifError(msgCodeVError){
  msgCodeVError.style.opacity = '1';
  msgCodeVError.innerHTML = "Vous avez saisi un code incorrect , Veuillez ressayer !";
}

function message(msg,className) {
    let msgElement = document.querySelector(`.${className}`);
    msgElement.innerHTML = `<div><p>${msg}</p></div>`;
    msgElement.style.backgroundColor='rgba(255, 15, 11, 0.46)'  ;
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



