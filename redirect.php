<?php
// redirect.php – Controller trung tâm

//================= Kết nối DB + load Model ==============================================
// Load file cấu hình & kết nối CSDL
require './controllers/config.php';
require './models/Lop.php';
require './models/SinhVien.php';

// Khởi tạo Model
$lopModel = new Lop($pdo);
$svModel  = new SinhVien($pdo);


//================= XỬ LÝ THEO ACTION ====================================================
// Xác định action từ URL (?action=...)
$action = $_GET['action'] ?? 'list';

// Header chung
include './views/header.php';

/* ====== DANH SÁCH SINH VIÊN ====== */
if($action === 'list'){
    $q = $_GET['q'] ?? ''; // tìm kiếm
    $filterMalop = ($_GET['malop'] ?? '') !== '' ? $_GET['malop'] : null;

    // Phân trang
    $page   = max(1, (int)($_GET['page'] ?? 1));
    $limit  = 5;
    $offset = ($page - 1) * $limit;

    $total       = $svModel->count($q, $filterMalop);
    $totalPages  = max(1, ceil($total / $limit));
    $students    = $svModel->getAll($limit, $offset, $q, $filterMalop);
    $lops        = $lopModel->all();

    include './views/list.php';
}

/* ====== THÊM SINH VIÊN ====== */
elseif($action === 'add'){
    $lops = $lopModel->all();
    $errors = [];
    $old = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $old = $_POST;

        // Validate đơn giản
        if(empty($_POST['masv']) || empty($_POST['tensv']) || empty($_POST['malop'])){
            $errors[] = "Vui lòng nhập tất cả các trường bắt buộc.";
        } else {
            try {
                // Thêm sinh viên mới
                $svModel->create([
                    'masv'  => (int)$_POST['masv'],
                    'tensv' => $_POST['tensv'],
                    'malop' => (int)$_POST['malop'],
                    'sdt'   => $_POST['sdt'] ?? ''
                ]);
                header("Location: redirect.php"); // quay về list
                exit;
            } catch(PDOException $e){
                $errors[] = "Lỗi khi lưu: ".$e->getMessage();
            }
        }
    }
    include './views/add.php';
}

/* ====== SỬA SINH VIÊN ====== */
elseif($action === 'edit'){
    $masv = $_GET['masv'] ?? null;
    if(!$masv){ echo "Không có mã sinh viên"; include 'views/footer.php'; exit; }

    $student = $svModel->find($masv);
    if(!$student){ echo "Không tìm thấy sinh viên"; include 'views/footer.php'; exit; }

    $lops = $lopModel->all();
    $errors = [];
    $old = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $old = $_POST;

        if(empty($_POST['tensv']) || empty($_POST['malop'])){
            $errors[] = "Vui lòng nhập đầy đủ.";
        } else {
            try {
                $svModel->update($masv, [
                    'tensv' => $_POST['tensv'],
                    'malop' => (int)$_POST['malop'],
                    'sdt'   => $_POST['sdt'] ?? ''
                ]);
                header("Location: redirect.php");
                exit;
            } catch(PDOException $e){
                $errors[] = "Lỗi: ".$e->getMessage();
            }
        }
    }
    include './views/edit.php';
}

/* ====== XÓA SINH VIÊN ====== */
elseif($action === 'delete'){
    if($masv = ($_GET['masv'] ?? null)){
        try {
            $svModel->delete($masv);
        } catch(PDOException $e){
            echo "Lỗi xóa: ".$e->getMessage();
        }
    }
    header("Location: redirect.php");
    exit;
}

/* ====== ACTION KHÔNG HỢP LỆ ====== */
else {
    echo "<div class='alert alert-warning'>Action không hợp lệ</div>";
}

// Footer chung
include './views/footer.php';
