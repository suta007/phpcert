<div class="my-3 ">
	<a href="getcert.php?year={{ $year }}&cid={{ $cid }}" class="btn btn-web float-end" target="_blank">แชร์ลิงก์</a>
</div>
<table class="table table-hover table-bordered" id="certtablex">
	<thead>
		<tr class="bg-web text-light fs-6">
			<th class="text-center text-nowrap" style="width:1%">ลำดับ</th>
			<th class="text-center">ชื่อ</th>
			<th class="text-center">ดาวนโหลด</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($datas as $data)
			<tr>
				<td class="text-center">{{ $data->i }}</td>
				<td>{{ $data->name }}</td>
				<td style="width:1%" class="text-center text-nowrap">
					<a href="/cert.php?cid={{ $cid }}&id={{ $data->id }}" class="btn btn-web btn-sm" target="_blank">
						<i class="fa-solid fa-file-pdf me-2"></i>PDF</a>
						<a href="/cert2.php?cid={{ $cid }}&id={{ $data->id }}" class="btn btn-web btn-sm" target="_blank">
						<i class="fa-solid fa-file-image me-2"></i>JPG</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
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
