<?php

namespace App\Lib;

use Carbon\Exceptions\Exception;

class Erro
{
    private $message;
    private $code;

    public function __construct($objetoException = Exception::class)
    {
        $this->code = $objetoException->getCode();
        $this->message = $objetoException->getMessage();
    }

    public function render()
    {
        $varMessage = $this->message;

        if (file_exists(PATH . "/App/Views/error/" . $this->code . ".php")) {
            require_once PATH . "/App/Views/error/" . $this->code . ".php";
        } else {
            require_once PATH . "/App/Views/error/500.php";
        }
        exit;
    }
}
