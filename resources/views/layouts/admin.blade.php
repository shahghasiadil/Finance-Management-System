<!DOCTYPE html>
<html lang="en">
    @include('admin._head')
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper" id="app">
		
			@include('admin._header')
			
			
			@include('admin._sidebar')
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					<router-view></router-view>
					<vue-progress-bar></vue-progress-bar>
				</div>
				<!-- /Page Content -->
				
            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
        
        @include('admin._footer')

		@yield('scripts')
	
    </body>
</html>