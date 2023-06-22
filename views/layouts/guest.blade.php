<!doctype html>
<html lang="th">

<head>
	<title>{{ $_ENV['TITLE'] }}</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="/public/css/app.css">
	<link rel="stylesheet" type="text/css" href="/public/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/css-tooltip.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

	<style>
		html {
			font-size: 14px !important;
			font-family: 'Sarabun', sans-serif;
		}

		.logo-invert {
			filter: invert(1);
		}

		.btn-web,
		.btn-web:hover,
		.btn-web:focus {
			color: white !important;
		}

		.navbar .nav-link {
			color: white;
		}

		.navbar .nav-link:hover {
			color: lightgreen;
		}
	</style>
	@yield('css')

</head>

<body class="min-vh-100 d-flex flex-column ">
	<header class="mb-3">
		<nav class="navbar navbar-expand-md navbar-dark bg-web">
			<div class="container">
				<a class="navbar-brand" href="/index.php"><img src="/public/images/logo.png" height="50" class="me-2">{{ $_ENV['NAME'] }}</a>
				<button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="collapsibleNavId">
					<ul class="navbar-nav ms-auto mt-lg-0 mt-2">
						<li class="nav-item">
							<a class="nav-link" href="/index.php" aria-current="page">หน้าแรก</a>
						</li>
						@if ($_SESSION['ss_logined'] == true)
							<li><a class="nav-link" href="admin/main.php">จัดการเกียรติบัตร</a></li>
							<li><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
						@else
							<li><a class="nav-link" href="admin/login.php">เข้าสู่ระบบ</a></li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

	</header>
	<main class="mb-3">
		<div class="container">

			@yield('content')

		</div>
	</main>
	<footer class="mt-auto bg-white rounded shadow">
		<div class="container  py-2">
			<x-div class="row">
				<div class="ms-auto col-auto p-1">
					<img src="/public/images/sutalogo.png" height="48px;">
				</div>
				<div class="col-auto p-0 align-items-center d-flex">
					<div class="text-muted">พัฒนาโดย : กฤษฎาพงษ์ สุตะ</div>
				</div>
			</x-div>
		</div>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="/public/js/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="/public/js/app.js"></script>
	<script type="text/javascript" src="/public/js/sweetalert2.all.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

	@yield('scriptfile')
	<script></script>
	@yield('script')
</body>

</html>
