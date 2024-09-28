@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Api types</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"> Create </button>
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
                    <a href="{{ route('apitype.show') }}" class="btn btn-default btn-sm">Reset</a>

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
                        <th>ID</th>
                        <th>Name</th>


                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($types->isNotEmpty())
                    @foreach ($types as $k=>$v)

                    <tr>
                        <td>{{ ++$k }}</td>

                        <td>{{ $v->name }}</td>


                        <td>
                            @if($v->status==1)
                            <span class="badge badge-success">active</span>
                            @else
                            <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#viewModal{{$v->id}}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editModal{{$v->id}}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('apitype.delete', $v->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$v->id}}"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
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
            {{ $types->links() }}
        </div>
    </div>
    </div>
    <!-- /.card -->
    <!-- create modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{ route('apitype.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name">
                                        @error('name')
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
                                <a href="{{ route('apitype.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end create modal -->

    @foreach ($types as $v)
    <!-- view modal -->
    <div class="modal fade" id="viewModal{{$v->id}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel"> F&Q</h5>
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
                                    <th>Status:</th>
                                    <th>
                                        @if($v->status==1)
                                        Active
                                        @else
                                        Inactive
                                        @endif
                                    </th>
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
    <div class="modal fade" id="editModal{{$v->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="modalBodyContent">
                        <form action="{{route('apitype.update',$v->id)}}" id="create-form" method="POST"
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


                               

                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <a href="{{ route('apitype.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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