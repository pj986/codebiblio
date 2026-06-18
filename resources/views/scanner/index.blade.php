@extends('layouts.app')

@section('content')

<h1 style="text-align:center;">📷 Scanner QR Code</h1>

<!-- 🔥 BOUTONS MODE -->
<div style="text-align:center; margin-bottom:20px;">
    <button onclick="setMode('emprunt')" class="btn">📖 Mode Emprunt</button>
    <button onclick="setMode('retour')" class="btn">🔁 Mode Retour</button>
</div>
<div id="preview" style="text-align:center; margin-top:20px; display:none;">

    <img id="previewImg" style="width:120px; border-radius:10px;"><br>

    <h3 id="previewTitle"></h3>
    <p id="previewAuthor"></p>

    <button onclick="confirmerAction()" class="btn">
        ✅ Confirmer
    </button>

</div>

<div style="display:flex; justify-content:center;">
    <div id="reader" style="width:300px;"></div>

</div>
<div id="scanFlash"></div>

@endsection

@section('scripts')

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function onScanSuccess(decodedText) {

    console.log("QR:", decodedText);

    let url = mode === "emprunt"
        ? '/scanner/emprunter'
        : '/scanner/retour';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            livre_id: decodedText
        })
    })
    .then(res => res.json())
    .then(data => {

        showToast(data.message);

        if (data.retard) {
            showToast(data.retard);
        }

        if (data.success && mode === "emprunt") {
            setTimeout(() => {
                window.location.href = "/mes-emprunts";
            }, 1500);
        }
    });
}

let scanner = new Html5Qrcode("reader");

scanner.start(
    { facingMode: "environment" },
    {
        fps: 10,
        qrbox: 250
    },
    onScanSuccess
);
let mode = "emprunt"; // mode par défaut
function setMode(newMode) {
    mode = newMode;

    showToast(
        mode === "emprunt"
        ? "📖 Mode Emprunt activé"
        : "🔁 Mode Retour activé"
    );
}
let scannedLivreId = null;

function onScanSuccess(decodedText) {
    playScanEffect();

    scannedLivreId = decodedText;

    fetch('/livre/' + decodedText)
    .then(res => res.json())
    .then(livre => {

        document.getElementById('previewImg').src = '/images/' + livre.couverture;
        document.getElementById('previewTitle').innerText = livre.titre;
        document.getElementById('previewAuthor').innerText = livre.auteur;

        document.getElementById('preview').style.display = 'block';
    });
    function confirmerAction() {

    let url = mode === "emprunt"
        ? '/scanner/emprunter'
        : '/scanner/retour';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            livre_id: scannedLivreId
        })
    })
    .then(res => res.json())
    .then(data => {

        showToast(data.message);

        document.getElementById('preview').style.display = 'none';

        if (data.success && mode === "emprunt") {
            setTimeout(() => {
                window.location.href = "/mes-emprunts";
            }, 1500);
        }
    });
}
function playScanEffect() {

    // 🔥 FLASH
    const flash = document.getElementById("scanFlash");
    flash.classList.add("flash-active");

    setTimeout(() => {
        flash.classList.remove("flash-active");
    }, 300);

    // 📳 VIBRATION (mobile)
    if (navigator.vibrate) {
        navigator.vibrate(200);
    }

    let beep = new Audio('/sounds/beep.mp3');
    beep.play();
}
}
</script>

@endsection