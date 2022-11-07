@extends('layouts.app')
<?php
$config = include '../configs/font.php';
$font = $config['select'];
$obj = json_decode(json_encode($font), false);
?>
@section('content')
	<div class="rounded shadow bg-white text-dark p-4 fw-bold fs-4">
		สร้างเกียรติบัตร
	</div>
	<form method="POST" action="/admin/main.php?mode=store" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
		<div class="rounded shadow bg-white text-dark p-4 mt-4">
			@if (isset($_SESSION['ss_error']))
				<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
					<strong>{{ $_SESSION['ss_error'] }}</strong>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php
				unset($_SESSION['ss_error']);
				?>
			@endif
			<div class="col-md-8 mx-auto">
				<div class="row mb-3">
					<label for="name" class="col-sm-3 col-form-label text-md-end form-required">กิจกรรม/โครงการ</label>
					<div class="col-sm-9">
						<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="255" autocomplete="name" required autofocus>
					</div>
				</div>
				<div class="row mb-3">
					<label for="orientation" class="col-sm-3 col-form-label text-md-end form-required">การวางกระดาษ</label>
					<div class="col-sm-9">
						<select name="orientation" id="orientation" class="form-select" required>
							<option value="L" {{ selected(old('orientation') == 'L') }}>แนวนอน</option>
							<option value="P" {{ selected(old('orientation') == 'P') }}>แนวตั้ง</option>
						</select>
					</div>
				</div>
				<div class="row mb-3">
					<label for="line" class="col-sm-3 col-form-label text-md-end form-required">ข้อความ</label>
					<div class="col-sm-9">
						<select name="line" id="line" class="form-select" required>
							<option value="1" {{ selected(old('line') == '1') }}>เฉพาะชื่อ</option>
							<option value="2" {{ selected(old('line') == '2') }}>ชื่อ + 1 บรรทัด</option>
							<option value="3" {{ selected(old('line') == '3') }}>ชื่อ + 2 บรรทัด</option>
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="bg" class="col-sm-3 col-form-label text-md-end">พื้นหลังเกียรติบัตร</label>
					<div class="col-sm-9">
						<input type="file" name="bg" id="bg" accept=".jpg, .jpeg, .png" class="form-control">
					</div>
				</div>
				<div class="row mb-3">
					<label for="date_at" class="col-sm-3 col-form-label text-md-end form-required">วันที่จัดกิจกรรม/โครงการ</label>
					<div class="col-sm-9">
						<input type="text" name="date_at" id="date_at" value="{{ old('date_at') }}" class="form-control" autocomplete="วันที่" required>
					</div>
				</div>
				@php
					$startYear = 2565;
					$thisYear = DATE('Y') + 543;
				@endphp
				<div class="row mb-3">
					<label for="year" class="col-sm-3 col-form-label text-md-end form-required">ปี</label>
					<div class="col-sm-9">
						<select name="year" id="year" class="form-select" required>
							@for ($i = $thisYear; $i >= $startYear; $i--)
								<option value="{{ $i }}" {{ selected(old('year') == $i) }}>{{ $i }}</option>
							@endfor
						</select>

					</div>
				</div>
				<div class="row mb-3">
					<label class="col-sm-3 col-form-label text-md-end mb-auto" for="sheet">ใช้ Google Sheet</label>
					<div class="col-sm-9">
						<select name="sheet" id="sheet" class="form-select">
							<option value="0" {{ selected(old('sheet') == 0) }}>ไม่ใช้</option>
							<option value="1" {{ selected(old('sheet') == 1) }}>ใช้</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="rounded shadow bg-white text-dark p-4 mt-4">
			<div class="text-web fw-bold fs-5">
				เลขทะเบียน
			</div>
			<div class="col-md-8 mx-auto">
				<div class="row mb-3">
					<label for="pattern" class="col-sm-3 col-form-label text-md-end form-required">รูปแบบเลขทะเบียน</label>
					<div class="col-sm-9">
						<input type="text" name="pattern" id="pattern" value="{{ old('pattern', '[[code]].[[num]]-[[i]]/[[year]]') }}" class="form-control" required>
						<div class="text-success mt-2">
							ตัวอย่าง [[code]].[[num]]-[[i]]/[[year]] => สุตะ.01-007/2565<br>
							<b>เมื่อ</b> <br>
							<li>ตัวย่อองค์กร ( [[code]] ) = สุตะ</li>
							<li>เลขที่เกียรติบัตร ( [[num]] ) = 01</li>
							<li>ลำดับผู้รับเกียรติบัตร ( [[i]] ) = 7 (กำหนดเลข 3 หลัก)</li>
							<li>ปี ( [[year]] ) = 2565</li>
						</div>

					</div>

					<div class="row mb-3">
						<label for="code_name" class="col-sm-3 col-form-label text-md-end form-required">ตัวย่อองค์กร</label>
						<div class="col-sm-9">
							<input type="text" name="code_name" id="code_name" value="{{ old('code_name') }}" class="form-control" required placeholder="สุตะ">

						</div>
					</div>

					<div class="row mb-3">
						<label for="num" class="col-sm-3 col-form-label text-md-end form-required">เลขที่เกียรติบัตร</label>
						<div class="col-sm-9">
							<input type="text" name="num" id="num" value="{{ old('num') }}" class="form-control" placeholder="001" required>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_top" class="col-sm-3 col-form-label text-md-end form-required">ระยะห่างด้านบน</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="number" step="1" name="code_top" id="code_top" value="{{ old('code_top', '10') }}" class="form-control" required>
								<span class="input-group-text">mm</span>
							</div>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_right" class="col-sm-3 col-form-label text-md-end form-required">ระยะห่างด้านขวา</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input step="1" type="number" name="code_right" id="code_right" value="{{ old('code_right', '15') }}" class="form-control" required>
								<span class="input-group-text">mm</span>
							</div>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_font" class="col-sm-3 col-form-label text-md-end form-required">ฟอนต์</label>
						<div class="col-sm-9">
							<select name="code_font" id="code_font" class="form-select" required>
								@foreach ($obj as $item)
									<option value='{{ $item->value }}' {{ selected(old('code_font') == $item->value) }}>{{ $item->name }}</option>
								@endforeach
							</select>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_size" class="col-sm-3 col-form-label text-md-end form-required">ขนาดฟอนต์</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input step="1" type="number" name="code_size" id="code_size" value="{{ old('code_size', '18') }}" class="form-control" required>
								<span class="input-group-text">pt</span>
							</div>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_number" class="col-sm-3 col-form-label text-md-end form-required">ชนิดตัวเลข</label>
						<div class="col-sm-9">
							<select name="code_number" id="code_number" class="form-select" required>
								<option value="thai" {{ selected(old('code_number') == 'thai') }}>เลขไทย</option>
								<option value="arabic" {{ selected(old('code_number') == 'arabic') }}>เลขอาราบิค</option>
							</select>

						</div>
					</div>

					<div class="row mb-3">
						<label for="i_digit" class="col-sm-3 col-form-label text-md-end form-required">จำนวนหลักลำดับเลข</label>
						<div class="col-sm-9">
							<input step="1" type="number" name="i_digit" id="i_digit" value="{{ old('i_digit', '3') }}" class="form-control" required>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_weight" class="col-sm-3 col-form-label text-md-end form-required">ความหนา</label>
						<div class="col-sm-9">
							<select name="code_weight" id="code_weight" class="form-select" required>
								<option value="normal" {{ selected(old('code_weight') == 'normal') }}>ปกติ</option>
								<option value="bold" {{ selected(old('code_weight') == 'bold') }}>หนา</option>
							</select>

						</div>
					</div>

					<div class="row mb-3">
						<label for="code_color" class="col-sm-3 col-form-label text-md-end form-required">สีเลขทะเบียน</label>
						<div class="col-sm-9">
							<input type="color" name="code_color" id="code_color" value="{{ old('i_digit', '#000000') }}" class="form-control" required style="width:80px; height:40px;">

						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="rounded shadow bg-white text-dark p-4 mt-4">
			<div class="text-web fw-bold fs-5">
				ชื่อผู้รับเกียรติบัคร
			</div>
			<div class="col-md-8 mx-auto">
				<div class="row mb-3">
					<label for="name_top" class="col-sm-3 col-form-label text-md-end form-required">ระยะห่างด้านบน</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="number" step="1" name="name_top" id="name_top" value="{{ old('name_top', '85') }}" class="form-control" required>
							<span class="input-group-text">mm</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="name_font" class="col-sm-3 col-form-label text-md-end form-required">ฟอนต์</label>
					<div class="col-sm-9">
						<select name="name_font" id="name_font" class="form-select" required>
							@foreach ($obj as $item)
								<option value='{{ $item->value }}' {{ selected(old('name_font') == $item->value) }}>{{ $item->name }}</option>
							@endforeach
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="name_size" class="col-sm-3 col-form-label text-md-end form-required">ขนาดฟอนต์</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input step="1" type="number" name="name_size" id="name_size" value="{{ old('name_size', '48') }}" class="form-control" required>
							<span class="input-group-text">pt</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="name_weight" class="col-sm-3 col-form-label text-md-end form-required">ความหนา</label>
					<div class="col-sm-9">
						<select name="name_weight" id="name_weight" class="form-select" required>
							<option value="normal" {{ selected(old('name_weight') == 'normal') }}>ปกติ</option>
							<option value="bold" {{ selected(old('name_weight') == 'bold') }}>หนา</option>
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="name_color" class="col-sm-3 col-form-label text-md-end form-required">สีตัวอักษร</label>
					<div class="col-sm-9">
						<input type="color" name="name_color" id="name_color" value="{{ old('name_color', '#000000') }}" class="form-control" required style="width:80px; height:40px;">

					</div>
				</div>

			</div>
		</div>

		<div class="rounded shadow bg-white text-dark p-4 mt-4">
			<div class="text-web fw-bold fs-5">
				ข้อความบรรทัดที่ 2<br>
				<span class="text-muted fs-6">แสดงเมื่อเลือก " ชื่อ + 1 บรรทัด "</span>
			</div>
			<div class="col-md-8 mx-auto">
				<div class="row mb-3">
					<label for="line2_top" class="col-sm-3 col-form-label text-md-end form-required">ระยะห่างด้านบน</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="number" step="1" name="line2_top" id="line2_top" value="{{ old('line2_top', '105') }}" class="form-control" required>
							<span class="input-group-text">mm</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line2_font" class="col-sm-3 col-form-label text-md-end form-required">ฟอนต์</label>
					<div class="col-sm-9">
						<select name="line2_font" id="line2_font" class="form-select" required>
							@foreach ($obj as $item)
								<option value='{{ $item->value }}' {{ selected(old('line2_font') == $item->value) }}>{{ $item->name }}</option>
							@endforeach
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line2_size" class="col-sm-3 col-form-label text-md-end form-required">ขนาดฟอนต์</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input step="1" type="number" name="line2_size" id="line2_size" value="{{ old('line2_size', '24') }}" class="form-control" required>
							<span class="input-group-text">pt</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line2_weight" class="col-sm-3 col-form-label text-md-end form-required">ความหนา</label>
					<div class="col-sm-9">
						<select name="line2_weight" id="line2_weight" class="form-select" required>
							<option value="normal" {{ selected(old('line2_weight') == 'normal') }}>ปกติ</option>
							<option value="bold" {{ selected(old('line2_weight') == 'bold') }}>หนา</option>
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line2_color" class="col-sm-3 col-form-label text-md-end form-required">สีตัวอักษร</label>
					<div class="col-sm-9">
						<input type="color" name="line2_color" id="line2_color" value="{{ old('line2_color', '#000000') }}" class="form-control" required style="width:80px; height:40px;">

					</div>
				</div>
			</div>
		</div>

		<div class="rounded shadow bg-white text-dark p-4 mt-4">
			<div class="text-web fw-bold fs-5">
				ข้อความบรรทัดที่ 3<br>
				<span class="text-muted fs-6">แสดงเมื่อเลือก " ชื่อ + 2 บรรทัด "</span>
			</div>
			<div class="col-md-8 mx-auto">

				<div class="row mb-3">
					<label for="line3_top" class="col-sm-3 col-form-label text-md-end form-required">ระยะห่างด้านบน</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="number" step="1" name="line3_top" id="line3_top" value="{{ old('line3_top', '115') }}" class="form-control" required>
							<span class="input-group-text">mm</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line3_font" class="col-sm-3 col-form-label text-md-end form-required">ฟอนต์</label>
					<div class="col-sm-9">
						<select name="line3_font" id="line3_font" class="form-select" required>
							@foreach ($obj as $item)
								<option value='{{ $item->value }}' {{ selected(old('line3_font') == $item->value) }}>{{ $item->name }}</option>
							@endforeach
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line3_size" class="col-sm-3 col-form-label text-md-end form-required">ขนาดฟอนต์</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input step="1" type="number" name="line3_size" id="line3_size" value="{{ old('line3_size', '24') }}" class="form-control" required>
							<span class="input-group-text">pt</span>
						</div>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line3_weight" class="col-sm-3 col-form-label text-md-end form-required">ความหนา</label>
					<div class="col-sm-9">
						<select name="line3_weight" id="line3_weight" class="form-select" required>
							<option value="normal" {{ selected(old('line3_weight') == 'normal') }}>ปกติ</option>
							<option value="bold" {{ selected(old('line3_weight') == 'bold') }}>หนา</option>
						</select>

					</div>
				</div>

				<div class="row mb-3">
					<label for="line3_color" class="col-sm-3 col-form-label text-md-end form-required">สีตัวอักษร</label>
					<div class="col-sm-9">
						<input type="color" name="line3_color" id="line3_color" value="{{ old('line3_color', '#000000') }}" class="form-control" required style="width:80px; height:40px;">

					</div>
				</div>
			</div>
		</div>
		<div class="rounded shadow bg-white text-center p-4 mt-4 mb-4">
			<button type="submit" class="btn btn-web px-4 py-2"><i class="fa-solid fa-floppy-disk me-2"></i>บันทึก</button>
		</div>
	</form>
@endsection
@section('scriptfile')
	<script src="/public/js/bootstrap-datepicker.js"></script>
	<script src="/public/js/bootstrap-datepicker-thai.js"></script>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			$('#date_at').datepicker({
				format: "d MM yyyy",
				maxViewMode: 2,
				language: "th",
				daysOfWeekHighlighted: "0,6",
				autoclose: true
			});
		});
	</script>
@endsection
<?php
unset($_SESSION['old']);
?>
