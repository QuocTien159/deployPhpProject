<?php
// views/list.php
// $students     : danh sách sinh viên hiện tại
// $lops         : danh sách lớp (dùng cho filter)
// $page         : trang hiện tại
// $totalPages  : tổng số trang
// $q            : từ khóa tìm kiếm
// $filterMalop  : mã lớp đang lọc
?>

<!-- Tiêu đề + nút thêm -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Danh sách sinh viên</h3>
  <a href="redirect.php?action=add" class="btn btn-success">
    <i class="bi bi-plus-lg"></i> Thêm sinh viên
  </a>
</div>

<!-- Form tìm kiếm + lọc -->
<form class="row g-2 mb-3" method="get" action="redirect.php">
  <input type="hidden" name="action" value="list">

  <!-- Tìm theo tên -->
  <div class="col-md-5">
    <input type="text" class="form-control"
           name="q" placeholder="Tìm theo tên..."
           value="<?= htmlspecialchars($q) ?>">
  </div>

  <!-- Lọc theo lớp -->
  <div class="col-md-3">
    <select name="malop" class="form-select">
      <option value="">-- Tất cả lớp --</option>
      <?php foreach($lops as $lop): ?>
        <option value="<?=$lop['malop']?>"
          <?= ($filterMalop === $lop['malop']) ? 'selected' : '' ?>>
          <?=$lop['tenlop']?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-2">
    <button class="btn btn-primary w-100">Lọc</button>
  </div>
</form>

<!-- Bảng sinh viên -->
<table class="table table-striped table-bordered table-hover bg-white">
  <thead>
    <tr>
      <th>STT</th>
      <th>Mã SV</th>
      <th>Họ và tên</th>
      <th>Lớp</th>
      <th>SĐT</th>
      <th>Hành động</th>
    </tr>
  </thead>

  <tbody>
    <?php if (count($students) === 0): ?>
      <tr>
        <td colspan="6" class="text-center">Không có dữ liệu</td>
      </tr>
    <?php endif; ?>

    <?php
      // Tính số thứ tự theo trang
      $stt = ($page - 1) * 5 + 1;
      foreach ($students as $sv):
    ?>
    <tr>
      <td><?=$stt++?></td>
      <td><?=$sv['masv']?></td>
      <td><?= htmlspecialchars($sv['tensv']) ?></td>
      <td><?= htmlspecialchars($sv['tenlop']) ?></td>
      <td><?= htmlspecialchars($sv['sdt']) ?></td>
      <td>
        <!-- Icon sửa -->
        <a class="btn btn-sm btn-primary"
           href="redirect.php?action=edit&masv=<?=$sv['masv']?>">
           <i class="bi bi-pencil"></i>
        </a>

        <!-- Icon xóa -->
        <a class="btn btn-sm btn-danger"
           href="redirect.php?action=delete&masv=<?=$sv['masv']?>"
           onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">
           <i class="bi bi-trash"></i>
        </a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Phân trang -->
<nav>
  <ul class="pagination">
    <?php for($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link"
           href="redirect.php?action=list&page=<?=$i?>
           <?= $q ? '&q='.urlencode($q) : '' ?>
           <?= $filterMalop ? '&malop='.urlencode($filterMalop) : '' ?>">
           <?=$i?>
        </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
