@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Vendors</h1>
            </div>
            <div class="col-sm-6 text-right">
               <a href="{{ route('vendor.create') }}" class="btn btn-primary">New Vendor</a>
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
                    <a href="{{ route('vendor.show') }}" class="btn btn-default btn-sm">Reset</a>

                </div>
                <div class="card-tools">
                    <div class="input-group input-group" style="width: 250px;">
                        <input value="{{ Request::get('keyword')}}" type="text" name="keyword" class="form-control float-right" placeholder="Search">

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
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th width="100">Status</th>
                             <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                       @if ($vendors->isNotEmpty())
                            @foreach ($vendors as $k=>$v)

                                <tr>
                                    <td>{{ ++$k }}</td>

                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->code }}</td>
                                    <td>{{ $v->contact_person }}</td>
                                    <td>{{ $v->email }}</td>
                                    <td>{{ $v->phone }}</td>
                                    <td>
                                        @if($v->status==1)
                                            <span class="badge badge-success">active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                      <a href="{{route('vendor.edit',$v->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                        <form method="POST" action="{{ route('vendor.delete', $v->id) }}">
                                            @csrf
                                            @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$v->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
              {{ $vendors->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customJs')
<script>
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        $('.dltBtn').click(function(e){
          var form=$(this).closest('form');
            var dataID=$(this).data('id');
            // alert(dataID);
            e.preventDefault();
            swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this data!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                    form.submit();
                  } else {
                      swal("Your data is safe!");
                  }
              });
        })
    })
  </script>
@endsection
