<?php

namespace App\Models\Constants;

enum TipoPermissao: int
{
    case ADMINISTRATIVO = 1;
    case PADRAO = 2;
}
