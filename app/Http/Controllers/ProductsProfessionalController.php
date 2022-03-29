<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\ProductsProfessionalServiceInterface;
use Illuminate\Http\Request;

class ProductsProfessionalController extends Controller
{
    private $service;

    public function __construct
    (
        ProductsProfessionalServiceInterface $service
    )
    {
        $this->service = $service;
    }
}
