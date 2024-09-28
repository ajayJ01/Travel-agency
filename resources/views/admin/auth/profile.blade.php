@extends('admin.layout.app')
@section('extra-css')
<style>
    .img-width {
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
                <h1>Update Profile</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="products.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form method="POST" action="{{ route('admin.update.profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $profile->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $profile->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ $profile->phone ??'' }}" name="phone">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </div>
    </form>
</section>
@endsection
@section('scripts')
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/tiff', 'image/svg'];
        if (validImageTypes.includes(fileType)) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
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
