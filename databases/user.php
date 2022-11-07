<?php
require "../bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('username', 100)->unique();
    $table->string('password');
    $table->string('name', 100);
    $table->string('email')->unique()->nullable();
    $table->string('type', 50)->nullable()->default('user');
    $table->timestamp('last_login')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
