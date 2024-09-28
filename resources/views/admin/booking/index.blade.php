@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bookings</h1>
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
                        <th width="80">Booking no.</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Booking Date</th>
                        <th>Booking Status</th>
                        <th>Payment Status</th>
                        <th width="100">Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($bookings->isNotEmpty())
                    @foreach ($bookings as $k=>$v)

                    <tr>
                        <td>{{ ++$k }}</td>
                        <td>{{$v->booking_no}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{$v->phone}}</td>
                        <td>{{$v->booking_date}}</td>
                        <td>
                            @if($v->booking_status==0)
                            <span class="badge badge-danger">pending</span>
                            @elseif($v->booking_status==1)
                            <span class="badge badge-success">success</span>
                            @else
                            <span class="badge badge-warning">cancelled</span>
                            @endif
                        </td>
                        <td>
                            @if($v->payment_status==0)
                            <span class="badge badge-danger">pending</span>
                            @elseif($v->payment_status==1)
                            <span class="badge badge-success">success</span>
                            @else
                            <span class="badge badge-danger">failed</span>
                            @endif
                        </td>
                        <td>
                            @if($v->status==1)
                            <span class="badge badge-success">active</span>
                            @else
                            <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('booking.detail', $v->id) }}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="View"
                                data-placement="bottom"><i class="fa fa-eye"></i></a>
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
            {{ $bookings->links() }}
        </div>
    </div>
    </div>
    <!-- /.card -->
</section>
@endsection