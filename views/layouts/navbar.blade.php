<style>
	.navbar-dark .nav-link {
		color: white;
	}

	.navbar-dark .nav-link:hover,
	.navbar-dark .nav-link:focus {
		color: wheat;
	}
</style>
<div class="row">
	<nav class="navbar navbar-expand-md navbar-dark bg-web bg-gradient shadow-md py-1 px-md-4 px-2">
		<div class="container-fluid">
			<a class="navbar-brand" href="{{ url('/') }}">
				<img src="{{ asset('images/logo.png') }}" alt="" height="64px">
				<span class="ms-1 fw-bold fs-4 text-light">{{ config('app.name', 'Laravel') }}</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav me-auto">

				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">หน้าหลัก</a></li>

					@if (Group('อำนวยการ'))
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">ทะเบียนหนังสือเข้า</a></li>
					@endif

					@if (Role('user') || Role('head'))
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">หนังสือเข้า</a></li>
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">บันทึกข้อความ</a></li>
					@endif

					@if (Role('head'))
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">ผู้อำนวยกลุ่ม/หน่วย</a></li>
					@endif

					@if (Role('subdirector'))
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">รองผู้อำนวยการ สพม.</a></li>
					@endif

					@if (Role('director'))
						<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">ผู้อำนวยการ สพม.</a></li>
					@endif


					@if (Role('admin'))
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								ผู้ดูแลระบบ
							</a>

							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('admin.user.index') }}">จัดการผู้ใช้งาน</a>
								<a class="dropdown-item" href="{{ route('admin.position.index') }}">จัดการตำแหน่ง</a>
								<a class="dropdown-item" href="{{ route('admin.workgroup.index') }}">จัดการกลุ่มงาน</a>
							</div>
						</li>
					@endif

					@guest
						@if (Route::has('login'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
						@endif

						@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@endif
					@else
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								<i class="fa-solid fa-user-circle fa-2xl"></i>
							</a>

							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a href="{{ route('user.main.edit') }}" class="dropdown-item">แก้ไขข้อมูล</a>
								<a href="{{ route('user.main.editpass') }}" class="dropdown-item">เปลี่ยนรหัสผ่าน</a>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                                                                                  document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>
</div>
