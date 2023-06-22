<?php
require_once "vendor/autoload.php";
require "bootstrap.php";

use Suta007\PhpCert\Cert;

$blade = new Cert(\getcwd());


$cid = $_GET["cid"] ?? 0;
$id = $_GET["id"] ?? 0;

$data = Certificate::findOrFail($cid);
$year = $data->year;


if ($data->sheet) {
    $tb_name = 'sheet_' . $year;
    $sheet = new Sheet;
    $sheet->setTable($tb_name);
    $dbsheet = $sheet->where('certificate_id', $cid)->first();
    if ($dbsheet === null) {
        $result = null;
    } else {
        $path = explode("/", parse_url($dbsheet->link, PHP_URL_PATH));
        $gid  = $path[3];
        @$url = "https://docs.google.com/spreadsheets/d/" . $gid . "/export?exportFormat=csv";
        $file_handle = @fopen($url, 'r') or die("เปิดไฟล์ไม่ได้!");
        fgetcsv($file_handle);
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle);
        }
        fclose($file_handle);
        $i = 1;
        foreach ($line_of_text as $val) {
            $val_score = (int)preg_split("#/#", $val[$dbsheet->score])[0];
            if (($dbsheet->test == true && $val_score >= $dbsheet->pass) || $dbsheet->test == false) {
                if ($dbsheet->pre > 0) {
                    $arr[$i]['name'] = $val[$dbsheet->pre] . $val[$dbsheet->col];
                } else {
                    $arr[$i]['name'] = $val[$dbsheet->col];
                }
            }
            $arr[$i]['i'] = $i;
            $arr[$i]['id'] = $i;
            $i++;
        }
        //print_r($datas['name']);

        $result = json_decode(json_encode($arr[$id]), false);
        //print_r($result);
    }
} else {
    $tb_name = 'person_' . $year;
    $dbtable = new Person;
    $dbtable->setTable($tb_name);

    $result = $dbtable->where('id', $id)->first();
}


/* $tb_name = 'person_' . $year;
$dbtable = new Person;
$dbtable->setTable($tb_name);
$result = $dbtable->where('id', $id)->first(); */

$pdf = new TCPDF($data->orientation, 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('รูปแบบเกียรติบัตร');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->AddPage();
$config = include 'configs/font.php';
$path = dirname(__FILE__) . '/' . $config['path'][0];

$code_font = $path . '/' . $config['list'][$data->code_font]['R'];
$code_font = TCPDF_FONTS::addTTFfont($code_font, 'TrueTypeUnicode');
$code_fontb = $path . '/' . $config['list'][$data->code_font]['B'];
$code_fontb = TCPDF_FONTS::addTTFfont($code_fontb, 'TrueTypeUnicode');

$name_font = $path . '/' . $config['list'][$data->name_font]['R'];
$name_font = TCPDF_FONTS::addTTFfont($name_font, 'TrueTypeUnicode');
$name_fontb = $path . '/' . $config['list'][$data->name_font]['B'];
$name_fontb = TCPDF_FONTS::addTTFfont($name_fontb, 'TrueTypeUnicode');

$thai = ['๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙'];
$arabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

if ($data->orientation == 'L') {
    $MaxW = 297;
} else {
    $MaxW = 210;
}

if (!empty($data->bg)) {
    $pdf->Image(dirname(__FILE__) . '/' . ltrim($data->bg, '../'), 0, 0, $MaxW, 0, '', '', '', false, 300, '', false, false, 0);
}

//เลขทะเบียน
$code = $data->pattern;
$code = str_replace('[[code]]', $data->code_name, $code);
$code = str_replace('[[num]]', $data->num, $code);
$code = str_replace('[[i]]', sprintf('%0' . $data->i_digit . 'd', $result->i), $code);
$code = str_replace('[[year]]', $data->year, $code);
if ($data->code_number == 'thai') {
    $code = str_replace($arabic, $thai, $code);
}
if ($data->code_weight == 'bold') {
    $pdf->SetFont($code_fontb, 'B', $data->code_size);
} else {
    $pdf->SetFont($code_font, '', $data->code_size);
}
[$r, $g, $b] = sscanf($data->code_color, '#%02x%02x%02x');
$pdf->setColor('text', $r, $g, $b);
$html = "<span style='font-weight:{$data->code_weight}'>{$code}</span>";
$pdf->writeHTMLCell($MaxW - $data->code_right, '', 0, $data->code_top, $html, 0, 0, 0, true, 'R', true);

//ชื่อ
if ($data->name_weight == 'bold') {
    $pdf->SetFont($name_fontb, 'B', $data->name_size);
} else {
    $pdf->SetFont($name_font, '', $data->name_size);
}
[$r, $g, $b] = sscanf($data->name_color, '#%02x%02x%02x');
$pdf->setColor('text', $r, $g, $b);
$html = "<span style='font-weight:{$data->name_weight}'>{$result->name}</span>";
$pdf->writeHTMLCell($MaxW, '', 0, $data->name_top, $html, 0, 0, 0, true, 'C', true);

if ($data->line >= 2) {
    $line2_font = $path . '/' . $config['list'][$data->line2_font]['R'];
    $line2_font = TCPDF_FONTS::addTTFfont($line2_font, 'TrueTypeUnicode');
    $line2_fontb = $path . '/' . $config['list'][$data->line2_font]['B'];
    $line2_fontb = TCPDF_FONTS::addTTFfont($line2_fontb, 'TrueTypeUnicode');
    if ($data->line2_weight == 'bold') {
        $pdf->SetFont($line2_fontb, 'B', $data->line2_size);
    } else {
        $pdf->SetFont($line2_font, '', $data->line2_size);
    }
    [$r, $g, $b] = sscanf($data->line2_color, '#%02x%02x%02x');
    $pdf->setColor('text', $r, $g, $b);
    $html = "<span style='font-weight:{$data->line2_weight}'>{$result->line2}</span>";
    $pdf->writeHTMLCell($MaxW, '', 0, $data->line2_top, $html, 0, 0, 0, true, 'C', true);
}

if ($data->line >= 3) {
    $line3_font = $path . '/' . $config['list'][$data->line3_font]['R'];
    $line3_font = TCPDF_FONTS::addTTFfont($line3_font, 'TrueTypeUnicode');
    $line3_fontb = $path . '/' . $config['list'][$data->line3_font]['B'];
    $line3_fontb = TCPDF_FONTS::addTTFfont($line3_fontb, 'TrueTypeUnicode');
    if ($data->line3_weight == 'bold') {
        $pdf->SetFont($line3_fontb, 'B', $data->line3_size);
    } else {
        $pdf->SetFont($line3_font, '', $data->line3_size);
    }
    [$r, $g, $b] = sscanf($data->line3_color, '#%02x%02x%02x');
    $pdf->setColor('text', $r, $g, $b);
    $html = "<span style='font-weight:{$data->line3_weight}'>{$result->line3}</span>";
    $pdf->writeHTMLCell($MaxW, '', 0, $data->line3_top, $html, 0, 0, 0, true, 'C', true);
}

$pdf_out = $pdf->Output('certificate.pdf', 'S');
$imagick = new Imagick();
$imagick->setResolution(300,300); // eg 300, 300
$imagick->readImageBlob($pdf_out);
//$imagick->setImageFormat('pdf');    // for pdf use 'pdf'

//header('Content-type: application/pdf');
//header('Content-Disposition: attachment; filename="certificate.pdf"');
$imagick->setImageFormat('jpg');
$imagick->setImageCompressionQuality(80);
header('Content-Type: image/jpeg');
echo $imagick; // put to broswer
/*
$im = new imagick('file.pdf[0]');
$im->setImageFormat('jpg');
header('Content-Type: image/jpeg');
echo $im;
*/