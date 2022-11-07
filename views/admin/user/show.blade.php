@extends('layouts.app')

@section('content')
	<x-div class="mx-auto fw-bold fs-5 mb-2 col-12">ข้อมูลUser</x-div>
	<div class="clearfix"></div>
	<x-div class="mx-auto px-5 col-12">
		<a href="{{ route('admin.user.edit', $data->id) }}" data-tooltip="แก้ไข{{ $data->name }}" class="btn btn-primary btn-sm float-start me-2"><i class="fa-solid fa-pen-to-square me-2"></i> แก้ไข</a>
		<form method="POST" action="{{ route('admin.user.destroy', $data->id) }}" accept-charset="UTF-8" style="display:inline">
			@method('DELETE')
			@csrf
			<button type="submit" class="btn btn-danger btn-sm del-btn" data-tooltip="ลบ{{ $data->name }}"><i class="fa-solid fa-trash-can me-2"></i>ลบ</button>
		</form>

		<a href="{{ route('admin.user.index') }}" class="btn btn-outline-web btn-sm float-end"><i class="fa-solid fa-arrow-left me-2"></i>กลับ</a>
		<div class="clearfix"></div>

		<div class="table-responsive mt-2">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td class="w-25 text-end pe-2 fw-bold">ID :</td>
						<td>{{ $data->id }}</td>
					</tr>
					<tr>
						<td class="w-25 text-end pe-2 fw-bold">ชื่อ :</td>
						<td>{{ $data->name }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</x-div>
@endsection
