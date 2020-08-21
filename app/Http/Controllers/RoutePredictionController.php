<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use Illuminate\Http\Request;

class RoutePredictionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('route_prediction');
    }

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
        $predictedAddresses = $this->customersAddressesToJS($predictedCustomers);
        $origin = $this->addressToJS(Customer::findByName('Municipalidad')->first()->address);
        $destination = $this->addressToJS(Customer::findByName('Abuela Tita')->first()->address);
        return view('route_prediction_date')
            ->withPredictedAddresses($predictedAddresses)
            ->withPredictedCustomers($predictedCustomers)
            ->withOrigin($origin)
            ->withDestination($destination);
    }

    private function customersAddressesToJS($customers)
    {
        $res = '[';
        foreach ($customers as $customer) {
            $address = $customer->address;
            if ($address != null) {
                $res = $res . $this->addressToJS($address).',';
            }
        }
        $res = $res . ']';
        return $res;
    }

    private function addressToJS(Address $address){
        return '{lng:' . $address->lon . ', lat:' . $address->lat . '}';
    }

}
