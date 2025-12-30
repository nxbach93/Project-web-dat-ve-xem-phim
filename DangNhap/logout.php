<?php
session_start();

// Xóa toàn bộ session
session_unset();
session_destroy();

// Quay về trang chủ
<<<<<<< HEAD
header("Location: formTrangChu.php");
=======
header("Location: ../TrangChu/formTrangChu.php");
>>>>>>> origin/Form_TinTucVaUuDai
exit;
