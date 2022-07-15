<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Import</h1>
	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
	class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<div class="card shadow mb-4">
	<div class="card-header py-3">
	</div>
	<div class="card-body">
	    <!-- Display status message -->
	    <?php if(!empty($success_msg)){ ?>
	    <div class="col-xs-12">
	        <div class="alert alert-success"><?php echo $success_msg; ?></div>
	    </div>
	     <?php } ?>
	    <?php if(!empty($error_msg)){ ?>
	    <div class="col-xs-12">
	        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
	    </div>
	    <?php } ?>


		<div class="row">
	        <!-- Import link -->
	        <div class="col-md-12 head">
	            <div class="float-right">
	                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
	            </div>
	        </div>
			
	        <!-- File upload form -->
	        <div class="col-md-12" id="importFrm" style="display: none;">
	            <form action="<?php echo base_url('main/import'); ?>" method="post" enctype="multipart/form-data">
	                <input type="file" name="file" />
	                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
	            </form>
	        </div>
	    </div>

					
</div>
<script>

function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}

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