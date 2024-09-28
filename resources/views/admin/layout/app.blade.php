<!DOCTYPE html>
<html lang="en">
	@include('admin/layout/partial/head')
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			@include('admin/layout/sidebar')
			@include('admin/layout/partial/header')
			<div class="content-wrapper">
                <div class="show message">
                    @include('admin/layout/partial/message')
                </div>
				@yield('content')
			</div>
			@include('admin/layout/partial/footer')
		</div>
		@include('admin/layout/partial/script')
	</body>
</html>
