<h2 style="text-align:center;">🔐 Vérification 2FA</h2>

<p style="text-align:center;">Un code a été envoyé à votre email 📧</p>

@if(session('code'))
    <p style="text-align:center;">Code (test) : {{ session('code') }}</p>
@endif
<p id="error-message" style="color:red; text-align:center;"></p>
<div id="success-check" style="display:none; text-align:center; font-size:40px; color:green;">
    ✅
</div>
<form method="POST" action="/2fa" style="text-align:center;">
    @csrf

    <div class="code-container">

        <input type="text" maxlength="1" class="code-box">
        <input type="text" maxlength="1" class="code-box">
        <input type="text" maxlength="1" class="code-box">
        <input type="text" maxlength="1" class="code-box">
        <input type="text" maxlength="1" class="code-box">
        <input type="text" maxlength="1" class="code-box">

    </div>

    <input type="hidden" name="code" id="full-code">

    <button type="submit" class="btn-login" id="btn-verify">
    ✔️ Vérifier
</button>
</form>
@if(session('error'))
    <script>
        window.onload = function() {
            showError();
        }
    </script>
@endif
<script>

const inputs = document.querySelectorAll(".code-box");
const hiddenInput = document.getElementById("full-code");

inputs.forEach((input, index) => {

    input.addEventListener("input", () => {

        if (input.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        updateCode();
    });

    input.addEventListener("keydown", (e) => {

        if (e.key === "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });

});

function updateCode() {
    let code = "";
    inputs.forEach(input => code += input.value);
    hiddenInput.value = code;
}
function showError() {

    const container = document.querySelector(".code-container");
    const errorText = document.getElementById("error-message");

    // Animation
    container.classList.add("shake");

    // Message
    errorText.innerHTML = "❌ Code incorrect";

    // Reset inputs
    inputs.forEach(input => input.value = "");

    // Reset code caché
    hiddenInput.value = "";

    // Focus premier champ
    inputs[0].focus();

    // enlever animation après
    setTimeout(() => {
        container.classList.remove("shake");
    }, 400);
}
function showSuccess() {

    const check = document.getElementById("success-check");
    const form = document.querySelector("form");
    const button = document.getElementById("btn-verify");

    // cacher form
    form.style.display = "none";

    // afficher check
    check.style.display = "block";
    check.classList.add("success-anim");

    // redirection après animation
    setTimeout(() => {
        window.location.href = "/dashboard";
    }, 1200);
}
</script>