document.addEventListener("DOMContentLoaded", function () {
    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn");
    const form = document.getElementById("profileForm");

    if (editBtn && form) {
        editBtn.addEventListener("click", function () {
            // Bật chỉnh sửa input (xóa readonly)
            form.querySelectorAll("input").forEach(input => {
                input.removeAttribute("readonly");
            });

            // Bật chỉnh sửa select (xóa disabled)
            form.querySelectorAll("select").forEach(select => {
                select.disabled = false;
            });

            saveBtn.style.display = "inline-block";
            editBtn.style.display = "none";
        });
    }
});