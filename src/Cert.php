<?php

namespace Suta007\PhpCert;

use eftec\bladeone\BladeOne;


class Cert extends BladeOne
{
    function __construct($path = null)
    {
        if ($path === null) {
            $path = \getcwd();
        }
        $views = $path . '/views';
        $cache = $path . '/cache';
        parent::__construct($views, $cache, BladeOne::MODE_AUTO);
    }
}
