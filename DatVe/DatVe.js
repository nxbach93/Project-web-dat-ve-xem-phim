
document.addEventListener('DOMContentLoaded', function () {

    const totalTime = 10 * 60; // 10 phút
    const display = document.querySelector('#countdown'); 

    let timeLeft = sessionStorage.getItem('bookingTimeLeft');
    if (!timeLeft) timeLeft = totalTime;

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
            alert("Hết thời gian giữ ghế! Trang sẽ tải lại.");
            window.location.reload(); 
        }
        timeLeft--;
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);


    const container = document.querySelector('.seat-map');
    const displaySeats = document.getElementById('display-seats');
    const displayPrice = document.getElementById('display-price');
    const btnNext = document.getElementById('btnNext');

    const inputGheID = document.getElementById('input-ghe-id');
    const inputGheTen = document.getElementById('input-ghe-ten');
    const inputTien = document.getElementById('input-tien');

    if (container) {
        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
                e.target.classList.toggle('selected');
                updateSelectedInfo();
            }
        });
    }

    function updateSelectedInfo() {
        const selectedSeats = document.querySelectorAll('.row .seat.selected');
        const seatNames = [];
        const seatIDs = [];
        let totalPrice = 0;

        selectedSeats.forEach(seat => {
            seatNames.push(seat.getAttribute('data-name'));
            seatIDs.push(seat.getAttribute('data-id'));
            totalPrice += parseInt(seat.getAttribute('data-price'));
        });

        if (seatNames.length > 0) {
            displaySeats.innerText = seatNames.join(', ');
            btnNext.classList.add('active');
            btnNext.disabled = false; // Mở khóa nút
        } else {
            displaySeats.innerText = '---';
            btnNext.classList.remove('active');
            btnNext.disabled = true; // Khóa nút
        }

        displayPrice.innerText = totalPrice.toLocaleString('vi-VN') + ' đ';

        inputGheID.value = seatIDs.join(',');
        inputGheTen.value = seatNames.join(',');
        inputTien.value = totalPrice;
    }
});