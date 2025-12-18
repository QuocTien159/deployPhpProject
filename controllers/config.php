<!-- Cấu hình CSDL bằng PDO -->
<?php
// config.php

// Thông tin kết nối CSDL (local host)
define('DB_HOST','127.0.0.1'); // địa chỉ server MySQL
define('DB_NAME','qlsv');      // tên database
define('DB_USER','root');      // tài khoản
define('DB_PASS','');          // mật khẩu

// Thay bằng thông tin từ InfinityFree Control Panel
// define('DB_HOST', 'sql100.infinityfree.com'); // ví dụ: lấy chính xác từ control panel
// define('DB_NAME', 'if0_40710021_qlsv'); // tên DB do control panel tạo
// define('DB_USER', 'if0_40710021'); // user DB
// define('DB_PASS', 'Pv4ZPZG9zXfh'); // mật khẩu DB

try {
    // Tạo kết nối PDO tới MySQL
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";
        charset=utf8mb4",
        DB_USER,
        DB_PASS
    );

    // Bật chế độ báo lỗi bằng Exception (dễ debug)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    // Nếu kết nối lỗi → dừng chương trình và báo lỗi
    die("Kết nối DB lỗi: " . $e->getMessage());
}

