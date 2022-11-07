<?php
session_start();
require_once "vendor/autoload.php";
require "bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Hashing\BcryptHasher;


$blade = new Cert();
$hash = new BcryptHasher();

$mode = @$_GET["mode"] ?? "index";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "index") {
        echo $blade->run('home.index');
    } else if ($mode == "getproject") {
        $year = $_GET["year"];
        $datas = Certificate::select('id', 'name')->where('year', $year)->get();
        echo json_encode($datas, JSON_UNESCAPED_UNICODE);
    } else if ($mode == "getcert") {
        $year = $_GET["year"];
        $cid = $_GET["cid"];
        $cert = Certificate::findOrFail($cid);
        $year = $cert->year;
        if ($cert->sheet) {
            $tb_name = 'sheet_' . $year;
            $sheet = new Sheet;
            $sheet->setTable($tb_name);
            $dbsheet = $sheet->where('certificate_id', $cid)->first();
            if ($dbsheet === null) {
                $datas = null;
            } else {
                $cert->link = $dbsheet->link;
                $cert->col = $dbsheet->col;
                $cert->pre = $dbsheet->pre;
                $cert->test = $dbsheet->test;
                $cert->score = $dbsheet->score;
                $cert->pass = $dbsheet->pass;

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
                            $datas[$i]['name'] = $val[$dbsheet->pre] . $val[$dbsheet->col];
                        } else {
                            $datas[$i]['name'] = $val[$dbsheet->col];
                        }
                        $datas[$i]['i'] = $i;
                        $datas[$i]['id'] = $i;
                        $i++;
                    }
                }
                $datas = json_decode(json_encode($datas), false);
            }
        } else {
            $tb_name = 'person_' . $year;
            $dbtable = new Person;
            $dbtable->setTable($tb_name);
            $datas = $dbtable->where('certificate_id', $cid)->get();
        }
        echo $blade->run('home.certlist', ['datas' => $datas, 'cid' => $cid, 'year' => $year]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST";
}
