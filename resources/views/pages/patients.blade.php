@extends('layouts.myApp')
@section('template')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <div class="row mb-2">
        <div class="col-3">
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-ID-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-Name-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-Phone-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->phone }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <script>
        function selectName(sel){
            var id = sel.options[sel.selectedIndex].value;
            window.location.href = '/Dr.%20Anas%20Project%20System/202209131630/khorisk/patient/'+id;
        }
        // Material Select Initialization
        $(document).ready(function () {
            $("select").select2();
        });
        // In your Javascript (external .js resource or <script> tag)

    </script>
@endsection
