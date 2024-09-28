@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="tab-contents">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="col">
                            <h4>Booking Details</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    @foreach ($details as $d)
                                    <tr>
                                        <th>Booking Id:</th>
                                        <th>{{$d->id ?? ''}}</th>
                                    </tr>

                                    <tr>
                                        <th>Booking No:</th>
                                        <th>{{$d->booking_no ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <th>{{$d->email?? ''}}</th>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <th>{{$d->phone ?? ''}}</th>
                                    </tr>

                                    <th>No of Adults:</th>
                                    <th>{{$d->no_of_audlts ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>No of Childrens:</th>
                                        <th>{{$d->no_of_childrens ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>No of Infant:</th>
                                        <th>{{$d->no_of_infant ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Total no of Traveller:</th>
                                        <th>{{$d->total_no_of_traveller ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Origin:</th>
                                        <th>{{$d->origin_info->municipality }}
                                            ({{$d->origin}})
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Destination:</th>
                                        <th>{{$d->destination_info->municipality ?? ''}}
                                            ({{$d->destination}})
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Departure Date:</th>
                                        <th>{{$d->departure_date ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Return Date:</th>
                                        <th>{{$d->return_date ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Coupan Code:</th>
                                        <th>{{$d->coupan_code ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Amount:</th>
                                        <th>{{$d->amount?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Discount:</th>
                                        <th>{{$d->discount?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>GST:</th>
                                        <th>{{$d->gst ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Service Charge:</th>
                                        <th>{{$d->service_charge ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <th>{{$d->total ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>GST No:</th>
                                        <th>{{$d->gst_no ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>Vendor Name:</th>
                                        <th>{{$d->vendor_info->name ?? ''}}</th>
                                    </tr>


                                    <tr>
                                        <th>Created At:</th>
                                        <th>{{$d->created_at ?? ''}}</th>
                                    </tr>



                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <!--table-responsive-->

                    </div>
                    <!--tab-->
                </div>
                <!--tab-content-->


            </div>
            <!--col-->
        </div>
        <!---tab statrt --->

        <h4>Passenger Details</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Id</th>
                    <th>Type</th>
                    <th> Name</th>
                    <th>DOB</th>
                    <th>Nationality</th>
                    <th>Passport No</th>
                </thead>
                <tbody>
                    @foreach ($passengers as $key => $p)
                    <tr>

                        <td>{{++$key}}</td>
                        <td>{{$p->type}}</td>
                        <td>
                            {{$p->title}}
                            {{$p->first_name}}
                            {{$p->last_name}}
                        </td>

                        <td>{{$p->dob}}</td>
                        <td>{{$p->nationality}}</td>
                        <td>{{$p->passport_num}}</td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </div>
</div>
@endsection