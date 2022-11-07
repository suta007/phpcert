@extends('layouts.blank')
@section('content')
	<div class="rounded mt-2 shadow bg-white text-dark p-4" style="width:400px;">
		<div class="text-center">
			<img src="/public/images/logo.png" style="height:150px;">
			<div class="h4 fw-bold text-dark mt-3">
				เข้าสู่ระบบ
			</div>
			<div class="h6 fw-bold text-web mt-2">
				{{ $_ENV['NAME'] }}
			</div>
		</div>

		@if (isset($_SESSION['ss_error']))
			<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
				<strong>{{ $_SESSION['ss_error'] }}</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<?php
			unset($_SESSION['ss_error']);
			?>
		@endif
		<div class="mt-4 px-5">
			<form method="POST" action="/admin/login.php?mode=auth">
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" class="form-control" name="username" id="username" autocomplete="username" required autofocus>
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" name="password" id="password" autocomplete="password" required>
				</div>

				<div class="my-4 text-center">
					<a href="../index.php" class="btn btn-outline-web py-2 px-4 me-2">กลับหน้าแรก</a>
					<button type="submit" class="btn btn-web py-2 px-4 ms-2"><i class="fa-solid fa-unlock  me-2"></i>เข้าสู่ระบบ</button>
				</div>
			</form>
		</div>
	</div>
@endsection
