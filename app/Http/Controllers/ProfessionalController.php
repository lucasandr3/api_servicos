<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\ProfessionalServiceInterface;
use App\Models\Professional;
use App\Models\ProfessionalAvailability;
use App\Models\ProfessionalPhotos;
use App\Models\ProfessionalServices;
use App\Models\ProfessionalTestimonials;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    private $service;

    public function __construct
    (
        ProfessionalServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        return $this->service->allProfessionals($request);
    }

    public function one($professional)
    {
       return $this->service->getProfessional($professional);
    }

    public function setAppointment($professional, Request $request)
    {
        return $this->service->newAppointment($professional, $request);
    }

    public function search(Request $request)
    {
        return $this->service->searchProfessional($request);
    }
}
