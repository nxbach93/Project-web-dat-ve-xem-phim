document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const profileForm = document.getElementById('profileForm');

    if (!editBtn || !profileForm) return;

    // 1. Khi bấm Cập nhật
    editBtn.addEventListener('click', function() {
        const inputs = profileForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.removeAttribute('disabled');
            input.removeAttribute('readonly');
            input.style.border = "1px solid #007bff";
        });

        this.style.display = 'none';
        if (saveBtn) saveBtn.style.display = 'inline-block';
    });

    // 2. Khi gửi Form (Lưu)
    profileForm.addEventListener('submit', function() {
        // Thay đổi nội dung nút để người dùng biết đang xử lý
        if (saveBtn) {
            saveBtn.innerHTML = "Đang lưu...";
            saveBtn.style.opacity = "0.7";
        }
    });
});