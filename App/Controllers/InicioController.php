<?php

namespace App\Controllers;

use App\Abstractions\Controller;

class InicioController extends Controller
{
    public function index(): void
    {
        $this->render('Inicio/Index');
    }
}
