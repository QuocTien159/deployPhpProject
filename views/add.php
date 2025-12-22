<?php
// views/add.php
// $lops   : danh sách lớp (đổ vào select)
// $errors : mảng lỗi validate (nếu có)
// $old    : dữ liệu cũ để giữ lại khi submit lỗi
?>
<h3>Thêm sinh viên</h3>

<?php if(!empty($errors)): ?>
  <!-- Hiển thị danh sách lỗi -->
  <div class="alert alert-danger">
    <?= implode('<br>', $errors) ?>
  </div>
<?php endif; ?>

<!-- Form gửi dữ liệu bằng POST -->
<form method="post" action="redirect.php?action=add">

  <!-- Mã sinh viên -->
  <div class="mb-3">
    <label class="form-label">Mã số sinh viên</label>
    <input type="number" name="masv"
           class="form-control" required
           value="<?= htmlspecialchars($old['masv'] ?? '') ?>">
  </div>

  <!-- Tên sinh viên -->
  <div class="mb-3">
    <label class="form-label">Họ và tên</label>
    <input type="text" name="tensv"
           class="form-control" required
           value="<?= htmlspecialchars($old['tensv'] ?? '') ?>">
  </div>

  <!-- Chọn lớp -->
  <div class="mb-3">
    <label class="form-label">Lớp học</label>
    <select name="malop" class="form-select" required>
      <?php foreach($lops as $lop): ?>
        <option value="<?=$lop['malop']?>"
          <?= (isset($old['malop']) && $old['malop']==$lop['malop']) ? 'selected' : '' ?>>
          <?=$lop['tenlop']?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Số điện thoại -->
  <div class="mb-3">
    <label class="form-label">Số điện thoại</label>
    <input type="text" name="sdt"
           class="form-control"
           value="<?= htmlspecialchars($old['sdt'] ?? '') ?>">
  </div>

  <!-- Nút hành động -->
  <button type="submit" class="btn btn-success">Xác nhận</button>
  <a href="redirect.php" class="btn btn-secondary">Hủy</a>
</form>
