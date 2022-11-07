@extends('layouts.guest')
@section('content')
	<div class="rounded mt-2 shadow bg-white text-dark p-4 row">
		<div class="col-auto mb-3">
			@php
				$startYear = 2565;
				$thisYear = Date('Y') + 543;
			@endphp
			<select name="year" id="year" class="form-select">
				<option value="">เลือกปี</option>
				@for ($i = $startYear; $i <= $thisYear; $i++)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
		</div>
		<div class="col mb-3">
			<select name="project" id="project" class="form-select">
				<option value="">เลือกกิจกรรม/โครงการ</option>
			</select>
		</div>
	</div>
	<div id="newtable" class="mt-3 rounded shadow bg-white text-dark p-4 row">
		<div class="text-center align-items-center justify-content-center" style="min-height: 50vh;">
			<img src="/public/images/logo.png" height="200px;">
			<div class="text-web fw-bold fs-4">{{ $_EVN['NAME'] }}</div>
			<div>กรุณาเลือก องค์กร ปี และ กิจกรรม/โครงการ ที่ท่านต้องการค้นหาเกียรติบัตร</div>
		</div>
	</div>
@endsection
@section('script')
	<script>
		$("#year").change(function(e) {
			e.preventDefault();

			$("select#year option:selected").each(function() {
				year = $(this).val();
			});
			if (isNaN(parseInt(year))) {
				return;
			}

			var url = '/index.php?mode=getproject&year=' + year;
			//url = url.replace(':id', org_id);
			//url = url.replace(':year', year);
			//console.log(url);
			$('#project').html('');

			$.getJSON(url, function(data) {
				if (data.length) {
					$('#project').append('<option value="">เลือกกิจกรรม/โครงการ</option>');
					$.each(data, function(index, val) {
						$('#project').append('<option value="' + val.id + '">' + val.name + '</option>');
					});
				} else {
					$('#project').append('<option value="">ไม่พบข้อมูลเกียรติบัตร</option>');
				}
			});
		});

		$("#project").change(function(e) {
			e.preventDefault();

			var loading = '<div class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh;"><div class="spinner-grow me-2 text-web" role="status"></div>Loading...</div>';
			$("#newtable").show();
			$("#newtable").html(loading);

			$("select#project option:selected").each(function() {
				cid = $(this).val();
			});
			if (isNaN(parseInt(cid))) {
				return;
			}

			$("select#year option:selected").each(function() {
				year = $(this).val();
			});
			if (isNaN(parseInt(year))) {
				return;
			}

			var url = '/index.php?mode=getcert&year=' + year + '&cid=' + cid;
			$.get(url, function(data) {
				$("#newtable").show();
				$("#newtable").html(data);
			});
		});
	</script>
@endsection
