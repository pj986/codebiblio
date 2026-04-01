<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Scanner QR Code</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

body {
    font-family: Arial;
    text-align: center;
    background: #f4f6f9;
    padding: 30px;
}

#reader {
    margin: auto;
    width: 400px;
}

#result {
    margin-top: 20px;
    font-size: 18px;
}

/* 💎 TOAST */
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #2ecc71;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

</style>

</head>

<body>

<!-- 🔙 Bouton retour -->
<x-back-button />

<h1>📷 Scanner un livre</h1>

<div id="reader"></div>

<p id="result"></p>

<!-- Librairie QR -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let scannerStopped = false;

function showToast(message, isError = false) {

    const toast = document.createElement("div");
    toast.className = "toast";
    toast.innerText = message;

    if(isError){
        toast.style.background = "#e74c3c";
    }

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}

function onScanSuccess(decodedText) {

    // 🔥 empêche double scan
    if(scannerStopped) return;
    scannerStopped = true;

    document.getElementById("result").innerText =
        "QR détecté : " + decodedText;

    fetch("/bo/scanner/emprunter", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            exemplaire_id: decodedText
        })
    })
    .then(res => res.json())
    .then(data => {

        if(data.success){
            showToast("📖 Livre emprunté !");
        } else {
            showToast(data.error, true);
        }

        // 🔄 relancer scan après 3s
        setTimeout(() => {
            scannerStopped = false;
        }, 3000);

    })
    .catch(err => {
        console.error(err);
        showToast("Erreur serveur", true);
        scannerStopped = false;
    });
}

const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess);

</script>

</body>
</html>