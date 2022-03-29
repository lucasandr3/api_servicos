<?php


namespace App\Http\Services;


use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Service\ProfessionalServiceInterface;
use App\Http\Interfaces\Service\UserServiceInterface;

class ProfessionalService implements ProfessionalServiceInterface
{
    private $repository;

    public function __construct
    (
        ProfessionalRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function allProfessionals($request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $city = $request->input('city');
        $offset = $request->input('offset');

        if(!$offset) {
            $offset = 0;
        }

        // filtro de localizacao
        if(!empty($city)) {
            $response = $this->searchGeo($city);

            if(sizeof($response) > 0) {
                $data = (object)$response['data'][0];
                $latitude = $data->latitude;
                $longitude = $data->longitude;
            }

        } elseif (!empty($latitude) && !empty($longitude)) {
            $response = $this->searchGeo("{$latitude},{$longitude}");

            if(sizeof($response) > 0) {
                $data = (object)$response['data'][0];
                $city = $data->locality;
            }

        } else {
            $latitude = '-23.5630907';
            $longitude = '-46.6682795';
            $city = 'São Paulo';
        }

        $professionals = $this->repository->getProfessionals($latitude, $longitude, $offset)->toArray();

        return ['error' => '', 'data' => $professionals];
    }

    private function searchGeo($address)
    {
        $key = env('MAPS_KEY', null);
        $endpoint = "http://api.positionstack.com/v1";

        $queryString = http_build_query([
            'access_key' => $key,
            'query' => $address,
            'output' => 'json',
            'limit' => 1,
        ]);

        $ch = curl_init(sprintf('%s?%s', "{$endpoint}/forward", $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        return json_decode($json, true);
    }

    public function getProfessional(int $professional)
    {
        $professional = $this->repository->getProfessionalByID($professional);

        if(!$professional) {
            return response()->json(['error' => 'Profissional não encontrado'], 401);
        }

        $filterDataIntervalAppointments = [
            date('Y-m-d').' 00:00:00',
            date('Y-m-d', strtotime('+20 days')).' 23:59:59'
        ];

        $appointments = $this->getAppointmentsByProfessional($professional->id, $filterDataIntervalAppointments);
        $availsWeekdays = Helpers::decodeAvailability($professional->availability()->getResults()->toArray(), $appointments);
        $isFavorite = $this->repository->isFavorite(auth()->user()->getAuthIdentifier(), $professional->id);

        $professional->favorited = $isFavorite > 0;
        $professional->photos = $professional->photos()->get();
        $professional->services = $professional->services()->get();
        $professional->testimonials = $professional->testimonials()->get();
        $professional->available = $availsWeekdays;

        return response()->json(['error' => '', 'data' => $professional], 200);
    }

    public function getAppointmentsByProfessional(int $profesisonal, array $filter)
    {
        return $this->repository->getAppointmentsByProfessional($profesisonal, $filter);
    }
}
