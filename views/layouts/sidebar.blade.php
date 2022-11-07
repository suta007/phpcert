<div class="sidebar col bg-white p-2 shadow-md" id="sidebar">
 <a href="/" class="d-flex align-items-center mb-md-0 me-md-auto text-decoration-none text-web ms-3 mb-3">
  <img src="/public/images/logo.png" style="height: 48px;">
  <span class="ms-3 fs-5 fw-bold">{{ $_ENV['NAME'] }}</span>
 </a>
 <hr>
 <div class="fw-bold ps-2 text-web">
  <i class="fa-solid fa-user me-2"></i>{{ $_SESSION['ss_name'] }}<br>
 </div>
 <hr>
 <ul class="list-unstyled ps-0">
  <li>
   <a class="navlink ps-4 mb-1 rounded py-2" href="/user.php?mode=edit"><i class="fa-solid fa-user me-2"></i>แก้ไขข้อมูลส่วนตัว</a>
  </li>
  <li>
   <a class="navlink ps-4 mb-1 rounded py-2" href="/user.php?mode=editpass"><i class="fa-solid fa-key me-2"></i>เปลี่ยนรหัสผ่าน</a>
  </li>
  <li>
   <a class="navlink ps-4 mb-1 rounded py-2" href="../logout.php"><i class="fa-solid fa-right-to-bracket me-2"></i>ออกจากระบบ</a>
  </li>
  <hr>
  <li>
   <a class="navlink ps-4 mb-1 rounded py-2" href="/admin/main.php"><i class="fa-solid fa-list me-2"></i>รายการเกียรติบัตร</a>
  </li>
  <li>
   <a class="navlink ps-4 mb-1 rounded py-2" href="/admin/main.php?mode=create"><i class="fa-solid fa-award me-2"></i>สร้างเกียรติบัตร</a>
  </li>
  @if ($_SESSION['ss_type'] == 'admin')
   <hr>
   <li>
    <a class="navlink ps-4 mb-1 rounded py-2" href="/admin/user.php"><i class="fa-solid fa-user-gear me-2"></i>ผู้ใช้งานงานระบบ</a>
   </li>
  @endif
 </ul>
</div>
