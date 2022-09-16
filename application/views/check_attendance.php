<div class="card shadow mb-4">
	<div class="card-header py-3">
		<a data-target="#exampleModal" id="end_class_btn" class="btn d-sm-inline-block shadow-sm btn-sm btn-primary float-right" style="width:8%;background:#4e73df">
		<i class="fa fa-hourglass-end fa-sm text-white-50"></i> End Class</a>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				 <div id="reader" style="width:100%;"></div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleFormControlSelect1">Student ID</label>
					<input type="text" class="form-control" id="student_id" name="student_id">
				</div>
				 <div class="form-group">
					<label for="exampleFormControlSelect1">Select Class Subject</label>
					<select class="form-control" id="class" name="class" required>
						<option value="">---SELECT---</option>
							<?php
							$tble = "classes"; 
							$data = $this->main_model->fetchAllData($tble);  
							   foreach($data as $row)  
					   			{  
						   		if($row->deleted_at == 0 && $row->teacher_id == $_SESSION['login']['id']){
						   			echo "<option value='".$row->id."'> ".$row->class_name." </option>";
					   			}
						
				   			}
							?>
					</select>
				 </div>
				  <div class="form-group">
					<label for="exampleFormControlSelect1">Date</label>
					<input type="text" id="datenow" name="datenow" class="form-control" value="<?php echo date('Y-m-d', strtotime("now"));?>" readonly>
				 </div>			
				
				<div style="float:right;">
					<div class="row">
						<div class="col-md-6">
							<div class="form-check" style="width: 100%;width: 200px;">
								<input type="checkbox" class="form-check-input" id="exampleCheck1">
								<label class="form-check-label" for="exampleCheck1">Save Manually</label>
  					   		</div>
						</div>
						<div class="col-md-6">
							<button class="btn btn-primary" id="save-btn" disabled>Save</button>
						</div>
					</div>
				</div>
				<!-- <p class="d-none status"><b>Status:</b> <span id="txtHint"></span></p> -->
				<p class="err_msg"><b>Error Message: </b><span id="err_msg" class=""></span></p>
			</div>
		</div>
	</div>		
</div>

<script>
$(document).ready(function() {

		$("#exampleCheck1").on("click", function(){
  			if($(this).is(':checked') == true){
  				$('#save-btn').prop("disabled",false);
  			}
  			else{
  				$('#save-btn').prop("disabled",true);
  			}
		});
		$("#end_class_btn").on("click", function(e){
			e.preventDefault();
			$('#confirm-modal').modal('show');
		});

		$("#end-class").on("click", function(e){
			endClass();
		});
		$("#save-btn").on("click", function(){
  			saveAttendance();
		});
});

// });
// function showHint(str) {
//   if (str.length == 0) {
//     document.getElementById("txtHint").innerHTML = "";
//     return;
//   } else {
//     var xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//       if (this.readyState == 4 && this.status == 200) {
//         document.getElementById("txtHint").innerHTML = this.responseText;
//       }
//     };
//     xmlhttp.open("GET", "gethint.php?q=" + str, true);
//     xmlhttp.send();
//   }
// }

// function playAudio() { 
//   x.play(); 
// }

function endClass(){
	classid = $('#class').val();
  		$.ajax({
            url: "<?= base_url('main/endClass');?>",
            type: "POST",
            data: {
            	class: $('#class').val(),
            	datenow: $('#datenow').val()
            },
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data) {
                // $('#err_msg').text(data);
                window.location.href = "<?php base_url();?>"+"view_attendance"+"?classid"+"="+classid;
            },
            complete: function() {
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
       });
} 
function saveAttendance(){
  		$.ajax({
            url: "<?= base_url('main/add_attendance_log');?>",
            type: "POST",
            data: {
            	student_id: $('#student_id').val(),
            	class: $('#class').val(),
            	datenow: $('#datenow').val()
            },
            dataType: "JSON",
            beforeSend: function() {
                
            },
            success: function(data) {
                // // window.location.reload();
                // $('.status').removeClass('d-none');
                // $('.err_msg').removeClass('d-none');
                // if(data == 'Class is required. Please Select a Class'){
                // 	$('#txtHint').addClass('text-danger')
                // 	$('#txtHint').text('Invalid');
                // }
                // else if(data == 'Student Number Not Found'){
                // 	$('#txtHint').addClass('text-danger')
                // 	$('#txtHint').text('Invalid');
                // }
                // else{
                // 	$('#txtHint').removeClass('text-danger');
                // 	$('#txtHint').addClass('text-success')
                // 	$('#txtHint').text('Successfully Saved');
                // 	$('.err_msg').addClass('d-none');
                // }
                // console.log(data);
                $('#err_msg').text(data);
            },
            complete: function() {
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
       });
}
function onScanSuccess(qrCodeMessage) {
    document.getElementById("student_id").value = qrCodeMessage;
    if(qrCodeMessage){
    	 saveAttendance();
    }
    return qrCodeMessage;

}
function onScanError(errorMessage) {
  //handle scan error
}
var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>