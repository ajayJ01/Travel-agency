@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Vendor</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('vendor.show') }}" class="btn btn-primary">Back</a>
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
                    <form action="{{ route('vendor.store') }}" method="POST">
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
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email"  value="{{old('email')}}" id="email" class="form-control"
                                        placeholder="Email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone<span class="text-danger">*</span></label>
                                    <input type="text" name="phone" value="{{old('phone')}}" id="phone" class="form-control"
                                        placeholder="Phone">
                                        @error('phone')
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" name="contact_person" value="{{old('contact_person')}}" id="contact_person" class="form-control"
                                        placeholder="Contact Person">
                                        @error('contact_person')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label for="inputPeople" class="col-form-label">Commission <span class="text-danger">*</span></label>
                                <input id="inputPeople" type="number" name="commission" placeholder="Enter Commission"
                                    value="{{ old('commission') }}" class="form-control">
                                @error('commission')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="type" class="col-form-label">Environment <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"  name="environment" id="typeTour"
                                                value="Sandbox">
                                            <label class="form-check-label" for="typeTour">Sandbox</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"  name="environment"
                                                id="typeEvent" value="Live">
                                            <label class="form-check-label" for="typeEvent">Live</label>
                                        </div>
                                    </div>
                                    @error('environment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="doc_url">Doc Url</label>
                                    <input type="text" name="doc_url" value="{{old('doc_url')}}" id="doc_url" class="form-control"
                                        placeholder="Doc Url">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="contact_person">Live Url</label>
                                    <input type="text" name="live_url" value="{{old('live_url')}}" id="live_url" class="form-control"
                                        placeholder="Live Url">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="contact_person">Sandbox Url</label>
                                    <input type="text" name="sandbox_url" value="{{old('sandbox_url')}}" id="sandbox_url" class="form-control"
                                        placeholder="SandBox Url">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="social_media" class="col-form-label">Sandbox Credentials</label>
                                    <div class="">
                                        <table class="table" id="dynamic_field">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <td>
                                                        <h4>1</h4>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="sandbox_type[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="sandbox_value[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" name="add" id="add"
                                                            class="btn btn-success">Add
                                                            More</button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="mb-3">
                                    <label for="social_media" class="col-form-label">Live Credentials</label>
                                    <div class="">
                                        <table class="table invoice-items" id="dynamic_field_live">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4>1</h4>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="live_type[]"  class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="live_value[]"  class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" name="addlive" id="addlive"
                                                            class="btn btn-success">Add
                                                            More</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('vendor.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

    <script>
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><h4>' + i +
                '</h4></td><td><input type="text" name="sandbox_type[]" class="form-control"></td><td><input type="text" name="sandbox_value[]" class="form-control"></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    </script>

	 <script>
        var i = 1;
        $('#addlive').click(function() {
            i++;
            $('#dynamic_field_live').append('<tr id="row' + i + '"><td><h4>' + i +
                '</h4></td><td><input type="text" name="live_type[]" class="form-control"></td><td><input type="text" name="live_value[]"  class="form-control"></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    </script>
@endsection
