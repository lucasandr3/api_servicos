<?php


namespace App\Http\Interfaces\Repository;


interface OpcoesRepositoryInterface
{
    public function opcoesByAdicional($adicional, $produto);
}
