@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Attributes</h1>
            </div>
            <div class="col-sm-6 text-right">
               <a href="{{ route('attribute.create') }}" class="btn btn-primary">Add Attribute</a>
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
                    <a href="{{ route('attribute.show') }}" class="btn btn-default btn-sm">Reset</a>

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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if ($attributes->isNotEmpty())
                            @foreach ($attributes as $k=>$attr)
                                <tr>
                                    <td>{{ ++$k }}</td>
                                    <td>{{ $attr->name }}</td>
                                    <td>{{ $attr->slug }}</td>
                                    <td>
                                        @if($attr->status==1)
                                            <span class="badge badge-success">active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('attribute.edit',$attr->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('attribute.delete', $attr->id) }}">
                                            @csrf
                                            @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$attr->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
              {{ $attributes->links() }}
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
