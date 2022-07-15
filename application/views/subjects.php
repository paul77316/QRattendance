<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Subjects</h1>
	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
	class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<a data-target="#exampleModal" id="add_btn_subjects" class="btn d-sm-inline-block shadow-sm btn-sm btn-primary float-right" style="width:8%;background:#4e73df">
		<i class="fas fa-plus-circle fa-sm text-white-50"></i> Add</a>
	</div>
	<div class="card-body">
		<table id="tble-list1" class="display table table-bordered">
			<thead>
				<tr>
					<!-- <th>ID</th> -->
					<th>ID</th>
					<th>Subject Name</th>
					<th>Year Level</th>
					<th>Section</th>
					<th>Status</th>
					<th class="">Action</th>
				</tr>
			</thead>
		</table>
	</div>
					
</div>
<div class="modal fade" id="add_subject_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style=";">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form id="frm_add_section" action="post">
				<div class="form-group">
					<label for="formGroupExampleInput">Subject Name</label>
					<input type="text" class="form-control" name="subject_name" id="formGroupExampleInput2" placeholder="" required>
			    </div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Section Name</label>
					<input type="text" id="section_name" class="form-control" placeholder="Select from existing section name">
					<input type="hidden" name="section_yr_id" value="0">
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
				<button type="submit" class="btn btn-primary" id="save-btn">Save changes</button>
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
        $("#add_btn_subjects").on( "click", function() {
            $('#add_subject_modal').modal('show');
        });
      
        //section year add ajax
	    $("#frm_add_section").on('submit', function(e) {
	        e.preventDefault();
	        $.ajax({
	            url: "<?= base_url('main/add_subject');?>",
	            type: "POST",
	            data: $("#frm_add_section").serialize(),
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
		var dataTable = $('#tble-list1').DataTable({  
	       "processing":true,  
	       "serverSide":true,  
	       "order":[],  
	       "ajax":{  
	            url:"<?= base_url('main/fetch_user2'); ?>",  
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
	  if($("input[name=section_yr_id]").val() == 0){
    		$("#save-btn").prop( "disabled", true );
        }
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
		// $("#section_name").autocomplete({
		// source: function( request, response ) {
		// 	$.ajax({
		// 		url: '<?= base_url('main/get_autocomplete');?>',
		// 		type: 'POST',
		// 		dataType: "JSON",
		// 		data: {
		// 			term: request.term
		// 		},
		// 		success: function( data ) {
		// 			console.log(data);
		// 			response(data);
		// 		}
		// 	})
		// },
		// minLength: 2,
		// select: function( event, ui ) {
		// 	$(this).next('input[name=section_name]').val(ui.item.value);
		// 	console.log(ui.item.value);
		// },
		// change: function (e, ui) {
		// 	if(!ui.item)
		// 	{
		// 		$(this).next('input[name=section_name]').val(0);
		// 		console.log(ui.value);
		// 	}
		// 	}
		// });
		 $("#section_name").autocomplete({
	        source: "<?php echo base_url('main/autocompleteData'); ?>",
	        select: function( event, ui ) {
	            event.preventDefault();
	            $("#section_name").val(ui.item.value);
	            $("input[name=section_yr_id]").val(ui.item.id);
	            $("#save-btn").prop( "disabled", false );
       		 },
       		change: function (e, ui) {
				if(!ui.item)
				{
					$('input[name=section_yr_id]').val(0);

					if($("input[name=section_yr_id]").val() == 0){
	        			$("#save-btn").prop( "disabled", true );
	        		}else{
	        			$("#save-btn").prop( "disabled", false );
	        		}
					console.log(ui.value);
				}
			}
    	});
	

    });
</script>