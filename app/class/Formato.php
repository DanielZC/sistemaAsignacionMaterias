<?php

namespace App\Class;

class Formato
{
    public function __construct()
    {

    }

    public function inicialesMayuscula($texto)
    {
        $formatoTexto = trim(ucwords(strtolower($texto)));

        return $formatoTexto;
    }

    public function minusculas($texto)
    {
        $formatoTexto = trim(strtolower($texto));
        
        return $formatoTexto;
    }

    public function pirmeraMayuscula($texto)
    {
        $formatoTexto = trim(ucfirst(strtolower($texto)));
        
        return $formatoTexto;
    }
}
