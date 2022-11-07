@extends('layouts.app')

@section('content')
 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
  <i class="fa-solid fa-user me-2"></i>แก้ไขข้อมูลส่วนตัว
 </div>
 <div class="clearfix"></div>
 <div class="rounded shadow bg-white text-dark p-4 mt-4">
  <div class="col-12 mx-auto px-5">
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
   <div class="col-md-8 mx-auto">
    <form method="POST" action="/user.php?mode=update" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

     <div class="row mb-3">
      <label for="name" class="col-sm-3 col-form-label text-md-end form-required">ชื่อ</label>
      <div class="col-sm-6">
       <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $data->name) }}" autocomplete="name" required autofocus>
      </div>
     </div>

     <div class="row mb-3">
      <label for="email" class="col-sm-3 col-form-label text-md-end">อีเมล์</label>
      <div class="col-sm-6">
       <input type="text" name="email" id="email" value="{{ old('email', $data->email) }}" class="form-control">
      </div>
     </div>

     <div class="row col-6 mx-auto">
      <button type="submit" class="btn btn-web py-3"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
     </div>

    </form>
   </div>
  </div>
 @endsection
