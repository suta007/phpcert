@extends('layouts.app')
@section('content')
 <div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
  <i class="fa-solid fa-user-gear me-2"></i>ผู้ใช้งาน
  <a href="/admin/user.php?mode=create" class="btn btn-web float-end mb-2">
   <i class="fa fa-plus me-2" aria-hidden="true"></i> เพิ่มผู้ใช้งาน
  </a>
 </div>
 <div class="clearfix"></div>
 <div class="rounded shadow bg-white text-dark p-4 mt-4">
  <table class="table-bordered table-hover table" id="dataTable">
   <thead>
    <tr>
     <th class="text-center">ID</th>
     <th class="text-center">Name</th>
     <th class="text-center">Username</th>
     <th class="text-center">e-Mail</th>
     <th class="text-center">Type</th>
     <th class="text-center">Last Login</th>
     <th class="text-center">Actions</th>
    </tr>
   </thead>
   <tbody>
    @foreach ($datas as $item)
     <tr>
      <td class="text-nowrap text-center" style="width: 1%;">{{ $item->id }}</td>
      <td>{{ $item->name }}</td>
      <td>{{ $item->username }}</td>
      <td>{{ $item->email }}</td>
      <td>{{ $item->type }}</td>
      <td>{{ $item->last_login }}</td>
      <td class="text-nowrap" style="width: 1%;">
       <a href="/admin/user.php?mode=edit&id={{ $item->id }}" data-tooltip="แก้ไข {{ $item->name }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

       <form method="POST" action="/admin/user.php?mode=delete&id={{ $item->id }}" accept-charset="UTF-8" style="display:inline">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger btn-sm del-btn" data-tooltip="ลบ {{ $item->name }}"><i class="fa-solid fa-trash-can"></i></button>
       </form>
      </td>
     </tr>
    @endforeach
   </tbody>
  </table>
 </div>
@endsection
