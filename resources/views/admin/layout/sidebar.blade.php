<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="#" class="brand-link">
		<img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">AJ Travel Agency</span>
	</a>
	<div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ route('admin.dashboard') }}" class="nav-link {{ activeMenu('admin.dashboard') }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('attribute.show') }}" class="nav-link {{ activeMenu(['attribute.show', 'attribute.create', 'attribute.edit']) }}">
						<i class="nav-icon fas fa-users"></i>
						<p>Attributes</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('vendor.show') }}" class="nav-link {{ activeMenu(['vendor.show', 'vendor.create', 'feed.edit']) }}">
						<i class="nav-icon fas fa-users"></i>
						<p>Vendors</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('admin/feeds') }}" class="nav-link {{ activeMenu(['feed.show', 'feed.create', 'feed.edit']) }}">
						<i class="nav-icon fas fa-users"></i>
						<p>Feeds</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="users.html" class="nav-link">
						<i class="nav-icon  fas fa-users"></i>
						<p>Users</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="javascript:void(0)" class="nav-link">
						<i class="nav-icon  far fa-file-alt"></i>
						<p>Pages</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('booking.show') }}" class="nav-link {{ activeMenu(['booking.show','booking.detail'])}}" >
						<i class="nav-icon fas fa-users"></i>
						<p>Booking</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('airport.show') }}" class="nav-link {{ activeMenu(['airport.show',])}}" >
						<i class="nav-icon fas fa-users"></i>
						<p>Airports</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('airline.show') }}" class="nav-link {{activeMenu(['airline.show'])}}" >
						<i class="nav-icon fas fa-users"></i>
						<p>Airlines</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('apitype.show')}}" class="nav-link {{activeMenu(['apitype.show'])}}" >
						<i class="nav-icon  far fa-file-alt"></i>
						<p>Api Type</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('question.show')}}" class="nav-link {{activeMenu(['question.show'])}}" >
						<i class="nav-icon  far fa-file-alt"></i>
						<p>FAQ</p>
					</a>
				</li>
			
				<li class="nav-item">
					<a href="{{ route('admin.setting.index') }}" class="nav-link  {{activeMenu(['admin.setting.index'])}}">
						<i class="nav-icon  far fa-file-alt"></i>
						<p>Settings</p>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>
