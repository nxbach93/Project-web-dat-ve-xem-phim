document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.btn-open-modal');
    
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const ten = this.getAttribute('data-ten');
            const poster = this.getAttribute('data-poster');
            const rap = this.getAttribute('data-rap');
            const ngay = this.getAttribute('data-ngay');
            const gio = this.getAttribute('data-gio');
            const ghe = this.getAttribute('data-ghe');
            const idlc = this.getAttribute('data-idlc');

            openModal(ten, poster, rap, ngay, gio, ghe, idlc);
        });
    });
});

function openModal(ten, poster, rap, ngay, gio, ghe, idlc) {
    const modal = document.getElementById("modal");
    modal.style.display = "flex";
    
    document.getElementById("modal-ten").innerText = ten;
    document.getElementById("modal-poster").src = "../images/movie/" + poster;
    document.getElementById("modal-rap").innerText = "Rạp: " + rap;
    document.getElementById("modal-ngay").innerText = "Ngày: " + ngay;
    document.getElementById("modal-gio").innerText = "Giờ: " + gio;
    document.getElementById("modal-ghe").innerText = "Còn trống: " + ghe;


    const btnContinue = document.getElementById("modal-continue");
    if (idlc) {
        btnContinue.href = "../DatVe/DatVeb1.php?idlc=" + idlc;
        btnContinue.style.pointerEvents = "auto";
        btnContinue.style.opacity = "1";
    } else {
        btnContinue.href = "#";
        btnContinue.style.pointerEvents = "none";
        btnContinue.style.opacity = "0.5";
        alert("Lỗi: Không tìm thấy mã lịch chiếu!");
    }
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}


window.onclick = function(event) {
    const modal = document.getElementById("modal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function toggleRap() {
    const m = document.getElementById("rapMenu");
    if(m) m.style.display = m.style.display === "block" ? "none" : "block";
}