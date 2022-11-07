@extends('layouts.app')

@section('content')
 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
  แก้ไขผู้ใช้
  <a href="/admin/user.php" class="btn btn-outline-web btn-sm float-end"><i class="fa-solid fa-arrow-left me-2"></i>กลับ</a>
 </div>
 <div class="clearfix"></div>
 <div class="rounded shadow bg-white text-dark p-4 mb-4">
  @if (isset($_SESSION['ss_success']))
   <div class="alert alert-success alert-dismissible fade show mt-2 mb-4" role="alert">
    <strong>{{ $_SESSION['ss_success'] }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <?php
   unset($_SESSION['ss_success']);
   ?>
  @endif

  @if (isset($_SESSION['ss_error']))
   <div class="alert alert-danger alert-dismissible fade show mt-2 mb-4" role="alert">
    <strong>{{ $_SESSION['ss_error'] }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <?php
   unset($_SESSION['ss_error']);
   ?>
  @endif
  <form method="POST" action="/admin/user.php?mode=update&id={{ $data->id }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
   <div class="row mb-3">
    <label for="name" class="col-sm-3 col-form-label text-md-end form-required">Name</label>
    <div class="col-sm-6">
     <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $data->name) }}" autocomplete="name" required>
    </div>
   </div>

   <div class="row mb-3">
    <label for="password" class="col-sm-3 col-form-label text-md-end">Password</label>
    <div class="col-sm-6">
     <input type="password" name="password" id="password" class="form-control" placeholder="ถ้าไม่ต้องการเปลี่ยนรหัสผ่านให้ว่างไว้">
    </div>
   </div>

   <div class="row mb-3">
    <label for="email" class="col-sm-3 col-form-label text-md-end">eMail</label>
    <div class="col-sm-6">
     <input type="text" name="email" id="email" value="{{ old('email', $data->email) }}" class="form-control @error('email') is-invalid @enderror">
    </div>
   </div>

   <div class="row mb-3">
    <label for="type" class="col-sm-3 col-form-label text-md-end form-required">ประเภทผู้ใช้งาน</label>
    <div class="col-sm-6">
     <select name="type" id="type" class="form-select" required>
      <option value="" selected hidden>เลือกประเภทผู้ใช้งาน</option>
      <option value="admin" {{ selected(old('type', $data->type) == 'admin') }}>ผู้ดูแลระบบ</option>
      <option value="user" {{ selected(old('type', $data->type) == 'user') }}>ผู้ใช้งาน</option>
     </select>
    </div>
   </div>

   <div class="row col-6 mx-auto">
    <button type="submit" class="btn btn-web w-50 mx-auto py-3"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
   </div>

  </form>
 </div>
@endsection
