<?php
	$id = $_GET['id'];
	$output = array();
	$tble = "subjects";

   $data = $this->main_model->fetch_single_record($id,$tble);  
   foreach($data as $row)  
   {  
		$output['subject_name'] = $row->subject_name;  
		$output['year_level'] = $row->year_level;
		$output['section_name'] = $row->year_level;
		$output['section_year_lvl_id'] = $row->section_year_lvl_id;
		$output['section_name'] = $row->section_name;
		$output['status'] = $row->status;
   }
   
?>
<div class="card">
  <div class="card-header">
  	<div style="float:left">
  		<a href="<?= base_url('main/subjects');?>"><button class="btn btn-primary" id="edit_btn"><i class='far fa-arrow-alt-circle-left'></i> Back to List</button></a>
  	</div>

    <div style="float: right">
    	<button class="btn btn-primary" id="edit_btn_yr_lv">Edit</button>
    	<button class="btn btn-danger" id="delete_btn">Delete</button>
    </div>
  </div>
  <div class="card-body">
  	<div class="row">
  		<div class="col-md-2 border border-secondary">
  			<span><b>Subject Name</b></span>
  		</div>
  		<div class="col-md-3  p-2  border border-secondary" >
  			<span><?php echo $output['subject_name'];?></span>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-2 border border-secondary" >
  			<span><b>Grade Level</b></span>
  		</div>
  		<div class="col-md-3  p-2  border border-secondary">
  			<span><?php echo $output['year_level'];?></span>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-2 border border-secondary" >
  			<span><b>Section</b></span>
  		</div>
  		<div class="col-md-3  p-2  border border-secondary">
  			<span><?php echo $output['section_name'];?></span>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-2 border border-secondary" >
  			<span><b>Status</b></span>
  		</div>
  		<div class="col-md-3 p-2 border border-secondary">
  			<span><?php echo $output['status'];?></span>
  			<?php if($output['status'] == 'Inactive'):?>
  				<button class="btn btn-success btn-sm" style="float: right;" id="active_btn">Active</button>
  			<?php else:?>
  				<button class="btn btn-danger btn-sm" style="float: right;" id="inactive_btn">Inactive</button
  			<?php endif;?>
  		</div>
  	</div>
  </div>
</div>

<!--edit modal-->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form id="frm_subject_update" action="post">
				<div class="form-group">
					<label for="formGroupExampleInput">Subject Name</label>
					<?php
						$grade_level = array("Grade 7 (Junior HS)","Grade 8 (Junior HS)","Grade 9 (Junior HS)","Grade 10 (Junior HS)","Grade 11 (Senior HS)","Grade 12 (Senior HS)");
						//get current rec

					?>
					<input type="text" class="form-control" name="subject_name" id="formGroupExampleInput2" value="<?php echo $output['subject_name']; ?>" placeholder="">
			    </div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Section Name</label>
					<input type="text" id="section_name" class="form-control" value="<?=$output['section_name'];?>" placeholder="Select from existing section name">
					<input type="hidden" name="section_yr_id" value="<?= $output['section_year_lvl_id'] ?>">
					<input type="hidden" name="tble" value="subjects">
					<input type="hidden" name="id" value="<?= $id ?>">
				</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="update-btn">Save changes</button>
			</div>
		</form>
		</div>
	
	</div>
</div>

<!--delete modal-->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header btn-danger">
				<h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="frm_delete">
				<div class="modal-body">
					
						<h6>Are you sure you want to delete this?</h6>
						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
						<input type="hidden" name="tble" value="<?= $tble ?>">
					
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal">No</button>
					<button class="btn btn-danger" id="delete_year_lvl_btn"> Yes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
     $("#edit_btn_yr_lv").on("click", function() {
        $('#editmodal').modal('show');
    });
    $("#delete_btn").on( "click", function() {
   	 $('#deletemodal').modal('show');
    });
     //section year edit ajax
	    $("#frm_subject_update").on('submit', function(e) {
	        e.preventDefault();
	        $.ajax({
	            url: "<?= base_url('main/edit_records');?>",
	            type: "POST",
	            data: $("#frm_subject_update").serialize(),
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function(response) {
	                window.location.reload();
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });
	    $("#active_btn").on('click', function(e) {
	    		$.ajax({
	            url: "<?= base_url('main/update_subject_status');?>",
	            type: "POST",
	            data:
	            {
	            	status:"Active",
	            	id: $("input[name=id]").val(),
	            },
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function(response) {
	               window.location.href = '<?php echo base_url()."main/subjects";?>';
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });
	   	$("#inactive_btn").on('click', function(e) {
	    		$.ajax({
	            url: "<?= base_url('main/update_subject_status');?>",
	            type: "POST",
	            data:
	            {
	            	status:"Inactive",
	            	id: $("input[name=id]").val(),
	            },
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function(response) {
	               window.location.href = '<?php echo base_url()."main/subjects";?>';
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });


	    $("#frm_delete").on('submit', function(e) {
	        e.preventDefault();
	        $.ajax({
	            url: "<?= base_url('main/delete');?>",
	            type: "POST",
	            data: $("#frm_delete").serialize(),
	            dataType: "JSON",
	            beforeSend: function() {
	                
	            },
	            success: function(response) {
	               window.location.href = '<?php echo base_url()."main/subjects";?>';
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });
	    if($("input[name=section_yr_id]").val() == 0){
    		$("#update-btn").prop( "disabled", true );
        }
	    $("#section_name").autocomplete({
	        source: "<?php echo base_url('main/autocompleteData'); ?>",
	        select: function( event, ui ) {
	            event.preventDefault();
	            $("#section_name").val(ui.item.value);
	            $("input[name=section_yr_id]").val(ui.item.id);
	            $("#update-btn").prop( "disabled", false );
       		 },
       		change: function (e, ui) {
				if(!ui.item)
				{
					$('input[name=section_yr_id]').val(0);

					if($("input[name=section_yr_id]").val() == 0){
	        			$("#update-btn").prop( "disabled", true );
	        		}else{
	        			$("#update-btn").prop( "disabled", false );
	        		}
					console.log(ui.value);
				}
			}
    	});
</script>