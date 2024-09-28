@if(Session::has('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        iziToast.error({
            title: 'Error',
            message: '{{ Session::get('error') }}',
            position: 'topRight', // You can adjust the position as needed
            timeout: 2000 // Duration in milliseconds (2000ms = 2 seconds)
        });
    });
</script>
@endif

@if(Session::has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        iziToast.success({
            title: 'Success',
            message: '{{ Session::get('success') }}',
            position: 'topRight', // You can adjust the position as needed
            timeout: 2000 // Duration in milliseconds (2000ms = 2 seconds)
        });
    });
</script>
@endif
