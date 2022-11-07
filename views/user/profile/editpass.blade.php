@extends('layouts.app')

@section('content')
	<div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
		เปลี่ยนรหัสผ่าน
	</div>
	<div class="clearfix"></div>
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
			<form method="POST" action="/user.php?mode=updatepass" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

				<div class="row mb-3">
					<label for="current_password" class="col-md-4 col-form-label text-md-end">รหัสผ่านปัจจุบัน</label>
					<div class="col-md-6">
						<input id="current_password" type="password" class="form-control" name="current_password" required>
					</div>
				</div>

				<div class="row mb-3">
					<label for="password" class="col-md-4 col-form-label text-md-end">รหัสผ่านใหม่</label>
					<div class="col-md-6">
						<input id="password" type="password" class="form-control" name="password" minlength="8" required>
					</div>
				</div>

				<div class="row mb-3">
					<label for="password_confirmation" class="col-md-4 col-form-label text-md-end">ยืนยันรหัสผ่านใหม่</label>
					<div class="col-md-6">
						<input id="password_confirmation" type="password" class="form-control" name="password_confirmation" minlength="8" required>
					</div>
				</div>

				<div class="row col-6 mx-auto">
					<button type="submit" class="btn btn-web py-3"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
				</div>

			</form>
		</div>
	</div>
@endsection
