<?php
session_start();
if (@$_SESSION["ss_logined"] !== TRUE) {
    header("HTTP/1.1 401 Unauthorized");
    header("Location:/admin/login.php");
    exit;
}

if (@$_SESSION["ss_type"] != "admin") {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

require_once "../vendor/autoload.php";
require "../bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Hashing\BcryptHasher;

$blade = new Cert(\getcwd() . "/..");
$mode = @$_GET["mode"] ?? "index";
$hash = new BcryptHasher();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "index") {
        $datas = User::all();
        echo $blade->run('admin.user.index', ["datas" => $datas]);
    } else if ($mode == "create") {
        echo $blade->run('admin.user.create');
    } else if ($mode == "edit") {
        $id = $_GET["id"] ?? 0;
        $data = User::findOrFail($id);
        echo $blade->run('admin.user.edit', ["data" => $data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode == "store") {

        $inputData = $_POST;
        $inputData['password'] = $hash->make(trim($_POST["password"]));
        $result = User::create($inputData);
        if ($result) {
            $_SESSION["ss_success"] = "เพิ่มผู้ใช้งานแล้ว";
            header("Location:/admin/user.php");
        } else {
            $_SESSION["old"] = $_POST;
            header("Location:/admin/user.php?mode=create");
            $_SESSION["ss_error"] = "ไม่สามารถบันทึกได้กรุณาลองอีกครั้ง";
        }
    } else if ($mode == "update") {
        $inputData = $_POST;
        $id = $_GET["id"] ?? 0;
        $result = User::findOrFail($id);
        if (empty($_POST["password"])) {
            unset($inputData["password"]);
        } else {
            $inputData['password'] = $hash->make(trim($_POST["password"]));
        }

        $result->update($inputData);

        if ($result) {
            header("Location:/admin/user.php?mode=edit&id={$id}");
            $_SESSION["ss_success"] = "บันทึกข้อมูลแล้ว";
        } else {
            $_SESSION["old"] = $_POST;
            header("Location:/admin/user.php?mode=edit&id={$id}");
            $_SESSION["ss_error"] = "ไม่สามารถบันทึกได้กรุณาลองอีกครั้ง";
        }
    } else if ($mode == "delete") {
        $id = $_GET["id"] ?? 0;
        User::destroy($id);
        $_SESSION["ss_success"] = "ลบผู้ใช้งานเรียบร้อยแล้ว";
        header("Location:/admin/user.php");
    }
}
