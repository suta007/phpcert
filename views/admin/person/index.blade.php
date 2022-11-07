@extends('layouts.app')
<style>
	th {
		padding-top: 15px !important;
		padding-bottom: 15px !important;
	}
</style>
@section('content')
	<div class="text-dark fw-bold fs-4 rounded bg-white p-4 shadow">
		รายชื่อ
		<div class="float-end">
			@if ($cert->user_id == $_SESSION['ss_id'] && $cert->sheet == false)
				<a href="/admin/list.php?mode=create&id={{ $cert->id }}" class="btn btn-web me-2 mb-2">
					<i class="fa fa-plus me-2" aria-hidden="true"></i> เพิ่มชื่อ
				</a>
			@endif
			<a href="/admin/main.php?mode=edit&id={{ $cert->id }}" class="btn btn-primary mb-2"><i class="fa-solid fa-pen-to-square me-2"></i>แก้ไขเกียรติบัตร</a>
		</div>
	</div>

	<div class="text-dark fw-bold fs-5 mt-4 rounded bg-white p-4 shadow">
		เกียรติบัตร {{ $cert->name }}
	</div>

	@if ($cert->user_id == $_SESSION['ss_id'])
		@if ($cert->sheet == true)
			<div class="text-dark fw-bold mt-4 rounded bg-white p-4 shadow">
				<form method="POST" action="/admin/list.php?mode=sheet&cid={{ $cert->id }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
					<div class="row mb-3">
						<label for="link" class="col-sm-3 col-form-label text-md-end form-required">ลิงก์ google sheet</label>
						<div class="col-sm-8">
							<input type="url" name="link" id="link" class="form-control" maxlength="250" required value="{{ old('link', $cert->link) }}">
						</div>
					</div>
					<div class="row mb-3">
						<label for="pre" class="col-sm-3 col-form-label text-md-end form-required">คอลัมน์คำนำหน้าชื่อ</label>
						<div class="col-sm-3">
							<input type="number" name="pre" id="pre" step="1" class="form-control" value="{{ old('col', $cert->pre) }}" placeholder="หากไม่มีให้ใส่เลข 0" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="col" class="col-sm-3 col-form-label text-md-end form-required">คอลัมน์ชื่อ</label>
						<div class="col-sm-3">
							<input type="number" name="col" id="col" step="1" class="form-control" value="{{ old('col', $cert->col) }}" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="test" class="col-sm-3 col-form-label text-md-end">เป็นแบบทดสอบ</label>
						<div class="col-sm-3 form-check form-switch ms-1 ps-5 pt-2">
							<input type="checkbox" name="test" id="test" class="form-check-input" {{ checked(old('test', $cert->test)) }} role="switch" value="1">
						</div>
					</div>
					<div class="row mb-3">
						<label for="score" class="col-sm-3 col-form-label text-md-end">คอลัมน์คะแนน</label>
						<div class="col-sm-3">
							<input type="number" name="score" id="score" step="1" class="form-control" value="{{ old('score', $cert->score) }}" placeholder="หากไม่มีให้ใส่เลข 0">
						</div>
					</div>
					<div class="row mb-3">
						<label for="pass" class="col-sm-3 col-form-label text-md-end">คะแนนที่ผ่านเกณฑ์</label>
						<div class="col-sm-3">
							<input type="number" name="pass" id="pass" step="1" class="form-control" value="{{ old('pass', $cert->pass) }}">
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-sm-3 mx-auto">
							<button type="submit" class="btn btn-web px-4">บันทึก</button>
						</div>
					</div>
				</form>
			</div>
		@else
			<div class="text-dark fw-bold mt-4 rounded bg-white p-4 shadow">
				<form method="POST" action="/admin/list.php?mode=import&id={{ $cert->id }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
					<div class="row mb-3">
						<label for="namelist" class="col-sm-3 col-form-label text-md-end form-required">นำเข้ารายชื่อ</label>
						<div class="col-sm-6">
							<input type="file" name="namelist" id="namelist" class="form-control" accept=".csv" required>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-web">นำเข้ารายชื่อ</button>
						</div>
					</div>
					<span class="offset-sm-3 text-web fw-normal fs-6"><a href="/public/name.csv" target="_blank"> ดาวน์โหลด template รายชื่อ</a></span><br>
					<span class="offset-sm-3 text-danger fw-normal fs-6">การนำเข้ารายชื่อ จะทำการลบรายชื่อที่มีอยู่ทั้งหมด แล้วนำเข้ารายชื่อทั้งหมดจากไฟล์ทั้งหมด</span>
				</form>
			</div>
		@endif
	@endif

	<div class="text-dark mt-4 rounded bg-white p-4 shadow">

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

		<table class="table-hover table-bordered table" id="dataTable">
			<thead>
				<tr class="bg-web bg-gradient text-white">
					<th class="text-nowrap text-center" style="width: 1%;">ลำดับ</th>
					<th class="text-center">ชื่อ</th>
					<th class="text-center">บรรทัดที่ 2</th>
					<th class="text-center">บรรทัดที่ 3</th>
					<th class="text-nowrap text-center" style="width: 1%;">การจัดการ</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($datas as $item)
					<tr>
						<td class="text-nowrap text-center" style="width: 1%;">{{ $item->i }}</td>
						<td>{{ $item->name }}</td>
						<td>{{ $item->line2 }}</td>
						<td>{{ $item->line3 }}</td>
						<td class="text-nowrap text-center" style="width: 1%;">
							<a href="/admin/list.php?mode=show&cid={{ $cert->id }}&id={{ $item->id }}" data-tooltip="ดู {{ $item->name }}" class="btn btn-success btn-sm py-2" target="_blank"><i class="fa-solid fa-eye"></i></a>

							@if ($item->user_id == $_SESSION['ss_id'] || $_SESSION['ss_type'] == 'admin')
								<a href="/admin/list.php?mode=edit&cid={{ $cert->id }}&id={{ $item->id }}" data-tooltip="แก้ไข {{ $item->name }}" class="btn btn-primary btn-sm py-2"><i class="fa-solid fa-pen-to-square"></i></a>

								<form method="POST" action="/admin/list.php?mode=delete&cid={{ $cert->id }}&id={{ $item->id }}" accept-charset="UTF-8" style="display:inline">
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
