@extends('layouts.myApp')
@section('template')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <div class="row mb-2">
        <div class="col-3">
            <div style="font-size: 18px;">Select by ID:</div>
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-ID-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" @if($patient->id==$show->id) {{'selected'}} @endif>{{ $patient->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <div style="font-size: 18px;">Select by Name:</div>
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-Name-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" @if($patient->id==$show->id) {{'selected'}} @endif>{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <div style="font-size: 18px;">Select by Phone:</div>
            <select class="select2 form-control" onchange="selectName(this)">
                <option disabled selected><small>-Phone-</small></option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" @if($patient->id==$show->id) {{'selected'}} @endif>{{ $patient->phone }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <div style="">	&nbsp;</div>
            <button data-toggle="modal" data-target="#AppointmentModalLabel" class="btn btn-primary w-100 " type="submit"> Appointment</button>
        </div>
    </div>

    <!-- Button trigger modal -->

        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Cases</th>
                <th>Appointment Date</th>
                <th>To Dr.</th>
                <th>Status</th>
                <th>Note</th>
                <th>Cost</th>
                <th>Payment</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($apps as $app)
                <tr>
                    <td id="id">{{ $app->id }}</td>
                    <td id="name">
                        {{ $show->name }}
                    </td>
                    <td id="caseName">
                        @php

                        $as = explode(',',$app->cid);
                           // print_r($a);

                        @endphp

                        @foreach($as as $a)
                            @foreach($sicks as $sick)
                                @if($sick->id == $a)
                                    {{ $sick->caseName }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td id="date">{{ $app->appointmentDate }}</td>
                    <td id="drName">
                        @foreach($drs as $dr)
                            @if($dr->id == $app->toDr )
                                {{ $dr->drName }}
                            @endif
                        @endforeach
                    </td>
                    <td>

                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                {{ $app->status }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Confirm</a>
                                <a class="dropdown-item" href="#">Reject</a>
                            </div>
                        </div>

                    </td>
                    <td id="note">{{ $app->note }}</td>
                    @php
                        $sumOfCost = 0;
                    @endphp
                    @foreach($as as $a)
                        @foreach($sicks as $sick)
                            @if($sick->id == $a)
                                @php
                                    $sumOfCost = $sumOfCost + $sick->cost;
                                @endphp
                            @endif
                        @endforeach
                    @endforeach
                    <td id="cost">
                        {{ str_replace(' ','',$sumOfCost) }}
                    </td>
                    <td>
                        <a href="" class="payment btn btn-primary" data-toggle="modal" data-target="#paymentModalU" data-original-title="Edit user">
                            <span data-toggle="modal" data-target="#gfgmodal" class="material-icons-round">PAYMENT</span>
                        </a>
                    </td>
                    <td>
                        <a href="" class="edit btn btn-primary " data-toggle="modal" data-target="#updateModal" data-original-title="Edit user">
                            <span data-toggle="modal" data-target="#gfgmodal" class="material-icons-round">EDIT</span>
                        </a>
                    </td>
                    <td><a href="" class="btn btn-danger">DELETE</a></td>

                </tr>
            @endforeach
            </tbody>
        </table>




    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="AppointmentModalLabel" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-primary text-white">
                    <h5 class="modal-title" id="paymentModalLabel">APPOINTMENT - {{ ucwords($show->name) }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('appointmentStore') }}">
                    @method('post')
                    @csrf
                    <div class="modal-body" style="background-color: #fcfcfc">


                        <div class="row">
                            <div class="col-6">
                                <div style="font-size: 20px;">Select the case</div>
                                <select class="form-control" style="width: 340px;" multiple="multiple" name="cid[]">
                                    @foreach($sicks as $sick)
                                        <option value="{{ $sick->id }}">{{ $sick->caseName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <div style="font-size: 20px;">Doctor Name </div>
                                <select class="form-control select2 w-100" style="width: 340px;" name="toDr">
                                    @foreach($drs as $dr)
                                        <option value="{{ $dr->id }}">{{ $dr->drName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-6">
                                    <div style="font-size: 20px;">Appointment Date </div>
                                    <input type='datetime-local' name="appointmentDate" class="form-control border border-dark p-2">
                                </div>

                                <div class="col-6">
                                    <div style="font-size: 20px;">Note </div>
                                    <input type='text' name="note" class="form-control border border-dark p-2">
                                </div>
                            </div>

                        <input type='hidden' name="pid" value="{{ $show->id }}">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">PAYMENT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="">
                    @method('post')
                    @csrf
                    <div class="modal-body">


                        <div class="row">
                            <div class="col">
                                <label>Total Amount: </label>
                                <input type="text" id="totalAmount" name="totalAmount" class="form-control" readonly value="" style="padding:5px; ;font-size: 16px;border:1px solid #1A73E8;">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label>Discount</label>
                                <input id="discount" type="number" name="discount" class="form-control" style="padding:5px; ;font-size: 16px;border:1px solid #1A73E8;">
                            </div>
                            <div class="col">
                                <label>Pay</label>
                                <input type="number" id="pay" name="paid" class="form-control" style="padding:5px; ;font-size: 16px;border:1px solid #1A73E8;">
                            </div>
                            <div class="col">
                                <label>Remain</label>
                                <input type="number" id="remain" readonly name="remain" class="form-control" style="padding:5px; ;font-size: 16px;border:1px solid #1A73E8;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <span onclick="payment()" class="btn btn-info">Calculate</span>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Select an option'
            });

        });
        $(function () {
            // ON SELECTING ROW
            $(".edit").click(function () {
//FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                var id =$(this).parents("tr").find("#id").text();
                var p = "";
                //alert(fullname);
                // CREATING DATA TO SHOW ON MODEL
                p +="<input type='hidden' value='"+id+"' name='iid' id='iid'>";
                p += "<div class='row'>" +
                    "<div class='col'>" +
                    "<label>Date </label>"+
                    "<input type='datetime-local' value='"+totalAmount+"' name='ffullname' id='fullname' class='form-control border border-1 p-1' placeholder='Full name'>"+
                    "</div>"+
                    "<div class='col'>" +
                    "<label>Doctor </label>"+

                    "<select class='form-control select2 w-100' name='toDr'>" +
                    @foreach($drs as $dr)
                        "<option value='{{ $dr->id }}'>{{ $dr->drName }}</option>" +
                    @endforeach

                    "</select>" +
                    "</div>"+
                    "<div class='col'>" +
                    "<label>Cases </label>"+

                    "<select class='form-control js-example-basic-multiple' multiple='multiple' name='cid[]'>" +
                        @foreach($sicks as $sick)
                       "<option value='{{ $sick->id }}'>{{ $sick->caseName }}</option>" +
                        @endforeach
                    "</select>" +
                    "</div>"+
                    "</div>";
                p += "<div class='row mt-2'>";
                "</div></div>";
                //CLEARING THE PREFILLED DATA
                $("#divGFG").empty();
                //WRITING THE DATA ON MODEL
                $("#divGFG").append(p);
            });
        });

        //

        $(function () {
            // ON SELECTING ROW
            $(".payment").click(function () {
//FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                var id =$(this).parents("tr").find("#id").text();
                var cost = $(this).parents("tr").find("#cost").text();
                const cc = cost.replaceAll(' ','');

                var x = 0;
                var p = "";
                //alert(fullname);
                // CREATING DATA TO SHOW ON MODEL
                p +="<input type='hidden' value='"+id+"' name='iid' id='iid'>";
                p += "<div class='row'>" +
                    "<div class='col'>" +
                    "<label>Total Amount </label>"+
                    "<input type='text' value='"+cc+"' name='ffullname' id='fullname' class='form-control border border-1 p-1' placeholder='Full name'>"+
                    "</div>"+
                    "</div><hr>";
                p += "<div class='row'>"+
                    "<div class='col'>" +
                    "<label>Discount </label>"+
                    " <input type='text' value='"+x+"' name='eemail' class='form-control border border-1 p-1' placeholder='Email'>"+
                    "</div>"+
                    "<div class='col'>" +
                    "<label>Pay </label>"+
                    " <input type='text' value='"+x+"' name='pphone' class='form-control border border-1 p-1' placeholder='Phone'>"+
                    "</div>"+
                    "<div class='col'>" +
                    "<label>Remain </label>"+
                    " <input type='text' value='"+x+"' name='pphone' class='form-control border border-1 p-1' placeholder='Phone'>"+
                    "</div>"+
                    "</div><hr>";

                p += "<div class='row mt-2'>";
                "</div></div>";
                //CLEARING THE PREFILLED DATA
                $("#payment").empty();
                //WRITING THE DATA ON MODEL
                $("#payment").append(p);
            });
        });
        function selectName(sel){
            var id = sel.options[sel.selectedIndex].value;
            window.location.href = '/Dr.%20Anas%20Project%20System/202209131630/khorisk/patient/'+id;
        }
        // Material Select Initialization
        $(document).ready(function () {
            $("select").select2();
        });

        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Select an option'
            });

        });
    </script>
    <!-- BEGIN - Modal update-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
                </div>
                <div class="modal-body" id="divGFG">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="updateBtn()" id="upbtn" class="btn btn-primary w-25">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END - Modal update-->
    <!-- BEGIN - Modal PAYMENT-->
    <div class="modal fade" id="paymentModalU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Update payment</h5>
                </div>
                <div class="modal-body" id="payment">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="updateBtn()" id="upbtn" class="btn btn-primary w-25">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END - Modal PAYMENT-->
@endsection
