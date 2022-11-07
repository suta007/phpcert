@extends('layouts.guest')
@section('content')
	<div id="newtable" class="text-dark row mt-3 rounded bg-white p-4 shadow">
		<div class="fs-3 fw-bold my-3">
			เกียรติบัตร {{ $cert->name }}
		</div>
		<table class="table-hover table-bordered table" id="certtablex">
			<thead>
				<tr class="bg-web text-light fs-6">
					<th class="text-nowrap text-center" style="width:1%">ลำดับ</th>
					<th class="text-center">ชื่อ</th>
					<th class="text-center">ดาวนโหลด</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($datas as $data)
					<tr>
						<td class="text-center">{{ $data->i }}</td>
						<td>{{ $data->name }}</td>
						<td class="text-nowrap" style="width:1%">
							<a href="/cert.php?cid={{ $cert->id }}&id={{ $data->id }}" class="btn btn-web btn-sm" target="_blank">
								<i class="fa-solid fa-download me-2"></i>ดาวน์โหลด</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			$("#certtablex").dataTable({
				pageLength: 10,
				language: {
					url: "/public/js/lang/th2.json",
				},
			});
		});
	</script>
@endsection
