<?php


namespace App\Http\Services;


use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Service\ProfessionalServiceInterface;

class ProfessionalService implements ProfessionalServiceInterface
{
    private $repository;

    public function __construct(ProfessionalRepositoryInterface $repository)
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
}
