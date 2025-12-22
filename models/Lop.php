<?php
// models/Lop.php
class Lop {
    private $pdo; // Biến lưu kết nối CSDL (PDO)

    // Hàm khởi tạo, nhận PDO từ bên ngoài (Controller truyền vào)
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Lấy tất cả lớp học, sắp xếp theo mã lớp
    public function all(){
        $stmt = $this->pdo->query(
            "SELECT * FROM lophoc ORDER BY malop"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng các dòng
    }

    // Lấy thông tin 1 lớp theo mã lớp
    public function find($malop){
        $stmt = $this->pdo->prepare(
            "SELECT * FROM lophoc WHERE malop = ?"
        );
        $stmt->execute([$malop]); // Truyền giá trị vào dấu ?
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 dòng
    }
}
