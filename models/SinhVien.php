<?php
// models/SinhVien.php
class SinhVien {
    private $pdo; // Kết nối CSDL (PDO)

    // Nhận PDO từ Controller
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Đếm số sinh viên (phục vụ phân trang), có thể tìm theo tên và lọc theo lớp
    public function count($q = null, $malop = null){
        $sql = "SELECT COUNT(*)
                FROM sinhvien s
                JOIN lophoc l ON s.malop = l.malop
                WHERE 1";
        $params = [];

        if ($q) { // tìm theo tên
            $sql .= " AND s.tensv LIKE ?";
            $params[] = "%$q%";
        }

        if ($malop) { // lọc theo lớp
            $sql .= " AND s.malop = ?";
            $params[] = $malop;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn(); // trả về số lượng
    }

    // Lấy danh sách sinh viên có phân trang + tìm kiếm + lọc lớp
    public function getAll($limit, $offset, $q = null, $malop = null){
        $limit  = (int)$limit;   // ép kiểu để an toàn
        $offset = (int)$offset;

        $sql = "SELECT s.*, l.tenlop
                FROM sinhvien s
                JOIN lophoc l ON s.malop = l.malop
                WHERE 1";
        $params = [];

        if ($q) {
            $sql .= " AND s.tensv LIKE ?";
            $params[] = "%$q%";
        }

        if ($malop) {
            $sql .= " AND s.malop = ?";
            $params[] = $malop;
        }

        // Phân trang (LIMIT / OFFSET)
        $sql .= " ORDER BY s.masv ASC LIMIT $limit OFFSET $offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // danh sách sinh viên
    }

    // Lấy 1 sinh viên theo mã
    public function find($masv){
        $stmt = $this->pdo->prepare(
            "SELECT * FROM sinhvien WHERE masv = ?"
        );
        $stmt->execute([$masv]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sinh viên mới
    public function create($data){
        $stmt = $this->pdo->prepare(
            "INSERT INTO sinhvien (masv, tensv, malop, sdt)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['masv'],
            $data['tensv'],
            $data['malop'],
            $data['sdt']
        ]);
    }

    // Cập nhật sinh viên
    public function update($masv, $data){
        $stmt = $this->pdo->prepare(
            "UPDATE sinhvien
             SET tensv = ?, malop = ?, sdt = ?
             WHERE masv = ?"
        );
        return $stmt->execute([
            $data['tensv'],
            $data['malop'],
            $data['sdt'],
            $masv
        ]);
    }

    // Xóa sinh viên
    public function delete($masv){
        $stmt = $this->pdo->prepare(
            "DELETE FROM sinhvien WHERE masv = ?"
        );
        return $stmt->execute([$masv]);
    }
}
