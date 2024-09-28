@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Vendor</h1>
                </div>
                <div class="col-sm-6 text-right">
                    {{-- <a href="{{ route('vendor.show') }}" class="btn btn-primary">Back</a> --}}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('airline.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name"  value="{{old('name')}}" id="name" class="form-control"
                                        placeholder="Name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                               
                            </div>
                            
                         
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code<span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{old('code')}}" id="code" class="form-control"
                                        placeholder="Code">
                                        @error('code')
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
        <!-- /.card -->
    </section>
@endsection
@push('styles')
   
@endpush
@section('scripts')
 
@endsection
