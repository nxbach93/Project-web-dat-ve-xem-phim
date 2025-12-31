
document.addEventListener('DOMContentLoaded', function () {
    const totalTime = 10 * 60; // 10 phút
    const display = document.querySelector('#countdown');

    let timeLeft = sessionStorage.getItem('bookingTimeLeft');

    if (!timeLeft) {
        timeLeft = totalTime;
    } else {
        timeLeft = parseInt(timeLeft);
    }

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        if (display) display.textContent = minutes + ":" + seconds;

        sessionStorage.setItem('bookingTimeLeft', timeLeft);

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            sessionStorage.removeItem('bookingTimeLeft');
            alert("Hết thời gian giữ vé! Vui lòng đặt lại.");
            window.location.href = "../LichChieu/Form_LichChieu.php"; 
        }
        timeLeft--;
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);
});


function updateQty(btn, change, price) {
    let container = btn.parentElement;
    let input = container.querySelector('.qty-input');
    let currentQty = parseInt(input.value);
    let newQty = currentQty + change;

    if (newQty >= 0) {
        input.value = newQty;
        recalculateTotal();
    }
}

function recalculateTotal() {
    let totalCombo = 0;
    
    const inputs = document.querySelectorAll('.qty-input');
    const rows = document.querySelectorAll('.combo-table tbody tr');

    rows.forEach(row => {
        let input = row.querySelector('.qty-input');
        if(input) {
            let qty = parseInt(input.value);
            
            let btnPlus = row.querySelector('.quantity-control button:last-child');
            let onClickText = btnPlus.getAttribute('onclick');
            let price = parseInt(onClickText.split(',')[2]);
            
            totalCombo += qty * price;
        }
    });

    let finalTotal = BASE_PRICE + totalCombo;

    document.getElementById('view_combo').innerText = totalCombo.toLocaleString('vi-VN') + " đ";
    document.getElementById('view_total').innerText = finalTotal.toLocaleString('vi-VN') + " đ";

    document.getElementById('input_tien_combo').value = totalCombo;
    document.getElementById('input_tong_cong').value = finalTotal;
}