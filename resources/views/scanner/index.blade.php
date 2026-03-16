<h1>Scanner un livre</h1>

<div id="reader" style="width:400px"></div>

<p id="result"></p>

<!-- Librairie pour scanner le QR code -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>

function onScanSuccess(decodedText) {

    document.getElementById("result").innerText =
        "QR Code détecté : " + decodedText;

    fetch("/scanner/emprunter", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            exemplaire_id: decodedText
        })

    })
    .then(response => response.json())
    .then(data => {

        if(data.success){
            alert("Livre emprunté avec succès");
        }else{
            alert(data.error);
        }

    });

}

const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess);

</script>