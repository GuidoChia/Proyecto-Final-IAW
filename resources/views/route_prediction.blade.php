@extends('layouts.app')

@section('content')
    <div class="container">
        <prediction-map
                apikey="{{env('HERE_JS_API_KEY')}}"
                v-bind:center="{lng:-63.7724862, lat: -37.3772748}"
                width="100%"
                height="835px"
                v-bind:origin="{lng:-63.7724862, lat: -37.3772748}"
                v-bind:destination="{lng:-63.7744862, lat: -37.3772748}"
                v-bind:waypoints="[1,2]"
        ></prediction-map>
    </div>

@endsection
