@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Vendor</h1>
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

                    <form method="post" action="{{ route('vendor.update', $vendors->id) }}" enctype='multipart/form-data'>
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $vendors->name }}"
                                        class="form-control" placeholder="Name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ $vendors->email }}"
                                        class="form-control" placeholder="Email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone<span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone" value="{{ $vendors->phone }}"
                                        class="form-control" placeholder="Phone" >
                                        @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code<span class="text-danger">*</span></label>
                                    <input type="text" name="code" id="code" value="{{ $vendors->code }}"
                                        class="form-control" placeholder="Code" >
                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_person">Contact Person<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        value="{{ $vendors->contact_person }}" class="form-control"
                                        placeholder="Contact Person">
                                        @error('contact_person')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service">Commission<span class="text-danger">*</span></label>
                                    <input type="number" name="commission" id="commission" value="{{ $vendors->commission }}"
                                        class="form-control" placeholder="commission">
                                    @error('commission')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="type" class="col-form-label">Environment<span class="text-danger">*</span></label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="environment" id="typeSandbox"
                                            value="Sandbox" {{ $vendors->environment == 'Sandbox' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="typeSandbox">Sandbox</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="environment" id="typeLive"
                                            value="Live" {{ $vendors->environment == 'Live' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="typeLive">Live</label>
                                    </div>
                                </div>
                                @error('environment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="doc_url">Doc Url</label>
                                    <input type="text" name="doc_url" id="doc_url" value="{{ $vendors->doc_url }}"
                                        class="form-control" placeholder="Doc Url" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="live_url">Live Url</label>
                                    <input type="text" name="live_url" id="live_url" value="{{ $vendors->live_url }}"
                                        class="form-control" placeholder="Live Url" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sandbox_url">Sandbox Url</label>
                                    <input type="text" name="sandbox_url" id="sandbox_url"
                                        value="{{ $vendors->sandbox_url }}" class="form-control" placeholder="Sandbox Url"
                                        >
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sandbox_credentials" class="col-form-label">Sandbox Credentials</label>
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
                                            @if (!empty($vendors->sandbox_credentials))
                                                @foreach ($vendors->sandbox_credentials as $key => $credential)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <input type="text" name="sandbox_type[]"
                                                                value="{{ old('sandbox_type.' . $loop->index, $credential['key']) }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="sandbox_value[]"
                                                                value="{{ old('sandbox_value.' . $loop->index, $credential['value']) }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            @if ($loop->first)
                                                                <button type="button" name="add" id="add"
                                                                    class="btn btn-success">Add More</button>
                                                            @endif

                                                            @if (!$loop->first)
                                                                <button type="button" class="btn btn-danger btn_remove">X</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <input type="text" name="sandbox_type[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="sandbox_value[]"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" name="add" id="add"
                                                            class="btn btn-success">Add More</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="live_credentials" class="col-form-label">Live Credentials</label>
                                    <table class="table" id="dynamic_field_live">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Key</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($vendors->live_credentials))
                                               @foreach ($vendors->live_credentials as $key => $credential)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="text" name="live_type[]" value="{{ old('live_type.' . $loop->index, $credential['key']) }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="live_value[]" value="{{ old('live_value.' . $loop->index, $credential['value']) }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        @if ($loop->first)
                                                            <button type="button" name="addlive" id="addlive" class="btn btn-success">Add More</button>
                                                        @endif

                                                        @if (!$loop->first)
                                                            <button type="button" class="btn btn-danger btn_remove">X</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td>1</td>
                                                    <td><input type="text" name="live_type[]" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="live_value[]" class="form-control">
                                                    </td>
                                                    <td><button type="button" name="addlive" id="addlive"
                                                            class="btn btn-success">Add More</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
        $(document).ready(function() {
            var sandboxCount =
                {{ !empty($vendors->sandbox_credentials) ? count($vendors->sandbox_credentials) : 1 }};
            var liveCount = {{ !empty($vendors->live_credentials) ? count($vendors->live_credentials) : 1 }};

            $('#add').click(function() {
                sandboxCount++;
                $('#dynamic_field tbody').append('<tr id="row' + sandboxCount + '"><td>' + sandboxCount +
                    '</td><td><input type="text" name="sandbox_type[]" class="form-control"></td><td><input type="text" name="sandbox_value[]" class="form-control"></td><td><button type="button" class="btn btn-danger btn_remove">X</button></td></tr>'
                );
            });


            $('#addlive').click(function() {
                liveCount++;
                $('#dynamic_field_live tbody').append('<tr id="row' + liveCount + '"><td>' + liveCount +
                    '</td><td><input type="text" name="live_type[]" class="form-control"></td><td><input type="text" name="live_value[]" class="form-control"></td><td><button type="button" class="btn btn-danger btn_remove">X</button></td></tr>'
                );
            });

            $(document).on('click', '.btn_remove', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>


@endsection
