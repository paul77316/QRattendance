<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Grade Level</h1>
	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="downloadbtn"><i
	class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<div class="card shadow mb-4">
				<div class="card-header py-3">
						<a data-target="#exampleModal" id="add_btn" class="btn d-sm-inline-block shadow-sm btn-sm btn-primary float-right" style="width:8%;background:#4e73df">
						<i class="fas fa-plus-circle fa-sm text-white-50"></i> Add
						</a>
				</div>
				<div class="card-body">
					<table id="example1" class="display table table-bordered">
						<thead>
							<tr>
								<!-- <th>ID</th> -->
								<th>ID</th>
								<th>Year Level</th>
								<th>Section Name</th>
								<th class="">Action</th>
							</tr>
						</thead>
					</table>
				</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form id="frm_section_yr1" action="post">
				<div class="form-group">
					<label for="formGroupExampleInput">Grade Level</label>
                    <select id="inputState" name="level" class="form-control">
					    <option selected>Choose...</option>
                        <option>Grade 7 (Junior HS)</option>
                        <option>Grade 8 (Junior HS)</option>
                        <option>Grade 9 (Junior HS)</option>
                        <option>Grade 10 (Junior HS)</option>
						<option>Grade 11 (Senior HS)</option>
						<option>Grade 12 (Senior HS)</option>
                    </select>
			    </div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Section Name</label>
					<input type="text" class="form-control" name="section_name" id="formGroupExampleInput2" placeholder="">
					<input type="hidden" class="form-control" name="created_by" value="<?=  $_SESSION['login']['id']?>">
				</div>
				<!-- 
				<div class="form-group">
					<label for="formGroupExampleInput2">Adviser</label>
					<input type="text" class="form-control" id="adviser" id="formGroupExampleInput2" placeholder="" readonly value="<?= $_SESSION['login']['lastname'].", ".$_SESSION['login']['firstname']." ".$_SESSION['login']['middlename'] ?>">
					<input type="hidden" class="form-control"  name="adviser" placeholder="" value="<?= $_SESSION['login']['id']?>">
				</div> -->
		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" >Save changes</button>
			</div>
		</form>
		</div>
	
	</div>
</div>

<script>
	    $(document).ready(function() {

		/****************** **************
		/* SECTION YEAR LEVEL PAGE RELETED
		/******************* ************/
        $("#add_btn").on( "click", function() {
            $('#exampleModal').modal('show');
        });
        //section year add ajax
	    $("#frm_section_yr1").on('submit', function(e) {
	        e.preventDefault();
	        $.ajax({
	            url: "<?= base_url('main/add_section_yr');?>",
	            type: "POST",
	            data: $("#frm_section_yr1").serialize(),
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function() {
	                window.location.reload();
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });
		//SECTION YEAR LEVEL DATA TABLES
		var dataTable = $('#example1').DataTable({  
	       "processing":true,  
	       "serverSide":true,  
	       "order":[],  
	       "ajax":{  
	            url:"<?= base_url('main/fetch_user'); ?>",  
	            type:"POST"  
	       },  
	       "columnDefs":[  
	            {  
	                 // "targets":[0, 1, 1],  
	                 "orderable":true,  
	            },  
	       ],  
	      }); 
		//Edit
		
		$('#grade').on('change', function() {
  			 $.ajax({
	            url: "<?= base_url('main/reset_session');?>",
	            // type: "POST",
	            // data: {
	            // },
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function(data) {
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
		});
	

    });
</script>