<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/demo.js') }}"></script>
<script src="{{ asset('admin-assets/js/comfirm-delete.js') }}"></script>
<script src="{{ asset('admin-assets/js/iziToast.min.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('scripts')
