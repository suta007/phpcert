<?php
require "../bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('certificates', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->integer('user_id')->unsigned();
    $table->string('date_at', 100);
    $table->boolean('sheet')->default(0);

    $table->string('code_name')->default('สุตะ');
    $table->string('num')->default('001');
    $table->string('year');
    $table->string('pattern')->default('[[code]].[[num]]-[[i]]/[[year]]');
    $table->integer('code_right')->default(15);
    $table->integer('code_top')->default(5);
    $table->string('code_font')->default('sarabun');
    $table->integer('code_size')->default(18);
    $table->string('code_number')->default('thai'); //thai, arabic
    $table->string('code_color')->default('#000000');
    $table->string('code_weight')->default('normal');
    $table->integer('i_digit')->default(3);

    $table->integer('name_top')->default(85);
    $table->string('name_font')->default('sarabun');
    $table->integer('name_size')->default(48);
    $table->string('name_color')->default('#000000');
    $table->string('name_weight')->default('bold');

    $table->integer('line2_top')->default(105);
    $table->string('line2_font')->default('sarabun');
    $table->integer('line2_size')->default(24);
    $table->string('line2_color')->default('#000000');
    $table->string('line2_weight')->default('bold');

    $table->integer('line3_top')->default(125);
    $table->string('line3_font')->default('sarabun');
    $table->integer('line3_size')->default(24);
    $table->string('line3_color')->default('#000000');
    $table->string('line3_weight')->default('bold');

    $table->string('orientation')->default('L');
    $table->integer('line')->default(1);
    $table->string('bg')->nullable();
    $table->timestamps();
});
