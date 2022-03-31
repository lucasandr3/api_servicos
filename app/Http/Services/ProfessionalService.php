<?php


namespace App\Http\Services;


use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\ProductsProfessionalRepositoryInterface;
use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Service\ProductsProfessionalServiceInterface;
use App\Http\Interfaces\Service\ProfessionalServiceInterface;
use App\Http\Interfaces\Service\UserServiceInterface;
use App\Models\UserAppoitments;

class ProfessionalService implements ProfessionalServiceInterface
{
    private $repository;
    private $professionalRepository;

    public function __construct
    (
        ProfessionalRepositoryInterface $repository,
        ProductsProfessionalRepositoryInterface $professionalRepository
    )
    {
        $this->repository = $repository;
    }

    public function allProfessionals($request)
    {
        $location = 'São Paulo';
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $city = $request->input('city');
        $offset = $request->input('offset');

        if (!$offset) {
            $offset = 0;
        }

        // filtro de localizacao
        if (!empty($city)) {
            $response = $this->searchGeo($city);

            if (sizeof($response) > 0) {
                $data = (object)$response['data'][0];
                $latitude = $data->latitude;
                $longitude = $data->longitude;
            }

        } elseif (!empty($latitude) && !empty($longitude)) {
            $response = $this->searchGeo("{$latitude},{$longitude}");

            if (sizeof($response) > 0) {
                $data = (object)$response['data'][0];
                $city = $data->locality;
            }

        } else {
            $latitude = '-23.5630907';
            $longitude = '-46.6682795';
            $city = 'São Paulo';
        }

        $professionals = $this->repository->getProfessionals($latitude, $longitude, $offset)->toArray();

        return ['error' => '', 'data' => $professionals, 'location' => $location];
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

        if (!$professional) {
            return response()->json(['error' => 'Profissional não encontrado'], 401);
        }

        $filterDataIntervalAppointments = [
            date('Y-m-d') . ' 00:00:00',
            date('Y-m-d', strtotime('+20 days')) . ' 23:59:59'
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

    public function newAppointment(int $professional, object $request)
    {
        $service = $request->input('service');
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $hour = $request->input('hour');

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        $day = str_pad($day, 2, "0", STR_PAD_LEFT);
        $hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
        $apDate = "{$year}-{$month}-{$day} {$hour}:00:00";

        // todo: verificar se o service do profissional existe
        $isExistsProfessional = $this->repository->isExistsProfessional($service, $professional);

        if ($isExistsProfessional) {

            // todo: verificar se a data e real
            if (!strtotime($apDate) > 0) {
                return response()->json(['error' => 'Data Inválida.']);
            }

            // todo: verificar se o profissional ja possui agendamento neste dia/hora
            $appoitments = $this->repository->getAppointmentsByProfessionalCount($professional, $apDate);
            if ($appoitments > 0) {
                return response()->json(['error' => 'Horário/dia indisponivel!']);
            }

            // todo: verificar se o profissional atende nesta data
            $weekDay = date('w', strtotime($apDate));
            $avail = $this->repository->getWeekDayByProfessional($professional, $weekDay);

            if (!$avail) {
                return response()->json(['error' => 'O Profissional não atende neste dia.']);
            }

            // todo: verificar se o profissional atende nesta hora
            $hours = explode(',', $avail['hours']);
            if (!in_array($hour . ':00', $hours)) {
                return response()->json(['error' => 'O Profissional não atende nesta hora.']);
            }

            // todo: fazer o agendamento
            $newApp = new UserAppoitments();
            $newApp->user_id = auth()->user()->getAuthIdentifier();
            $newApp->professional_id = $professional;
            $newApp->id_service = $service;
            $newApp->ap_datetime = $apDate;

            return $this->repository->saveAppointments($newApp);

        } else {
            return response()->json(['error' => 'Serviço Não Existe.']);
        }

    }

    public function searchProfessional(object $request)
    {
        $query = $request->input('query');

        if(!$query) {
            return response()->json(['error' => 'Digite algo para buscar.']);
        }

        $professionals = $this->repository->searchProfessionals($query);
        return response()->json(['error' => '', 'list' => $professionals]);
    }
}
