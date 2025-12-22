<?php
// views/edit.php
// $lops    : danh sách lớp (đổ vào select)
// $student : dữ liệu sinh viên hiện tại
// $errors  : mảng lỗi (nếu submit sai)
// $old     : dữ liệu mới nhập khi submit lỗi
?>
<h3>Chỉnh sửa sinh viên</h3>

<?php if(!empty($errors)): ?>
  <!-- Hiển thị lỗi validate -->
  <div class="alert alert-danger">
    <?= implode('<br>', $errors) ?>
  </div>
<?php endif; ?>

<!-- Form gửi POST, kèm masv trên URL -->
<form method="post" action="redirect.php?action=edit&masv=<?=$student['masv']?>">

  <!-- Mã SV: chỉ hiển thị, không cho sửa -->
  <div class="mb-3">
    <label class="form-label">Mã số sinh viên</label>
    <input type="number" class="form-control"
           value="<?=$student['masv']?>" readonly>
  </div>

  <!-- Tên SV -->
  <div class="mb-3">
    <label class="form-label">Họ và tên</label>
    <input type="text" name="tensv" class="form-control" required
           value="<?= htmlspecialchars($old['tensv'] ?? $student['tensv']) ?>">
  </div>

  <!-- Chọn lớp (ưu tiên giá trị mới nếu có lỗi) -->
  <div class="mb-3">
    <label class="form-label">Lớp học</label>
    <select name="malop" class="form-select" required>
      <?php foreach($lops as $lop): ?>
        <option value="<?=$lop['malop']?>"
          <?= ((isset($old['malop']) ? $old['malop'] : $student['malop']) == $lop['malop'])
             ? 'selected' : '' ?>>
          <?=$lop['tenlop']?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- SĐT -->
  <div class="mb-3">
    <label class="form-label">Số điện thoại</label>
    <input type="text" name="sdt" class="form-control"
           value="<?= htmlspecialchars($old['sdt'] ?? $student['sdt']) ?>">
  </div>

  <!-- Nút -->
  <button type="submit" class="btn btn-primary">Lưu</button>
  <a href="redirect.php" class="btn btn-secondary">Hủy</a>
</form>
