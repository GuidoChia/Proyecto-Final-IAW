@extends('layouts.app')

@section('content')
    <div class="container">
        <prediction-map
                apikey="{{env('HERE_JS_API_KEY')}}"
                v-bind:center="{lng:-63.7724862, lat: -37.3772748}"
                width="100%"
                height="835px"
                v-bind:origin="{{$origin}}"
                v-bind:destination="{{$destination}}"
                v-bind:waypoints="{{$predictedAddresses}}"
        ></prediction-map>
    </div>

    <div class="container">
        <table class="table table-striped animated fadeIn" >
            <thead>
            <tr>
                <th>Customer</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @foreach($predictedCustomers as $customer)
                <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->balance}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
