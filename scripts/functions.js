let msgCodeVError = document.querySelector('.message');
function CodeVerifError(msgCodeVError){
  msgCodeVError.style.opacity = '1';
  msgCodeVError.innerHTML = "Vous avez saisi un code incorrect , Veuillez ressayer !";
}

function message(msg,id) {
    let msgElement = document.querySelector(`#${id}`);
    msgElement.innerHTML = `
    <div class="container-fluid">
    <p class="text-center">${msg}</p>
    </div>
    `;
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



