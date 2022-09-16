<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>School Attendance System</title>

	<!-- Custom fonts for this template-->
	<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url('assets/css/sb-admin-2.min.css');?>" rel="stylesheet">

	<style>
		.bg-login-image1 {
		background: url("<?= base_url('assets/img/login-image2.jpg')?>");
		background-position: center;
		background-size: cover;
		}
	</style>
</head>

<body class="bg-gradient-primary">

	<div class="container">
		<!-- Outer Row -->
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-6 d-none d-lg-block bg-login-image1"></div>
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
									</div>
									<form class="user" id="frm" action="<?=base_url();?>main/doLogin" method="post">
										<div class="form-group">
											<input type="tex" class="form-control form-control-user"
												id="exampleInputEmail" name="username" aria-describedby="emailHelp"
												placeholder="Enter Username">
										</div>
										<div class="form-group">
											<input type="password" name="password" class="form-control form-control-user"
												id="exampleInputPassword" placeholder="Password">
										</div>
										<div class="form-group">
											<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" id="customCheck">
												<label class="custom-control-label" for="customCheck">Remember
													Me</label>
											</div>
										</div>
										<button class="btn btn-primary btn-user btn-block"> 
											Login
										</button>
									</form>
									<hr>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
	<script src="<?=  base_url('assets/vendor/jquery/jquery.min.js');?>"></script>
		<!-- Custom scripts for all pages-->
		<script src="<?=  base_url('assets/js/sb-admin-2.min.js');?>"></script>
	<!-- Core plugin JavaScript-->
	<script src="<?=  base_url('assets/vendor/jquery-easing/jquery.easing.min.js');?>"></script>
	<!-- Bootstrap core JavaScript-->
  
	<script src="<?=  base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
	
<script>
$(document).ready(function(){
	$('#frm').on('submit',function(e){
		e.preventDefault();  
		  $.ajax({
			type: "POST",
			url: $(this).prop('action'),
			data: $(this).serialize(),
			success: function(data)
			 {
			   if(data==1)              
			   window.location.href = "<?php echo base_url('main/home'); ?>";
			   else
				alert('error');
			 }
		  });
	});
  
});
	</script>
</body>

</html>