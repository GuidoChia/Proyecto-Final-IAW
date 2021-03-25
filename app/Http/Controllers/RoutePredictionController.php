<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Section;
use App\Services\RouteOptimizationService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class RoutePredictionController extends Controller
{
    protected $optimizationService;

    /**
     * Create a new controller instance.
     *
     * @param RouteOptimizationService $service
     */
    public function __construct(RouteOptimizationService $service)
    {
        $this->optimizationService = $service;
        $this->middleware('auth');
    }

    /**
     * Creates the route prediction view
     * @return View
     */
    public function index()
    {
        $sections = Section::all();
        return view('route_prediction')->withSections($sections);
    }

    /**
     * Predicts the customers that could buy in the given date, gets the addresses,
     * and redirects to a view showing the results.
     * @param Request $request
     * @return mixed result view
     */
    public function predictDate(Request $request)
    {
        $date = $request->input('date');
        $sectionName = $request->input('section');
        $customers = Customer::findBySection($sectionName);

        $predictedCustomers = $customers->filter(function ($value, $key) use ($date) {
            return $value->predictBuy(date_create_from_format('d/m/Y', $date));
        });

        $origin = Customer::findByName('Municipalidad')->first()->address;
        $destination = Customer::findByName('Municipalidad')->first()->address;

        $predictedAddresses = $this->optimizationService->optimizeRoute($origin, $destination, $this->getAdresses($predictedCustomers));
        $jsPredictedAdresses = $this->addressesToJS($predictedAddresses);
        return view('route_prediction_date')
            ->withPredictedAddresses($jsPredictedAdresses)
            ->withPredictedCustomers($predictedCustomers)
            ->withCenter($origin);
    }

    private function getAdresses(Collection $customers)
    {
        return $customers->filter(function ($value, $key){
            return $value->address!=null;
        })->map(function ($value, $key){
            return $value->address;
        });

    }

    private function addressesToJS($addresses)
    {
        $res = '[';
        foreach ($addresses as $address) {
            $res = $res . $this->addressToJS($address) . ',';
        }
        $res = $res . ']';
        return $res;
    }

    private function addressToJS(Address $address)
    {
        return '{lng:' . $address->lon .
            ', lat:' . $address->lat .
            ', name:"' . $address->description . '"}';
    }

}
