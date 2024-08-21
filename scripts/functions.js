let msgCodeVError = document.querySelector('.message');
function CodeVerifError(msgCodeVError){
  msgCodeVError.style.opacity = '1';
  msgCodeVError.innerHTML = "Vous avez saisi un code incorrect , Veuillez ressayer !";
}

function vers_Modif() {
    window.location.href = 'modif.php';
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



