<?php
session_start();
require_once "../vendor/autoload.php";
require "../bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Database\Capsule\Manager as Capsule;

$blade = new Cert(\getcwd() . "/..");
$mode = @$_GET["mode"] ?? "index";
$hash = new BcryptHasher();

if (Capsule::schema()->hasTable('users')) {
    $error = 'เว็บไซต์นี้ถูกติดตั้งแล้ว!<br>หากต้องการติดตั้งอีกครั้ง กรุณาลบทุกตารางในฐานข้อมูล';
    echo $blade->run('setup', ["error" => $error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($mode == "index") {
        echo $blade->run('setup');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode == "store") {

        require_once('../databases/user.php');
        require_once('../databases/certificate.php');

        $inputData = $_POST;
        $inputData['password'] = $hash->make(trim($_POST["password"]));
        $result = User::create($inputData);
        if ($result) {
            $_SESSION["ss_error"] = "สร้างผู้ดูแลระบบแล้ว";
            header("Location:/admin/login.php");
        }
    }
}
