<?php
session_start();
if (@$_SESSION["ss_logined"] !== TRUE) {
    header("HTTP/1.1 401 Unauthorized");
    header("Location:/admin/login.php");
    exit;
}

require_once "vendor/autoload.php";
require "bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Hashing\BcryptHasher;

$blade = new Cert(\getcwd());
$mode = @$_GET["mode"] ?? "index";
$hash = new BcryptHasher();
$id = $_SESSION["ss_id"];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "edit") {
        $data = User::findOrFail($id);
        echo $blade->run('user.profile.edit', ["data" => $data]);
    } else if ($mode == "editpass") {
        echo $blade->run('user.profile.editpass');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode == "update") {
        $inputData = $_POST;
        $result = User::findOrFail($id);
        $result->update($inputData);
        $_SESSION["ss_name"] = $result->name;
        if ($result) {
            $_SESSION["ss_success"] = "บันทึกข้อมูลแล้ว";
        } else {
            $_SESSION["old"] = $_POST;
            $_SESSION["ss_error"] = "ไม่สามารถบันทึกได้กรุณาลองอีกครั้ง";
        }
        header("Location:/user.php?mode=edit");
    } else if ($mode == "updatepass") {
        $user = User::findOrFail($id);
        if (!$hash->check($_POST["current_password"], $user->password)) {
            $_SESSION["ss_error"] = "รหัสผ่านเดิมไม่ถูกต้อง";
            header("Location:/user.php?mode=editpass");
            exit;
        }

        if ($_POST["password"] != $_POST["password_confirmation"]) {
            $_SESSION["ss_error"] = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน";
            header("Location:/user.php?mode=editpass");
            exit;
        }

        $user->password = $hash->make(trim($_POST["password"]));
        $user->save();
        $_SESSION["ss_success"] = "เปลี่ยนรหัสผ่านแล้ว";
        header("Location:/user.php?mode=editpass");
    }
}
