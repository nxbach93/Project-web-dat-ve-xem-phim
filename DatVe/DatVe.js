document.addEventListener('DOMContentLoaded', function () {
    // 1. Thiết lập thời gian đếm ngược (đơn vị: giây)
    const totalTime = 10 * 60; // 10 phút = 600 giây
    const display = document.querySelector('#countdown'); // ID của thẻ hiển thị thời gian

    // 2. Kiểm tra nếu đã có thời gian trong session (phòng trường hợp F5 trang)
    let timeLeft = sessionStorage.getItem('timeLeft') 
                   ? parseInt(sessionStorage.getItem('timeLeft')) 
                   : totalTime;

    const timerInterval = setInterval(function () {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        // Định dạng hiển thị 00:00
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        // Lưu thời gian hiện tại vào session
        sessionStorage.setItem('timeLeft', timeLeft);

        // 3. Xử lý khi hết giờ
        if (--timeLeft < 0) {
            clearInterval(timerInterval);
            sessionStorage.removeItem('timeLeft'); // Xóa thời gian đã lưu
            
            alert("Hết thời gian giữ ghế! Bạn sẽ quay lại trang chọn phim.");
            
            // Quay lại trang trước (form trước khi đặt vé)
            window.history.back(); 
            // Hoặc chuyển hướng cụ thể: window.location.href = 'trang_chu.php';
        }
    }, 1000);
});