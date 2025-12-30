document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input, select');

    // 1. Khi nhấn nút Cập nhật
    editBtn.addEventListener('click', () => {
        // Gỡ bỏ disabled để người dùng có thể sửa và gửi được dữ liệu qua POST
        inputs.forEach(input => {
            input.disabled = false;
        });

        // Chuyển trạng thái hiển thị nút
        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';

        // Tự động focus vào ô đầu tiên để người dùng nhập ngay
        inputs[0].focus();
    });

    // 2. Khi nhấn nút Lưu (Sự kiện submit)
    form.addEventListener('submit', (e) => {
        // Có thể thực hiện kiểm tra dữ liệu nhanh tại đây (nếu cần)
        const fullname = form.querySelector('[name="fullname"]').value.trim();
        
        if (fullname === "") {
            alert("Vui lòng không để trống Họ và tên!");
            e.preventDefault(); // Chặn gửi form nếu lỗi
            return;
        }

        // Lưu ý: Không dùng e.preventDefault() hoàn toàn để dữ liệu được gửi về server
        console.log("Đang gửi dữ liệu cập nhật...");
    });
});