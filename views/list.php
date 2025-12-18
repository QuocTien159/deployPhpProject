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
<div class="d-flex justify-content-between align-items-center mb-3 mt-5">
  <h3>Danh sách sinh viên</h3>
  <!-- link chuyển sang action=add -->
  <a href="index.php?action=add" class="btn btn-success">
    <i class="bi bi-plus-lg"></i> Thêm sinh viên
  </a>
</div>

<!-- Form tìm kiếm + lọc bằng GET -->
<form class="row g-2 mb-3" method="get" action="index.php">
  <!-- Khai báo để cho controller biết mình ở trang nào (list - add - edit) -->
  <input type="hidden" name="action" value="list">

  <!-- SearchBar tìm theo tên (q là tên biến GET)-->
  <div class="col-md-5">
    <input type="text" class="form-control"
           name="q" placeholder="Tìm theo tên..."
           value="<?= htmlspecialchars($q) ?>"> <!-- Giữ lại từ khóa sau khi submit -->
  </div>

  <!-- SelectBox lọc theo lớp -->
  <div class="col-md-3">
    <select name="malop" class="form-select">
      <option value="">-- Tất cả lớp --</option> <!-- Option mặc định: không lọc -->
      <!--  Duyệt danh sách lớp theo mã, để hiển thị các option trong SelectBox -->
      <?php foreach($lops as $lop): ?>
        <option value="<?=$lop['malop']?>" >
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
    <!-- Hiển thị bảng trống nếu không có sinh viên -->
    <?php if (count($students) === 0): ?>
      <tr>
        <td colspan="6" class="text-center">Không có dữ liệu</td>
      </tr>
    <?php endif; ?>

    <?php
      // Tính số thứ tự theo trang (VD: Trang 2: [2-1]*5+1 = 6 là STT đầu tiên của trang 2)
      $stt = ($page - 1) * 5 + 1;
      // duyệt danh sách sinh viên
      foreach ($students as $sv):
    ?>
    <tr>
      <td><?=$stt++?></td> <!-- Số thứ tự tự tăng -->
      <td><?=$sv['masv']?></td>
      <td><?= htmlspecialchars($sv['tensv']) ?></td>
      <td><?= htmlspecialchars($sv['tenlop']) ?></td>
      <td><?= htmlspecialchars($sv['sdt']) ?></td>
      <td>
        <!-- Icon sửa -->
        <a class="btn btn-sm btn-primary"
           href="index.php?action=edit&masv=<?=$sv['masv']?>"> <!-- Gán url -->
           <i class="bi bi-pencil"></i>
        </a>

        <!-- Icon Xóa có confirm-->
        <a class="btn btn-sm btn-danger"
           href="index.php?action=delete&masv=<?=$sv['masv']?>"
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
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"> <!-- hightlight trang đang đứng -->
        <!-- Link chuyển trang -->
        <a class="page-link"
           href="index.php?action=list&page=<?=$i?> 
           <?= $q ? '&q='.urlencode($q) : '' ?>
           <?= $filterMalop ? '&malop='.urlencode($filterMalop) : '' ?>">
           <?=$i?>
        </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<!--
  $q ? '&q='.urlencode($q) : '' (giữ lại từ khóa tìm kiếm)
  = $filterMalop ? '&malop='.urlencode($filterMalop) : '' "> (giữ lại bộ lọc lớp)
  =$i (in ra số trang)
-->
