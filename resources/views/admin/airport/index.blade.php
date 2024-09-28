@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Airports</h1>
            </div>
            <div class="col-sm-6 text-right">

                <button class="btn btn-primary" data-toggle="modal" data-target="#airportcreateModal">New
                    Airport</button>

            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    {{-- @include('admin.message') --}}
    <div class="card">
        <form method="get" action="">
            <div class="card-header">

                <div class="card-tools">
                    <div class="input-group input-group" style="width: 250px;">
                        <input value="{{ Request::get('keyword')}}" type="text" name="keyword"
                            class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th width="60">S.No</th>
                        <th width="80">Name</th>
                        <th>Municipality</th>
                        <th>iata Code</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($airports->isNotEmpty())
                    @foreach ($airports as $k=>$v)

                    <tr>
                        <td>{{ ++$k }}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->municipality}}</td>
                        <td>{{$v->iata_code}}</td>


                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#airportviewModal{{$v->id}}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#airporteditModal{{$v->id}}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('airport.delete', $v->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" data-id="{{$v->id}}" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>

                        </td>

                        @endforeach
                        @else
                    <tr>
                        <td>
                            Record Not found
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">

            {{ $airports->links() }}

        </div>
    </div>
    </div>
    <!-- /.card -->
    <!-- create modal -->
    <div class="modal fade" id="airportcreateModal" tabindex="-1" aria-labelledby="airportcreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airportcreateModalLabel">Create Airport</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{route('airport.store')}}" id="create-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token()}}" autocomplete="off">


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="municipility">Municipality<span class="text-danger">*</span></label>
                                    <input type="text" name="municipality" id="municipality" class="form-control"
                                        placeholder="municipality">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">iata Code<span class="text-danger">*</span></label>
                                    <input type="text" name="iata_code" id="iata_code" class="form-control"
                                        placeholder="code">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end create modal -->
    @foreach ($airports as $v)
    <!-- view modal -->
    <div class="modal fade" id="airportviewModal{{$v->id}}" tabindex="-1" aria-labelledby="airportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airportModalLabel"> Airport</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <div class="table-responsive">
                            <table class="table table-hover">

                                <tr>
                                    <th>Name:</th>
                                    <th>{{$v->name ?? ''}}</th>
                                </tr>

                                <tr>
                                    <th>City:</th>
                                    <th>{{$v->municipality ?? ''}}</th>
                                </tr>
                                <tr>
                                    <th>iata code:</th>
                                    <th>{{$v->iata_code ?? ''}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end view modal -->
    <!--  edit modal -->
    <div class="modal fade" id="airporteditModal{{$v->id}}" tabindex="-1" aria-labelledby="airporteditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airporteditModalLabel">Edit Airport</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{route('airport.update',$v->id)}}" id="create-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="_token" value="{{ csrf_token()}}" autocomplete="off">


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{$v->name}}" id="name" class="form-control"
                                        placeholder="Name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="municipility">Municipality<span class="text-danger">*</span></label>
                                    <input type="text" name="municipality" value="{{$v->municipality}}"
                                        id="municipality" class="form-control" placeholder="municipality">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">iata Code<span class="text-danger">*</span></label>
                                    <input type="text" name="iata code" value="{{$v->iata_code}}" id="iata code"
                                        class="form-control" placeholder="code">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end edit modal -->
    @endforeach



</section>
@endsection