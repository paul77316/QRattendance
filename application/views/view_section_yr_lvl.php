<?php
	$id = $_GET['id'];
	$output = array();
	$tble = "section_year_lvl";

   $data = $this->main_model->fetch_single_record($id,$tble);  
   foreach($data as $row)  
   {  
		$output['year_level'] = $row->year_level;  
		$output['section_name'] = $row->section_name;
   }
   
?>
<div class="card">
  <div class="card-header">
  	<div style="float:left">
  		<a href="<?= base_url('main/section_yr_lvl');?>"><button class="btn btn-primary" id="edit_btn"><i class='far fa-arrow-alt-circle-left'></i> Back to List</button></a>
  	</div>

    <div style="float: right">
    	<button class="btn btn-primary" id="edit_btn_yr_lv">Edit</button>
    	<button class="btn btn-danger" id="delete_btn">Delete</button>
    </div>
  </div>
  <div class="card-body">
  	<div class="row">
  		<div class="col-md-2 border border-secondary">
  			<span><b>Grade Level</b></span>
  		</div>
  		<div class="col-md-3 border border-secondary" >
  			<span><?php echo $output['year_level'];?></span>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-2 border border-secondary" >
  			<span><b>Section Name</b></span>
  		</div>
  		<div class="col-md-3 border border-secondary">
  			<span><?php echo $output['section_name'];?></span>
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
			<form id="frm_section_yr_edit" action="post">
				<div class="form-group">
					<label for="formGroupExampleInput">Grade Level</label>
					<?php
						$grade_level = array("Grade 7 (Junior HS)","Grade 8 (Junior HS)","Grade 9 (Junior HS)","Grade 10 (Junior HS)","Grade 11 (Senior HS)","Grade 12 (Senior HS)");
						//get current rec

					?>

                    <select id="grade" name="level" class="form-control">
                       	<?php foreach($grade_level as $level) :?>
                       		<option <?= $level == $output['year_level'] ? 'selected' : ''; ?>> <?php echo $level ?></option>
                       <?php endforeach;?>
                    </select>
			    </div>
				<div class="form-group">
					<label for="formGroupExampleInput2">Section Name</label>
					<input type="text" class="form-control" name="section_name" id="formGroupExampleInput2" value="<?php echo $output['section_name']; ?>" placeholder="">
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" placeholder="">
					<input type="hidden" name="tble" value="section_year_lvl">
				</div>
				<!-- 
				<div class="form-group">
					<label for="formGroupExampleInput2">Adviser</label>
					<input type="text" class="form-control" id="adviser" id="formGroupExampleInput2" placeholder="" readonly value="<?= $_SESSION['login']['lastname'].", ".$_SESSION['login']['firstname']." ".$_SESSION['login']['middlename'] ?>">
					<input type="hidden" class="form-control"  name="adviser" placeholder="" value="<?= $_SESSION['login']['id']?>">
				</div> -->
		
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" >Save changes</button>
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
	    $("#frm_section_yr_edit").on('submit', function(e) {
	        e.preventDefault();
	        $.ajax({
	            url: "<?= base_url('main/edit_records');?>",
	            type: "POST",
	            data: $("#frm_section_yr_edit").serialize(),
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
	               window.location.href = '<?php echo base_url()."main/section_yr_lvl";?>';
	            },
	            complete: function() {
	               
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	            }
	        });
	    });
</script>