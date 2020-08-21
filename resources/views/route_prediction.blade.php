@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('prediction-date')}}" method="POST">
            @csrf
            <datepicker
                    name="date"
                    value="{{now()}}"
                    format="dd/MM/yyyy"
            ></datepicker>
            <button class="btn btn-primary" type="submit">Predict route</button>
        </form>
    </div>
@endsection
