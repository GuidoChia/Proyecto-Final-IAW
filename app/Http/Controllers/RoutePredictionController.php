<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Services\RouteOptimizationService;
use Illuminate\Http\Request;

class RoutePredictionController extends Controller
{
    protected $optimizationService;

    /**
     * Create a new controller instance.
     *
     * @param RouteOptimizationService $optimizationService
     */
    public function __construct(RouteOptimizationService $service)
    {
        $this->optimizationService = $service;
        $this->middleware('auth');
    }

    /**
     * Creates the route prediction view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('route_prediction');
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
        $customers = Customer::all();
        $predictedCustomers = collect([]);
        foreach ($customers as $customer) {
            if ($customer->predictBuy(date_create_from_format('d/m/Y', $date))) {
                $predictedCustomers->add($customer);
            }
        }
        $origin = Customer::findByName('Municipalidad')->first()->address;
        $destination = Customer::findByName('Municipalidad')->first()->address;
        $predictedAddresses = $this->optimizationService->optimizeRoute($origin, $destination, $this->getAdresses($predictedCustomers));
        $jsPredictedAdresses = $this->addressesToJS($predictedAddresses);
        return view('route_prediction_date')
            ->withPredictedAddresses($jsPredictedAdresses)
            ->withPredictedCustomers($predictedCustomers)
            ->withCenter($origin);
    }

    private function getAdresses($customers)
    {
        $res = collect([]);
        foreach ($customers as $customer) {
            $address = $customer->address;
            if ($address != null) {
                $res->add($address);
                dd($address);
            }
        }
        return $res;
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
            ', name:"'.$address->description.'"}';
    }

}
