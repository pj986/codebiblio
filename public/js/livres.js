function emprunter(id) {

    fetch(`/emprunts/${id}/emprunter`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert("Livre emprunté !");
    })
    .catch(err => {
        console.error(err);
        alert("Erreur !");
    });
}

function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "/";
    }
}
// Fonction pour afficher un toast
function showToast(message, isError = false) {
    const toast = document.createElement('div');
    toast.classList.add('toast');
    if (isError) {
        toast.classList.add('error'); // Pour les erreurs
    }

    toast.innerText = message;
    document.body.appendChild(toast);

    // Affichage et disparition du toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300); // Délai de suppression après l'animation
    }, 3000); // Durée du toast visible
}