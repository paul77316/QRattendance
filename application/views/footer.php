			</div>
				<!-- /.container-fluid -->
			</div>
			<!-- End of Main Content -->           
		   <!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; Your Website 2021</span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?=base_url('main/doLogout');?>">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<!-- END CLASS MODAL -->
		<div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header btn-danger">
						<h5 class="modal-title" id="exampleModalLabel1">Confirmation</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h6>Are you sure you want to end this session?</h6>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" data-dismiss="modal">No</button>
						<button class="btn btn-danger" id="end-class"> Yes</button>
					</div>
				</div>
			</div>
		</div>
</body>
<script type="text/javascript">
	     $(".close").on( "click", function() {
         	 window.location.reload(); 
        });
</script>

</html>