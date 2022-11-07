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

		.btn-web,
		.btn-web:hover,
		.btn-web:focus {
			color: white !important;
		}
	</style>
	@yield('css')

</head>

<body>
	<div class="d-flex align-items-center justify-content-center min-vh-100">
		<main class="mb-3">
			<div class="container">

				@yield('content')

			</div>
		</main>
		<footer class="fixed-bottom rounded bg-white shadow">
			<div class="container py-2">
				<div class="row">
					<div class="ms-auto col-auto p-1">
						<img src="/public/images/sutalogo.png" height="48px;">
					</div>
					<div class="align-items-center d-flex col-auto p-0">
						<div class="text-muted">พัฒนาโดย : กฤษฎาพงษ์ สุตะ</div>
					</div>
				</div>
			</div>
		</footer>
	</div>

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
