document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input, select');

    //Khi nhấn nút Chỉnh sửa
    editBtn.addEventListener('click', () => {
        // Mở khóa các ô input
        inputs.forEach(input => {
            input.disabled = false;
        });
        // Đổi trạng thái nút
        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
        // Focus vào ô đầu tiên
        inputs[0].focus();
    });

    //Khi nhấn Lưu (Submit form)
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Thông tin của bạn đã được cập nhật thành công!');
        inputs.forEach(input => {
            input.disabled = true;
        });

        editBtn.style.display = 'inline-block';
        saveBtn.style.display = 'none';

        const newName = form.querySelector('[name="fullname"]').value;
        document.getElementById('displayName').innerText = newName;
        document.getElementById('avatarText').innerText = newName.charAt(0).toUpperCase();
    });
});