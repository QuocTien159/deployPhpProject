<!-- index.php - Trang đăng nhập Google -->
<?php
// Load thư viện Google API
require_once __DIR__ . '/vendor/autoload.php'; 

// Tạo đối tượng Google Client
$client = new Google\Client;

// Cấu hình thông tin ứng dụng
$client->setClientId("848720371076-s9hhtafsfm0cbbblfrovjc6kg8pvqg3f.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://studentapp.infinityfreeapp.com/redirect.php");

// Yêu cầu quyền truy cập email và profile
$client->addScope("email");
$client->addScope("profile");

// Tạo URL đăng nhập
$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4 text-center">

        
                <h1 class="fw-bold text-primary mb-2">
                     Website quản lý sinh viên
                </h1>

                <h2 class="fs-6 text-muted mb-4">
                 Thực hành lập trình web – Thứ ba ca 3
                </h2>

                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4 text-center">

                        <h4 class="fw-bold mb-2 text-primary">Đăng nhập</h4>
                        <p class="text-muted mb-4">Sử dụng tài khoản Google</p>

                        <a href="<?= $url ?>" 
                          class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3">
                            <img src="https://developers.google.com/identity/images/g-logo.png"
                                 width="20" class="bg-white rounded p-1">
                           <span class="fw-semibold">Đăng nhập bằng Google</span>
                        </a>
                        
                   </div>
               </div>
            </div>
        </div>
    </div>
</body>
</html>

