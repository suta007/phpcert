<!doctype html>
<html lang="th">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->

	<title>{{ $_ENV['TITLE'] }}</title>



	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="/public/css/app.css">
	<link rel="stylesheet" type="text/css" href="/public/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/css-tooltip.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />


	<style>
		html {
			font-size: 16px !important;
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
	<div class="container-fluid">

		<div class="row">
			<button class="btn btn-web btn-side" type="button" id="ctrlSide">
				<i class="fa-solid fa-chevron-right"></i>
			</button>

			@include('layouts.sidebar')
			<div class="col">
				<div class="row">
					<div class="container-fluid">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Scripts -->
	<script type="text/javascript" src="/public/js/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="/public/js/app.js"></script>
	<script type="text/javascript" src="/public/js/sweetalert2.all.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

	@yield('scriptfile')
	<script>
		$(document).ready(function() {
			$('#ctrlSide').click(function(e) {
				$("#sidebar").toggle();
				if ($("#sidebar").is(":hidden")) {
					$('#ctrlSide').css("left", "0px");
				} else {
					$('#ctrlSide').css("left", "300px");
				}
			});
		});

		$('#dataTable').dataTable({
			pageLength: 25,
			order: [],
			language: {
				url: "/public/js/lang/th2.json",
			},
		});

		$(".del-btn").click(function(e) {
			e.preventDefault();
			var x = $(this).closest('tr').find("td:eq(1)").text();
			Swal.fire({
				icon: 'question',
				title: 'ต้องการลบ' + x + '?',
				showCancelButton: true,
				confirmButtonColor: '#dc3545',
				confirmButtonText: 'ลบ',
				cancelButtonText: 'ยกเลิก'
			}).then((result) => {
				if (result.isConfirmed) {
					$(e.target).closest('form').submit();
				}
			})
		});
	</script>
	@yield('script')
</body>

</html>
