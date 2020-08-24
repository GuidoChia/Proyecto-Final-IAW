<?php


namespace App\Services;


use App\Address;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Class OpenRouteService
 * Implements the RouteOptimizationService interface using openrouteservice API
 * @package App\Services
 */
class OpenRouteService implements RouteOptimizationService
{
    /**
     * @inheritDoc
     */
    function optimizeRoute(Address $origin, Address $destination, Collection $addresses)
    {
        $response = $this->getApiResponse($addresses, $origin, $destination);
        if ($response->failed()){
            return collect([]);
        }
        return $this->getAddresesFromResponse($response, $origin, $destination);
    }

    /**
     * @param Collection $addresses
     * @param Address $origin
     * @param Address $destination
     * @return mixed
     */
    private function getApiResponse(Collection $addresses, Address $origin, Address $destination)
    {
        $jobs = '[';
        $skills = '[1]';
        foreach ($addresses as $address) {
            $id = '' . $address->id;
            $location = '[' . $address->lon . ',' . $address->lat . ']';
            $currentJob = '{"id":' . $id . ',"location":' . $location . ',"skills":' . $skills;
            $jobs = $jobs . $currentJob . '}';
            if ($address != $addresses->last()) {
                $jobs = $jobs . ',';
            }
        }
        $jobs = $jobs . ']';
        $originLocation = '[' . $origin->lon . ',' . $origin->lat . ']';
        $destinationLocation = '[' . $destination->lon . ',' . $destination->lat . ']';
        $vehicles = '[{"id":1,"profile":"driving-car","start":' .
            $originLocation . ',"end":' . $destinationLocation .
            ',"capacity":[4],"skills":' . $skills . '}]';


        $response = Http::withBody('{"jobs":' . $jobs . ',"vehicles":' . $vehicles . '}', 'application/json')
            ->withToken(env('OPEN_ROUTE_API_KEY'))
            ->post('https://api.openrouteservice.org/optimization');
        return $response;
    }

    private function getAddresesFromResponse(Response $response, Address $origin, Address $destination)
    {
        $res = collect([]);
        $route = $response->object()->routes[0]->steps;
        foreach ($route as $stop) {
            if ($stop->type == "start") {
                $res->add($origin);
            } elseif ($stop->type == "end") {
                $res->add($destination);
            } else {
                $res->add(Address::find($stop->id));
            }
        }
        return $res;
    }


}