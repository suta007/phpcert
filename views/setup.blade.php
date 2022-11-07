@extends('layouts.blank')
@section('content')
	@if ($error)
		<div class="text-light fs-3 fw-bold d-flex align-items-center justify-content-center mt-2 rounded bg-red-500 p-4 text-center shadow" style="width:720px; height:200px;">
			{!! $error !!}
		</div>
	@else
		<div class="row" style="width:500px;">
			<div class="text-dark col mt-2 rounded bg-white p-4 shadow">
				<form method="POST" action="/admin/setup.php?mode=store">
					<div class="mb-4 mt-3 text-center">
						<img src="/public/images/logo.png" style="height:100px;">
						<div class="h4 fw-bold text-dark mt-3">
							สร้างผู้ดูแลระบบ
						</div>
					</div>

					<div class="row mb-3">
						<label for="username" class="col-sm-4 col-form-label text-md-end form-required">Username</label>
						<div class="col-sm-7">
							<input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" required autofocus>
						</div>
					</div>

					<div class="row mb-3">
						<label for="password" class="col-sm-4 col-form-label text-md-end form-required">Password</label>
						<div class="col-sm-7">
							<input type="password" name="password" id="password" class="form-control" required>
						</div>
					</div>

					<div class="row mb-3">
						<label for="name" class="col-sm-4 col-form-label text-md-end form-required">Name</label>
						<div class="col-sm-7">
							<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" required>
						</div>
					</div>

					<div class="row mb-3">
						<label for="email" class="col-sm-4 col-form-label text-md-end form-required">eMail</label>
						<div class="col-sm-7">
							<input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
						</div>
					</div>

					<div class="row mb-3">
						<label for="type" class="col-sm-4 col-form-label text-md-end form-required">ประเภทผู้ใช้งาน</label>
						<div class="col-sm-7">
							<select name="type" id="type" class="form-select" required>
								<option value="admin" selected>ผู้ดูแลระบบ</option>
							</select>
						</div>
					</div>

					<div class="row col-6 mx-auto">
						<button type="submit" class="btn btn-web w-50 mx-auto py-3"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
					</div>
				</form>
			</div>
		</div>
	@endif
@endsection
