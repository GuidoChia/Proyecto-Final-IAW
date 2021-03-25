<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class SearchCustomerController extends Controller
{
    public function index()
    {
        return view('search_customer')->withCustomersNames(Customer::getCustomerNamesAsArray());
    }

    public function searchCustomer($Request){

    }
}
