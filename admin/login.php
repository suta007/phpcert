<?php
session_start();
require_once "../vendor/autoload.php";
require "../bootstrap.php";

use Suta007\PhpCert\Cert;
use Illuminate\Hashing\BcryptHasher;

$blade = new Cert(\getcwd() . "/..");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (@$_SESSION["ss_logined"] == TRUE) {
        header("Location:/admin/main.php");
    } else {
        echo $blade->run('admin.auth.login');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_GET["mode"] == "auth") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = User::where("username", $username)->first();
        if (!empty($user)) {
            $hash = new BcryptHasher();
            if ($hash->check($password, $user->password)) {
                $_SESSION["ss_logined"] = TRUE;
                $_SESSION["ss_id"] = $user->id;
                $_SESSION["ss_type"] = $user->type;
                $_SESSION["ss_name"] = $user->name;
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                header("Location:/admin/main.php");
                die();
            } else {
                $_SESSION["ss_error"] = "รหัสผ่านไม่ถูกต้อง";
            }
        } else {
            $_SESSION["ss_error"] = "ไม่พบ username";
        }
        header("Location:/admin/login.php");
    }
}
