document.addEventListener('DOMContentLoaded', () => {
    // Tìm tất cả các form đổi mật khẩu dựa trên cấu trúc chung
    const passwordForm = document.querySelector('.password-card form');

    if (!passwordForm) return;

    passwordForm.addEventListener('submit', function (e) {
        // Lấy giá trị từ các ô input
        const oldPass = this.querySelector('input[name="old_password"]').value;
        const newPass = this.querySelector('input[name="new_password"]').value;
        const confirmPass = this.querySelector('input[name="confirm_password"]').value;

        // 1. Kiểm tra độ dài mật khẩu mới (Ví dụ: tối thiểu 6 ký tự)
        if (newPass.length < 6) {
            alert("Mật khẩu mới phải có ít nhất 6 ký tự!");
            e.preventDefault(); // Ngăn gửi form
            return;
        }

        // 2. Kiểm tra mật khẩu mới có trùng mật khẩu cũ không
        if (newPass === oldPass) {
            alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
            e.preventDefault();
            return;
        }

        // 3. Kiểm tra xác nhận mật khẩu khớp nhau
        if (newPass !== confirmPass) {
            alert("Xác nhận mật khẩu mới không khớp!");
            e.preventDefault();
            return;
        }

        // Nếu mọi thứ ổn, thông báo đang xử lý
        console.log("Dữ liệu hợp lệ, đang gửi yêu cầu đổi mật khẩu...");
    });
});