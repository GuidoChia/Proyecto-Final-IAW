@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('prediction-date')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="sectionSelect">Section</label>
                        <select id="section"
                                name="section"
                                class="form-control form-control-lg">
                            <option>All</option>
                            @foreach($sections as $section)
                                <option>{{$section->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <datepicker input-class="form-control form-control-lg"
                                    id="date"
                                    name="date"
                                    value="{{now()}}"
                                    format="dd/MM/yyyy"
                        ></datepicker>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <button id="predictButton" class="btn btn-primary" type="submit">Predict route</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
