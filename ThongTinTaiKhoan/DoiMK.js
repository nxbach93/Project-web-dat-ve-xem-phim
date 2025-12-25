document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const oldPass = document.getElementById('old_password');
    const newPass = document.getElementById('new_password');
    const confirmPass = document.getElementById('confirm_password');

    if (form) {
        form.addEventListener('submit', function (e) {
        const vOld = oldPass.value.trim();
        const vNew = newPass.value.trim();
        const vConfirm = confirmPass.value.trim();

        // 1. Kiểm tra độ dài mật khẩu mới (8 - 20 ký tự)
        if (vNew.length < 8 || vNew.length > 20) {
            alert("Mật khẩu mới phải có độ dài từ 8 đến 20 ký tự!");
            newPass.focus();
                e.preventDefault(); // Chỉ chặn khi có lỗi
            return;
        }

        // 2. Mật khẩu mới phải khác mật khẩu cũ
        if (vNew === vOld) {
            alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
            newPass.focus();
                e.preventDefault();
            return;
        }

        // 3. Xác nhận mật khẩu mới phải giống mật khẩu mới
        if (vConfirm !== vNew) {
            alert("Xác nhận mật khẩu mới không khớp!");
            confirmPass.focus();
                e.preventDefault();
            return;
        }
            
            // Nếu không có lỗi, form sẽ tự động submit sang process-change-password.php
        });
    }
});