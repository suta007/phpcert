@extends('layouts.app')
<style>
 th {
  padding-top: 15px !important;
  padding-bottom: 15px !important;
 }

 a.name {
  text-decoration: none;
  color: var(--bs-web);
  font-weight: bold;
 }
</style>
@section('content')
 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
  รายการเกียรติบัตร
 </div>

 <div class="rounded shadow bg-white text-dark p-4 mt-4">

  @if (isset($_SESSION['ss_success']))
   <div class="alert alert-success alert-dismissible fade show mt-2 mb-4" role="alert">
    <strong>{{ $_SESSION['ss_success'] }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <?php
   unset($_SESSION['ss_success']);
   ?>
  @endif

  <table class="table table-hover table-bordered" id="dataTable">
   <thead>
    <tr class="bg-web bg-gradient text-white">
     <th scope="col" class="text-nowrap text-center" style="width: 1%;">ID</th>
     <th scope="col" class="text-center">ชื่อเกียรติบัตร</th>
     <th scope="col" class="text-center">เจ้าของ</th>
     <th scope="col" class="text-nowrap text-center" style="width: 1%;">ทะเบียนเกียรติบัตร</th>
     <th scope="col" class="text-nowrap text-center" style="width: 1%;">การจัดการ</th>
    </tr>
   </thead>
   <tbody>
    @foreach ($datas as $item)
     <tr>
      <td scope="row" class="text-nowrap text-center" style="width: 1%;">{{ $item->id }}</td>
      <td><a href="/admin/list.php?id={{ $item->id }}" class="name">{{ $item->name }}</a></td>
      <td>{{ $item->user->name }}</td>
      <td class="text-center">{{ $item->num }}</td>
      <td class="text-nowrap text-center" style="width: 1%;">
       <a href="/admin/main.php?mode=show&id={{ $item->id }}" data-tooltip="ดู {{ $item->name }}" class="btn btn-success btn-sm py-2" target="_blank"><i class="fa-solid fa-eye"></i></a>

       @if ($item->user_id == $_SESSION['ss_id'] || $_SESSION['ss_type'] == 'admin')
        <a href="/admin/main.php?mode=edit&id={{ $item->id }}" data-tooltip="แก้ไข {{ $item->name }}" class="btn btn-primary btn-sm py-2"><i class="fa-solid fa-pen-to-square"></i></a>
        <form method="POST" action="/admin/main.php?mode=delete&id={{ $item->id }}" accept-charset="UTF-8" style="display:inline">
         <button type="submit" class="btn btn-danger btn-sm del-btn py-2" data-tooltip="ลบ {{ $item->name }}"><i class="fa-solid fa-trash-can"></i></button>
        </form>
       @endif


      </td>
     </tr>
    @endforeach
   </tbody>
  </table>

 </div>
@endsection
