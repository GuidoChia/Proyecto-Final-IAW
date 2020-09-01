@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('prediction-date')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <select></select>
                </div>
                <div class="col">
                    <datepicker
                            id="date"
                            name="date"
                            value="{{now()}}"
                            format="dd/MM/yyyy"
                    ></datepicker>
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="submit">Predict route</button>
                </div>
            </div>
        </form>
    </div>
@endsection
