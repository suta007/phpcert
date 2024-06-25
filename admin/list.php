<?php
session_start();
if (@$_SESSION["ss_logined"] !== TRUE) {
    header("HTTP/1.1 401 Unauthorized");
    header("Location:/admin/login.php");
    exit;
}

require_once "../vendor/autoload.php";
require "../bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Database\Capsule\Manager as Capsule;

$blade = new Cert(\getcwd() . "/..");
$mode = @$_GET["mode"] ?? "index";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "index") {
        $id = $_GET["id"] ?? 0;
        $cert = Certificate::findOrFail($id);
        $year = $cert->year;
        if ($cert->sheet) {
            $tb_name = 'sheet_' . $year;
            checktable2($tb_name);
            $sheet = new Sheet;
            $sheet->setTable($tb_name);
            $dbsheet = $sheet->where('certificate_id', $id)->first();
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
                //$datas['name'] = $line_of_text[$dbsheet->col];
                //print_r($line_of_text);
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
                //print_r($datas['name']);

                $datas = json_decode(json_encode($datas), false);
            }
        } else {
            $tb_name = 'person_' . $year;
            checktable($tb_name);
            $dbtable = new Person;
            $dbtable->setTable($tb_name);
            $datas = $dbtable->where('certificate_id', $id)->get();
        }
        //return view('user.person.index', compact('cert', 'datas'));
        echo $blade->run('admin.person.index', ["datas" => $datas, 'cert' => $cert]);
    } else if ($mode == "create") {
        $id = $_GET["id"] ?? 0;
        $cert = Certificate::findOrFail($id);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        echo $blade->run('admin.person.create', ['cert' => $cert]);
    } else if ($mode == "edit") {
        $cid = $_GET["cid"] ?? 0;
        $cert = Certificate::findOrFail($cid);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'person_' . $year;
        $dbtable = new Person;
        $dbtable->setTable($tb_name);
        $id = $_GET["id"] ?? 0;
        $data = $dbtable->where('id', $id)->first();

        echo $blade->run('admin.person.edit', ['data' => $data, 'cert' => $cert]);
    } else if ($mode == "show") {
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
                //$cert->link = $dbsheet->link;
                //$cert->col = $dbsheet->col;
                //$cert->pre = $dbsheet->pre;
                $path = explode("/", parse_url($dbsheet->link, PHP_URL_PATH));
                $gid  = $path[3];
                @$url = "https://docs.google.com/spreadsheets/d/" . $gid . "/export?exportFormat=csv";
                $file_handle = @fopen($url, 'r') or die("เปิดไฟล์ไม่ได้!");
                fgetcsv($file_handle);
                while (!feof($file_handle)) {
                    $line_of_text[] = fgetcsv($file_handle);
                }
                fclose($file_handle);
                //$datas['name'] = $line_of_text[$dbsheet->col];
                //print_r($line_of_text);
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

        echo $blade->run('admin.person.show', ["data" => $data, 'result' => $result]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode == "import") {
        $id = $_GET["id"] ?? 0;
        $cert = Certificate::findOrFail($id);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'person_' . $year;
        checktable($tb_name);
        $dbtable = new Person;
        $dbtable->setTable($tb_name);

        if (is_uploaded_file($_FILES['namelist']['tmp_name'])) {
            $ext = pathinfo($_FILES['namelist']['name'], PATHINFO_EXTENSION);
            if ($ext != "csv") {
                header("Location:/admin/list.php?id={$id}");
                $_SESSION["ss_error"] = "ชนิดไฟล์ไม่ถูกต้อง";
                exit();
            }

            $dbtable->where('certificate_id', $id)->delete();

            $csvfile = $_FILES['namelist']['tmp_name'];
            $file = fopen($csvfile, "r");
            fgetcsv($file);
            $i = 1;
            while (($getData = fgetcsv($file, 10000, ",")) !== false) {
                $dbtable->create([
                    'certificate_id' => $id,
                    'name' => $getData[0],
                    'line2' => $getData[1],
                    'line3' => $getData[2],
                    'i' => $i,
                ]);
                $i++;
            }
            fclose($file);
            header("Location:/admin/list.php?id={$id}");
            $_SESSION["ss_success"] = "นำเข้าข้อมูลเรียบร้อยแล้ว";
        }
        //
    } else if ($mode == "store") {
        $id = $_GET["id"] ?? 0;
        $cert = Certificate::findOrFail($id);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'person_' . $year;
        checktable($tb_name);
        $dbtable = new Person;
        $dbtable->setTable($tb_name);

        $inputData = $_POST;
        $inputData["certificate_id"] = $id;
        $dbtable->create($inputData);
        header("Location:/admin/list.php?id={$id}");
        $_SESSION["ss_success"] = "บันทึกข้อมูลเรียบร้อยแล้ว";
        //
    } else if ($mode == "update") {
        $cid = $_GET["cid"] ?? 0;
        $cert = Certificate::findOrFail($cid);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'person_' . $year;
        $dbtable = new Person;
        $dbtable->setTable($tb_name);
        $id = $_GET["id"] ?? 0;
        $result = $dbtable->where('id', $id)->first();
        $inputData = $_POST;
        $result->update($inputData);
        header("Location:/admin/list.php?id={$cid}");
        $_SESSION["ss_success"] = "บันทึกข้อมูลเรียบร้อยแล้ว";
    } else if ($mode == "sheet") {
        $cid = $_GET["cid"] ?? 0;
        $cert = Certificate::findOrFail($cid);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'sheet_' . $year;
        checktable2($tb_name);
        $sheet = new Sheet;
        $sheet->setTable($tb_name);

        $inputData = $_POST;
        $inputData["certificate_id"] = $cid;
        $sheet->updateOrCreate(["certificate_id" => $cid], $inputData);
        header("Location:/admin/list.php?id={$cid}");
        $_SESSION["ss_success"] = "บันทึกข้อมูลเรียบร้อยแล้ว";
    } else if ($mode == "delete") {
        $cid = $_GET["cid"] ?? 0;
        $cert = Certificate::findOrFail($cid);
        if ($_SESSION["ss_id"] != $cert->user_id) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $year = $cert->year;
        $tb_name = 'person_' . $year;
        $dbtable = new Person;
        $dbtable->setTable($tb_name);
        $id = $_GET["id"] ?? 0;
        $result = $dbtable->where('id', $id)->delete();
        header("Location:/admin/list.php?id={$cid}");
        $_SESSION["ss_success"] = "ลบข้อมูลเรียบร้อยแล้ว";
    }
}


function checktable($table)
{
    if (!Capsule::schema()->hasTable($table)) {
        Capsule::schema()->create($table, function ($table) {
            $table->increments('id');
            $table->integer('certificate_id')->unsigned();
            $table->string('name');
            $table->string('line2')->nullable();
            $table->string('line3')->nullable();
            $table->integer('i')->unsigned();
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->timestamps();
        });
    }
}

function checktable2($table)
{
    if (!Capsule::schema()->hasTable($table)) {
        Capsule::schema()->create($table, function ($table) {
            $table->increments('id');
            $table->integer('certificate_id')->unsigned();
            $table->string('link');
            $table->integer('pre')->default(0);
            $table->integer('col')->default(1);
            $table->boolean('test')->default(0);
            $table->integer('score')->default(2);
            $table->integer('pass')->default(0);
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->timestamps();
        });
    }
}
