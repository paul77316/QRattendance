<?php $classid = $_GET['classid']; ?>
<div class="card">
	  <div class="card-header">
	  	<div style="float:left">
	  		<h4>Attendance Lists</h4>
	  	</div>

	    <div style="float: right">
	    	<a class="pull-right btn btn-warning btn-large" style="margin-right:40px" href="<?php echo base_url(); ?>main/createExcel?classid=<?php echo $classid;?>"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
	    </div>
	  </div>
	  <div class="card-body">
	  	<table class="table table-hover tablesorter">
		<thead>
			<tr>
				<th class="header">Student ID</th>
				<th class="header">Last Name</th> 
				<th class="header">First Name</th>
				<th class="header">Middle Name</th>  
				<th class="header">Date</th>
				<th class="header">Time In</th>
				<th class="header">Time Out</th>
				<th class="header">Class Subject</th>
				<th class="header">Remarks</th>                        
			</tr>
		</thead>

		<tbody>
			<?php
				
				$datas = $this->main_model->attendanceList($classid);  
			?>
			<?php foreach($datas as $data):?>
				<tr> 
					<td> <?php echo $data['student_id'];?></td>
					<td> <?php echo $data['lastname'];?></td>
					<td> <?php echo $data['firstname'];?></td>
					<td> <?php echo $data['middlename'];?></td>
					<td> <?php echo $data['date'];?></td>
					<td> <?php echo $data['in'];?></td>
					<td> <?php echo $data['out'];?></td>
					<td> <?php echo $data['class_name'];?></td>
					<td> 
						<?php if($data['in'] == '' || $data['out'] == ''):?>
							Absent
						<?php else:?>
							Present
						<?php endif;?>
					</td>
				</tr>

			<?php endforeach;?>
				 
		</tbody>
		</table> 
	  </div>
</div>
