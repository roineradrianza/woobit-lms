<?php
namespace Controller;

header('Content-Type: text/html; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Controller\{Template, Routes, Helper, KeepSession};

class App
{
    public function __construct()
    {
        new KeepSession();
        new Routes();
    }
}
