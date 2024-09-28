@extends('admin.layout.app')
@section('extra-css')
<style>
img#previewImage1 {
    width: 120px;
    height: 120px;
    object-fit: cover;
}

img#previewImage2 {
    width: 120px;
    height: 120px;
    object-fit: cover;
}
</style>
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>General Settings</h1>
            </div>
            <div class="col-sm-6 text-right">

            </div>
        </div>
    </div>
</section>
<section class="content">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.update') }}"
        enctype="multipart/form-data">
        @csrf
        @php
        $site_name = $setting->site_name ?? '';
        $email = $setting->email ?? '';

        $phone = $setting->phone ?? '';
        $footer = $setting->footer ?? '';
        $address = $setting->address ?? '';
        $currency_name = $setting->currency_name ?? '';
        $currency_code = $setting->currency_code ?? '';
        $support_phone = $setting->support_phone ?? '';
        $site_address = $setting->site_address ?? '';
        $descreption = $setting->descreption ?? '';
        $logo = $setting->logo ?? '';
        $favicon = $setting->favicon ?? '';
        $service_charge = $setting->service_charge ?? '';
        $gst_applied = $setting->gst_applied ?? '';


        @endphp
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <span class="text-danger">*</span>
                        <input name="site_name" id="site_name" type="text"
                            class="form-control @error('site_name') is-invalid @enderror"
                            value="{{ old('site_name', $site_name) }}">
                        @error('site_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <span class="text-danger">*</span>
                        <input name="email" id="email" type="text"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email) }}"
                            onkeypress='validate(event)'>
                        @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <span class="text-danger">*</span>
                        <input name="phone" id="phone" type="text"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $phone) }}"
                            onkeypress='validate(event)'>
                        @error('phone')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="footer">Footer</label> <span class="text-danger">*</span>
                        <textarea name="footer" id="footer" cols="1" rows="1"
                            class="form-control small-textarea-height @error('footer') is-invalid @enderror">{{ old('footer', $footer) }}</textarea>

                        @error('footer')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="currency_name">Currency Name</label> <span class="text-danger">*</span>
                        <input name="currency_name" id="currency_name"
                            class="form-control @error('currency_name') is-invalid @enderror"
                            value="{{ old('currency_name', $currency_name) }}">
                        @error('currency_name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="currency_code">Currency Code</label> <span class="text-danger">*</span>
                        <input name="currency_code" id="currency_code"
                            class="form-control @error('currency_code') is-invalid @enderror"
                            value="{{ old('currency_code', $currency_code) }}">
                        @error('currency_code')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="support_phone">Support Phone</label> <span class="text-danger">*</span>
                        <input name="support_phone" id="support_phone"
                            class="form-control @error('support_phone') is-invalid @enderror"
                            value="{{ old('support_phone', $support_phone) }}">
                        @error('support_phone')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label> <span class="text-danger">*</span>
                        <textarea name="address" id="address" cols="1" rows="1"
                            class="form-control small-textarea-height @error('address') is-invalid @enderror">{{ old('address', $address) }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="descreption">Descreption</label> <span class="text-danger">*</span>
                        <textarea name="descreption" id="descreption" cols="1" rows="1"
                            class="form-control small-textarea-height @error('descreption') is-invalid @enderror">{{ old('descreption', $descreption) }}</textarea>
                        @error('descreption')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="service_charge">Service Charge</label> <span class="text-danger">*</span>
                        <input name="service_charge" id="service_charge"
                            class="form-control @error('service_charge') is-invalid @enderror"
                            value="{{ old('service_charge', $service_charge) }}">

                        @error('service_charge')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="service_charge">GST applied</label> <span class="text-danger">*</span>
                        <input name="gst_applied" id="gst_applied"
                            class="form-control @error('gst_applied') is-invalid @enderror"
                            value="{{ old('gst_applied', $gst_applied) }}">

                        @error('service_charge')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="customFile">Logo</label>
                        <div class="custom-file">
                            <input name="logo" type="file"
                                class="file-upload-input custom-file-input @error('logo') is-invalid @enderror"
                                id="customFile" onchange="readURL(this,'previewImage1');">
                            <label class="custom-file-label" for="customFile">Choose File</label>
                        </div>
                        @error('logo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        @if ($logo)
                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage1"
                            src="{{ asset('/'.$logo )}}" />
                        @else
                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage1"
                            src="{{ asset('storage/images/logo.png') }}" />
                        @endif
                    </div>
                </div>
                <div class="form-group col-12 col-md-6">
                    <div class="form-group">
                        <label for="customFile">Favicon</label>
                        <div class="custom-file">
                            <input name="favicon" type="file"
                                class="file-upload-input custom-file-input @error('favicon') is-invalid @enderror"
                                id="customFile" onchange="readURL2(this,'previewImage2');">
                            <label class="custom-file-label" for="customFile">Choose File</label>
                        </div>
                        @error('favicon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        @if ($favicon)
                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage2"
                            src="{{ asset('/'.$favicon ) }}" />
                        @else
                        <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage2"
                            src="{{ asset('storage/images/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
    <div class="mb-3">
        <label for="social_media" class="col-form-label"></label>
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
                    @php $counter = 1; @endphp
                    @foreach($email_config as $key => $value)
                        <tr>
                            <td><h4>{{ $counter++ }}</h4></td>
                            <td>
                                <input type="text" name="email_type[]" class="form-control" value="{{ $key }}">
                            </td>
                            <td>
                                <input type="text" name="email_value[]" class="form-control" value="{{ $value }}">
                            </td>
                         
                        </tr>
                    @endforeach
                    <tr>
                        <td><h4>{{ $counter }}</h4></td>
                        <td>
                            <input type="text" name="email_type[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="email_value[]" class="form-control">
                        </td>
                        <td>
                            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


        

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Setting</button>
        </div>
    </form>
</section>
@endsection
@section('scripts')
<script>
var i = 1;
$('#add').click(function() {
    i++;
    $('#dynamic_field').append('<tr id="row' + i + '"><td><h4>' + i +
        '</h4></td><td><input type="text" name="email_type[]" class="form-control"></td><td><input type="text" name="email_value[]" class="form-control"></td><td><button type="button" name="remove" id="' +
        i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
});

$(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
});
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/tiff',
            'image/svg'
        ];
        if (validImageTypes.includes(fileType)) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Selected file is not a valid image. Please select an image file.',
                showClass: {
                    popup: `
                        animate__animated
                        animate__fadeIn
                        animate__faster`
                },
                hideClass: {
                    popup: `
                        animate__animated
                        animate__fadeOut
                        animate__faster`
                },
            });
        }

    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/tiff',
            'image/svg'
        ];
        if (validImageTypes.includes(fileType)) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Selected file is not a valid image. Please select an image file.',
                showClass: {
                    popup: `
                        animate__animated
                        animate__fadeIn
                        animate__faster`
                },
                hideClass: {
                    popup: `
                        animate__animated
                        animate__fadeOut
                        animate__faster`
                },
            });
        }

    }
}
</script>

@endsection