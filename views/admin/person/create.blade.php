@extends('layouts.app')
<style>
 th {
  padding-top: 15px !important;
  padding-bottom: 15px !important;
 }
</style>
@section('content')
 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
  เพิ่มรายชื่อ
  <div class="float-end">
   <a href="/admin/list.php?id={{ $cert->id }}" class="btn btn-primary mb-2"><i class="fa-solid fa-arrow-left me-2"></i>กลับ</a>
  </div>
 </div>

 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-5 mt-4">
  เกียรติบัตร {{ $cert->name }}
 </div>


 <div class="rounded shadow bg-white text-dark p-4 fw-bold mt-4">

  <form method="POST" action="/admin/list.php?mode=store&id={{ $cert->id }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
   <div class="mx-auto col-md-8">
    <div class="row mb-3">
     <label for="name" class="col-3 col-form-label text-md-end form-required">ชื่อ</label>
     <div class="col-9">
      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
     </div>
    </div>

    <div class="row mb-3">
     <label for="line2" class="col-sm-3 col-form-label text-md-end">บรรทัดที่ 2</label>
     <div class="col-sm-9">
      <input type="text" name="line2" id="line2" value="{{ old('line2') }}" class="form-control @error('line2') is-invalid @enderror">
     </div>
    </div>

    <div class="row mb-3">
     <label for="line3" class="col-sm-3 col-form-label text-md-end">บรรทัดที่ 3</label>
     <div class="col-sm-9">
      <input type="text" name="line3" id="line3" value="{{ old('line3') }}" class="form-control @error('line3') is-invalid @enderror">
     </div>
    </div>

    <div class="row mb-3">
     <label for="i" class="col-sm-3 col-form-label text-md-end form-required">ลำดับผู้รับเกียรติบัตร</label>
     <div class="col-sm-9">
      <input type="number" step="1" name="i" id="i" value="{{ old('i') }}" class="form-control @error('i') is-invalid @enderror" required>
     </div>
    </div>

    <div class="row col-6 mx-auto">
     <button type="submit" class="btn btn-web py-3"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
    </div>
   </div>
  </form>
 </div>
@endsection
