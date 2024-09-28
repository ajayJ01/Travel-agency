@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="tab-contents">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="col">
                            <h4>Airport Details</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    @foreach ($details as $d)
                                    <tr>
                                        <th>Name:</th>
                                        <th>{{$d->name ?? ''}}</th>
                                    </tr>

                                    <tr>
                                        <th>Municipality:</th>
                                        <th>{{$d->municipality ?? ''}}</th>
                                    </tr>
                                    <tr>
                                        <th>iata code:</th>
                                        <th>{{$d->iata_code ?? ''}}</th>
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

       
    </div>
</div>
@endsection