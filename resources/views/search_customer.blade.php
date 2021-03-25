@extends('layouts.app')

@section('content')
    <body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="customer-name">Customer name</label>
                    <select class="form-control form-control-lg" id="customer-name">
                        @foreach($customersNames as $customerName)
                            <option>{{$customerName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <button type="button" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection