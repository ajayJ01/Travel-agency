@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feeds</h1>
            </div>
            <div class="col-sm-6 text-right">
               <a href="{{ route('admin.feed.create') }}" class="btn btn-primary">Add Feed</a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <form method="get" action="">
            <div class="card-header">
                <div class="card-title">
                    <a href="{{ route('admin.feed.show') }}" class="btn btn-default btn-sm">Reset</a>
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
                            <th>Vendor Name</th>
                            <th>API Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if ($feeds->isNotEmpty())
                            @foreach ($feeds as $k=>$feed)
                                <tr>
                                    <td>{{ ++$k }}</td>
                                    <td>{{ $feed->vendorDetails->name }}</td>
                                    <td>{{ $feed->name }}</td>
                                    <td>{{ $feed->type }}</td>
                                    <td>
                                        @if($feed->status==1)
                                            <span class="badge badge-success">active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                      <a href="{{route('admin.feed.edit',$feed->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('admin.feed.delete', $feed->id) }}">
                                            @csrf
                                            @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$feed->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
              {{ $feeds->links() }}
            </div>
        </div>
    </div>
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
