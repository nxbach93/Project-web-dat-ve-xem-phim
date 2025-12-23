document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const oldPass = document.getElementById('old_password');
    const newPass = document.getElementById('new_password');
    const confirmPass = document.getElementById('confirm_password');

    form.addEventListener('submit', function (e) {
        // Ngăn form gửi đi ngay lập tức để kiểm tra lỗi
        e.preventDefault();

        const vOld = oldPass.value.trim();
        const vNew = newPass.value.trim();
        const vConfirm = confirmPass.value.trim();

        // 1. Kiểm tra độ dài mật khẩu mới (8 - 20 ký tự)
        if (vNew.length < 8 || vNew.length > 20) {
            alert("Mật khẩu mới phải có độ dài từ 8 đến 20 ký tự!");
            newPass.focus();
            return;
        }

        // 2. Mật khẩu mới phải khác mật khẩu cũ
        if (vNew === vOld) {
            alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
            newPass.focus();
            return;
        }

        // 3. Xác nhận mật khẩu mới phải giống mật khẩu mới
        if (vConfirm !== vNew) {
            alert("Xác nhận mật khẩu mới không khớp!");
            confirmPass.focus();
            return;
        }

        // Nếu mọi thứ ok -> Hiển thị thông báo thành công
        alert("Thay đổi mật khẩu thành công!");

        // 4. Xóa trắng 3 ô nhập liệu
        form.reset();

        // 5. Load lại trang
        window.location.reload();
    });
});