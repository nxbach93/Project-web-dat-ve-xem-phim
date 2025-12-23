function toggleRap() {
  const m = document.getElementById("rapMenu");
  m.style.display = m.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", (e) => {
  if (!e.target.closest(".beta-rap-select")) {
    document.getElementById("rapMenu").style.display = "none";
  }
});

function openModal(ten, poster, rap, ngay, gio, ghe) {
  document.getElementById("modal").style.display = "flex";
  document.getElementById("modal-ten").innerText = ten;
  document.getElementById("modal-poster").src = "/Mua_Ve_Di/poster/" + poster;
  document.getElementById("modal-rap").innerText = "Rạp: " + rap;
  document.getElementById("modal-ngay").innerText = "Ngày: " + ngay;
  document.getElementById("modal-gio").innerText = "Giờ: " + gio;
  document.getElementById("modal-ghe").innerText = "Số ghế trống: " + ghe;

  document.getElementById("modal-continue").href =
    "chonghe.php?phim=" +
    encodeURIComponent(ten) +
    "&rap=" +
    encodeURIComponent(rap) +
    "&ngay=" +
    encodeURIComponent(ngay) +
    "&gio=" +
    encodeURIComponent(gio);
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
}
