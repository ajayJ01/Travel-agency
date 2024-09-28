@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Airlines</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#airlinecreateModal"> New
                    Airline</button>
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
                <div class="card-title">
                    <a href="{{ route('airline.show') }}" class="btn btn-default btn-sm">Reset</a>

                </div>
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
                        <th width="60">ID</th>
                        <th width="80">Name</th>
                        <th>Code</th>
                    
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($airlines->isNotEmpty())
                    @foreach ($airlines as $k=>$v)

                    <tr>
                        <td>{{ ++$k }}</td>

                        <td>{{ $v->name }}</td>
                      
                        <td>{{ $v->code }}</td>

                        


                        <td>
                            @if($v->status==1)
                            <span class="badge badge-success">active</span>
                            @else
                            <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#airlineviewModal{{$v->id}}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#airlineeditModal{{$v->id}}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('airline.delete', $v->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$v->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                    </tr>
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
            {{ $airlines->links() }}
        </div>
    </div>
    </div>
    <!-- /.card -->
    <!-- create modal -->
    <div class="modal fade" id="airlinecreateModal" tabindex="-1" aria-labelledby="airlinecreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airlinecreateModalLabel">Create Airline
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{ route('airline.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{old('name')}}" id="name"
                                            class="form-control" placeholder="Name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code">Code<span class="text-danger">*</span></label>
                                        <input type="text" name="code" value="{{old('code')}}" id="code"
                                            class="form-control" placeholder="Code">
                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('airline.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end create modal -->
    @foreach ($airlines as $v)

    <!-- view modal -->
    <div class="modal fade" id="airlineviewModal{{$v->id}}" tabindex="-1" aria-labelledby="airlineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airlineModalLabel"> Airline</h5>
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
                                    <th>Code:</th>
                                    <th>{{$v->code ?? ''}}</th>
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
    <div class="modal fade" id="airlineeditModal{{$v->id}}" tabindex="-1" aria-labelledby="airlineeditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="airlineeditModalLabel">Edit Airline</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{route('airline.update',$v->id)}}" id="create-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="_token" value="{{ csrf_token()}}" autocomplete="off">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{$v->name}}" id="name"
                                            class="form-control" placeholder="Name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code">Code<span class="text-danger">*</span></label>
                                        <input type="text" name="code" value="{{$v->code}}" id="code"
                                            class="form-control" placeholder="Code">
                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <a href="{{ route('airline.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
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