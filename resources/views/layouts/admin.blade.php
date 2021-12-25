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
					<br>
					<div class="footer">
						<p class="text-center">&copy; 2021 All rights reserved to AADA | Developed by: <a target="_blank" href="http://artisan.af"> Artisan Software Development Services</a></p>
					</div>
				</div>
				<!-- /Page Content -->
				
            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
        
        @include('admin._footer')

		@yield('scripts')
		<script>
	// 	Echo.channel('App.Models.User.1')
    // .notification((notification) => {
    //     console.log(notification.message);
	// });

</script>
	
    </body>
</html>