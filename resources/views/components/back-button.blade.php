<button onclick="goBack()" class="back-btn">
    ⬅
</button>

<style>
.back-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 9999;

    width: 45px;
    height: 45px;

    border-radius: 50%;
    border: none;

    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);

    color: #333;
    font-size: 18px;
    cursor: pointer;

    box-shadow: 0 8px 25px rgba(0,0,0,0.2);

    transition: all 0.2s ease;
}

.back-btn:hover {
    transform: scale(1.1);
    background: rgba(255,255,255,0.4);
}

.back-btn:active {
    transform: scale(0.95);
}
</style>

<script>
function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "/";
    }
}
</script>