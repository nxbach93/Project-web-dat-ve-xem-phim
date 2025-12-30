/* DatVeB2.js */

// === 1. LOGIC ĐỒNG HỒ ĐẾM NGƯỢC (Giữ thời gian từ B1) ===
document.addEventListener('DOMContentLoaded', function () {
    const totalTime = 10 * 60; // 10 phút
    const display = document.querySelector('#countdown');

    // Lấy thời gian từ SessionStorage (đã được lưu ở DatVeb1)
    let timeLeft = sessionStorage.getItem('bookingTimeLeft');

    // Nếu không có (vào thẳng trang này hoặc đã reset), lấy 10 phút
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

        // Lưu lại thời gian
        sessionStorage.setItem('bookingTimeLeft', timeLeft);

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            sessionStorage.removeItem('bookingTimeLeft');
            alert("Hết thời gian giữ vé! Vui lòng đặt lại.");
            window.location.href = "../LichChieu/Form_LichChieu.php"; // Quay về trang lịch chiếu
        }
        timeLeft--;
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);
});


// === 2. LOGIC TÍNH TIỀN COMBO & TỔNG CỘNG ===

function updateQty(btn, change, price) {
    let container = btn.parentElement;
    let input = container.querySelector('.qty-input');
    let currentQty = parseInt(input.value);
    let newQty = currentQty + change;

    // Không cho số lượng âm
    if (newQty >= 0) {
        input.value = newQty;
        recalculateTotal();
    }
}

function recalculateTotal() {
    let totalCombo = 0;
    
    // Quét tất cả các ô input số lượng
    const inputs = document.querySelectorAll('.qty-input');
    const rows = document.querySelectorAll('.combo-table tbody tr');

    rows.forEach(row => {
        // Tìm input số lượng trong dòng
        let input = row.querySelector('.qty-input');
        if(input) {
            let qty = parseInt(input.value);
            
            // Lấy giá tiền từ nút "+" (trick lấy giá từ hàm onclick)
            let btnPlus = row.querySelector('.quantity-control button:last-child');
            let onClickText = btnPlus.getAttribute('onclick'); // "updateQty(this, 1, 45000)"
            let price = parseInt(onClickText.split(',')[2]); // Lấy tham số thứ 3 là giá tiền
            
            totalCombo += qty * price;
        }
    });

    // Cập nhật giao diện
    // BASE_PRICE được định nghĩa trong file PHP
    let finalTotal = BASE_PRICE + totalCombo;

    document.getElementById('view_combo').innerText = totalCombo.toLocaleString('vi-VN') + " đ";
    document.getElementById('view_total').innerText = finalTotal.toLocaleString('vi-VN') + " đ";

    // Cập nhật Input ẩn để gửi form đi
    document.getElementById('input_tien_combo').value = totalCombo;
    document.getElementById('input_tong_cong').value = finalTotal;
}