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


$blade = new Cert(\getcwd() . "/..");
$mode = @$_GET["mode"] ?? "index";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "index") {
        $datas = Certificate::all(["id", "name", "num", "user_id"]);
        echo $blade->run('admin.main.index', ["datas" => $datas]);
    } else if ($mode == "create") {
        echo $blade->run('admin.main.create');
    } else if ($mode == "edit") {
        $id = $_GET["id"] ?? 0;
        $data = Certificate::findOrFail($id);
        echo $blade->run('admin.main.edit', ["data" => $data]);
    } else if ($mode == "show") {
        $id = $_GET["id"] ?? 0;
        $data = Certificate::findOrFail($id);
        echo $blade->run('admin.main.show', ["data" => $data]);
    }
    //
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode == "store") {
        $inputData = $_POST;
        $inputData['user_id'] = $_SESSION["ss_id"];
        $result = Certificate::create($inputData);
        if ($result) {
            if (is_uploaded_file($_FILES['bg']['tmp_name'])) {
                $year = $_POST["year"];
                if (!file_exists("../bg/{$year}/")) {
                    mkdir("../bg/{$year}", 0777);
                }
                $ext = pathinfo($_FILES['bg']['name'], PATHINFO_EXTENSION);
                $newname = "../bg/{$year}/{$result->id}.{$ext}";
                move_uploaded_file($_FILES['bg']['tmp_name'], $newname);
                $result->bg = $newname;
                $result->update();
            }
            $_SESSION["ss_success"] = "เพิ่มเกียรติบัตรแล้ว";
            header("Location:/admin/main.php");
        } else {
            $_SESSION["old"] = $_POST;
            header("Location:/admin/main.php?mode=create");
            $_SESSION["ss_error"] = "ไม่สามารถบันทึกได้กรุณาลองอีกครั้ง";
        }
    } else if ($mode == "update") {
        $inputData = $_POST;
        $id = $_GET["id"] ?? 0;
        $result = Certificate::findOrFail($id);
        $result->update($inputData);

        if ($result) {
            if (is_uploaded_file($_FILES['bg']['tmp_name'])) {
                if (!empty($result->bg)) {
                    if (file_exists($result->bg)) {
                        unlink($result->bg);
                    }
                }

                $year = $_POST["year"];
                if (!file_exists("../bg/{$year}/")) {
                    mkdir("../bg/{$year}", 0777);
                }
                $ext = pathinfo($_FILES['bg']['name'], PATHINFO_EXTENSION);
                $newname = "../bg/{$year}/{$result->id}.{$ext}";
                move_uploaded_file($_FILES['bg']['tmp_name'], $newname);
                $result->bg = $newname;
                $result->update();
            }
            header("Location:/admin/main.php?mode=edit&id={$id}");
            $_SESSION["ss_success"] = "บันทึกการแก้ไขเกียรติบัตรแล้ว";
        } else {
            $_SESSION["old"] = $_POST;
            header("Location:/admin/main.php?mode=edit&id={$id}");
            $_SESSION["ss_error"] = "ไม่สามารถบันทึกได้กรุณาลองอีกครั้ง";
        }
    } else if ($mode == "delete") {
        $id = $_GET["id"] ?? 0;
        Certificate::destroy($id);
        $_SESSION["ss_success"] = "ลบเกียรติบัตรเรียบร้อยแล้ว";
        header("Location:/admin/main.php");
    }
}
