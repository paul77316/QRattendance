<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		/*Load Form Validation Library*/
		// $this->load->library('form_validation');
		/*Load MLogin model that we created to fetch data from user table*/
		$this->load->model('main_model');
		$this->load->helper('url');
		 // Load file helper
        $this->load->helper('file');
        // Load form validation library
        $this->load->library('form_validation');
		
	}
	public function index()
	{
			/*Load the login screen, if the user is not log in*/
			if (isset($_SESSION['login']['id'])) {
				/*check the session of user, if it is available, it means the user is already log in*/
				$this->load->view('header');
				$this->load->view('home');
			} else {
				/*if not, display the login window*/
				$this->load->view('login');
			}
		
	}
	public function home()
	{
		
		// $this->load->helper('url');
		/*Load the dashboard screen, if the user is already log in*/
		if (isset($_SESSION['login']['id'])) {
			$this->load->view('header');
			$this->load->view('dashboard');
			$this->load->view('footer');

		} else {
			$this->load->view('login');
		}
		
	}
	public function doLogin()
	{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			/*Create object of model MLogin.php file under models folder*/
			$Login = new main_model();
			/*validate($username, $Password) is the function in Mlogin.php*/
			$result = $Login->validate($username, $password);
			if (count($result) == 1) {
				/*If everything is fine, then go here, and return 1 as output and set session*/
				$data = array(
					'id' => $result[0]->id,
					'username' => $result[0]->user_name,
					'lastname' => $result[0]->lastname,
					'firstname' => $result[0]->firstname,
					'middlename' => $result[0]->middlename

				);
				$this->session->set_userdata('login', $data);
				echo 1;
			} else {
				/*If Both Username &  Password that we recieved is invalid, go here, and return 5 as output*/
				echo 5;
			}
		   
   

	}
		/******************************* */
		/*	SUBJECTS RELATED			*/
		/****************************** */
		public function subjects(){
				$this->load->view('header');
				$this->load->view('subjects');
				$this->load->view('footer');
		}
		// public function get_autocomplete(){
		//     if (isset($_POST['term'])) {
		//         $result = $this->main_model->getSectionNameAutoComplete($_POST['term']);
		//         if (count($result) > 0) {
		//             foreach ($result as $row)
		//                 $arr_result[] = array(
		//                     'id'   => $row->id,
		//                     'text'   => $row->section_name .'|'. $row->year_level,
		//              );
		//                 echo json_encode($arr_result);
		//         }
		//     }
		// }
		public function autocompleteData() {
		$returnData = array();
		$db="";
		$field="";
		$module = $this->input->get('module');
		if($module == 'section'){	
			$db = "section_year_lvl";
			$field ="section_name";
		}

		else if($module == 'sbj'){	
			$db = "subjects";
			$field ="subject_name";
		}


		// Get skills data
		$conditions['searchTerm'] = $this->input->get('term');
		$skillData = $this->main_model->getRows($conditions,$db,$field);
		
		// Generate array
	
		if(!empty($skillData)){
			foreach ($skillData as $row){
				$data['id'] = $row['id'];
				if($module == 'section'){
					$data['value'] = $row['section_name']."|".$row['year_level'];
				}
				elseif($module == 'sbj'){
					$data['value'] = $row['subject_name'];
				}
				array_push($returnData, $data);
			}
		}
		
		// else if($module == 'sbj'){
		// 	if(!empty($skillData)){
		// 		foreach ($skillData as $row){
		// 			$data['id'] = $row['id'];
		// 			$data['value'] = $row['subject_name'];
		// 			array_push($returnData, $data);
		// 		}
		// 	}

		// }

		
		// Return results as json encoded array
		echo json_encode($returnData);
	}
		/******************************* */
		/*	SECTION YR LEVEL			*/
		/****************************** */
		public function section_yr_lvl(){
			$this->load->view('header');
			$this->load->view('section_yr_lvl');
			$this->load->view('footer');

		}
		public function add_section_yr(){
				$db ="section_year_lvl";  
				 $insert_data = array(  
					  'year_level'=>$this->input->post('level'),  
					  'section_name'=> $this->input->post("section_name"),
					  'created_by'=> $this->input->post("created_by"),
					  'created_at'=> date('Y-m-d'),
					);  
 
			$insert = $this->main_model->insert_data($db,$insert_data); 
			echo json_encode($insert);
	   }
	   public function add_class()
	   {
		 $db ="classes";  
		 $insert_data = array(  
			  'class_name'=>$this->input->post('class_name'),  
			  'start_time'=> $this->input->post("class_start_time"),
			  'end_time'=> $this->input->post("class_end_time"),
			  'subject_id'=> $this->input->post("class_subject_id"),
			  'teacher_id'=> $this->input->post("class_teacher"),
			  'section_year_lvl_id'=> $this->input->post("class_yr_lvl_id"),
			  'school_year'=> $this->input->post("class_school_yr"),
			  'created_by'=> $this->input->post("created_by"),
			  'created_at'=> date('Y-m-d'),
			);  

			$insert = $this->main_model->insert_data($db,$insert_data); 
			echo json_encode($insert);
	   }
	  public function add_subject(){
		$db ="subjects";  
		 $insert_data = array(  
			  'subject_name'=>$this->input->post('subject_name'),  
			  'section_year_lvl_id'=> $this->input->post("section_yr_id"),
			  'created_by'=> $this->input->post("created_by"),
			  'created_at'=> date('Y-m-d'),
			  'status'=> "Inactive",
			);  

		$insert = $this->main_model->insert_data($db,$insert_data); 
		echo json_encode($insert);
	   }

	   function fetch_user(){  
		   $module="syl";
		   $fetch_data = $this->main_model->make_datatables($module);  
		   $data = array();
		   $base_url = "";  
		   foreach($fetch_data as $row)  
		   {  
				if($row->deleted_at == '0'){
				$sub_array = array();
				$sub_array[] = $row->id;  
				$sub_array[] = $row->year_level;  
				$sub_array[] = $row->section_name;  
				$sub_array[] = '<a href="view_section_yr_lvl?id='.$row->id.' "><button type="button" name="update" id="'.$row->id.'" class="btn btn-primary btn-sm update">View</button></a>';
				$data[] = $sub_array;

				}
			   
		   }
		   $output = array(  
				"draw"  => intval($_POST["draw"]),  
				"recordsTotal"  =>  $this->main_model->get_all_data($module),  
				"recordsFiltered" => $this->main_model->get_filtered_data($module),  
				"data" =>   $data  
		   ); 
		   $this->session->set_userdata('sd', $data); 
		   echo json_encode($output);  
	  }
	   function fetch_user2()
	   {   
	   	   $module="sbj";
		   $fetch_data = $this->main_model->make_datatables($module);  
		   $data = array();
		   $base_url = "";
		   $style="";  
		   foreach($fetch_data as $row)  
		   {  
				if($row->sbj_deleted == '0'){
				$sub_array = array();
				if($row->status == 'Active'){
					$style="font-size:15px;float:right;color:#00b300";
				}
				else{
					$style="font-size:15px;float:right;color:#e62e00";
				}
				$sub_array[] = $row->sbj_id;  
				$sub_array[] = $row->subject_name;  
				$sub_array[] = $row->year_level;
				$sub_array[] = $row->section_name;
				$sub_array[] = $row->status." ". "<i class='fas fa-circle' style='".$style."'></i>";
				$sub_array[] = '<a href="view_subject?id='.$row->sbj_id.' "><button type="button" name="update" id="'.$row->sbj_id.'" class="btn btn-primary btn-sm update">View</button></a>';
				$data[] = $sub_array;
				}
		   
		   }
		   $output = array(  
				"draw"  => intval($_POST["draw"]),  
				"recordsTotal"  =>  $this->main_model->get_all_data($module),  
				"recordsFiltered" => $this->main_model->get_filtered_data($module),  
				"data" =>   $data  
		   ); 
		   $this->session->set_userdata('sd', $data); 
		   echo json_encode($output);  
		}

		function fetch_user3()
	   {   
	   	   $module="classes";
		   $fetch_data = $this->main_model->make_datatables($module);  
		   $data = array();
		   $base_url = "";
		   $style="";  
		   foreach($fetch_data as $row)  
		   {  
				if($row->cl_deleted == '0'){
				$sub_array = array();
				$sub_array[] = $row->id;  
				$sub_array[] = $row->class_name;  
				$sub_array[] = $row->start_time;
				$sub_array[] = $row->end_time;
				$sub_array[] = $row->section_name;
				$sub_array[] = $row->teacher_name;
				// $sub_array[] = '<a href="view_subject?id='.$row->sbj_id.' "><button type="button" name="update" id="'.$row->sbj_id.'" class="btn btn-primary btn-sm update">View</button></a>';
				$data[] = $sub_array;
				}
		   
		   }
		   $output = array(  
				"draw"  => intval($_POST["draw"]),  
				"recordsTotal"  =>  $this->main_model->get_all_data($module),  
				"recordsFiltered" => $this->main_model->get_filtered_data($module),  
				"data" =>   $data  
		   ); 
		   $this->session->set_userdata('sd', $data); 
		   echo json_encode($output);  
		}   
		function edit_records()
		{
		 	$id = $this->input->post('id');
		 	$tble = $this->input->post('tble');

			 if( $this->input->post('tble') == 'section_year_lvl'){
			 	 $data = array (
				 'year_level' => $this->input->post('level'),
				 'section_name' => $this->input->post('section_name')
				);
			 }
			 elseif ($this->input->post('tble') == 'subjects') {
			 	$data = array (
				 'subject_name' => $this->input->post('subject_name'),
				 'section_year_lvl_id' => $this->input->post('section_yr_id')
				);

			 }

			$this->main_model->update_record($data,$id,$tble);
			echo json_encode($data);    
		}
		function update_subject_status()
		{
		 $id = $this->input->post('id');
		 $data = array (
			 'status' => $this->input->post('status'),
			);
			$this->main_model->update_subject_status($data,$id);
			echo json_encode($id);    
		}
		function endClass()
		{
		date_default_timezone_set("Asia/Manila");
		 $timeout = date('g:i a');
		 $classid = $this->input->post('class');
		 $date = $this->input->post('datenow');

		 $data = array (
			 'out' => $timeout
			);
			$this->main_model->update_class_timeout($data,$classid,$date);
			echo json_encode($data);    
		}
	   function view_section_yr_lvl(){
			
			$this->load->view('header');
			$this->load->view('view_section_yr_lvl');
			$this->load->view('footer');
		   
		   // echo json_encode($output);
	  }
	   function view_attendance(){
	  		$aa = $_GET['classid'];
			
			$this->load->view('header');
			$this->load->view('view_attendance',$aa);
			$this->load->view('footer');
	  }



	  function upload_student(){
		$data = array();
        
        // Get messages from the session
	        if($this->session->userdata('success_msg')){
	            $data['success_msg'] = $this->session->userdata('success_msg');
	            $this->session->unset_userdata('success_msg');
	        }
	        if($this->session->userdata('error_msg')){
	            $data['error_msg'] = $this->session->userdata('error_msg');
	            $this->session->unset_userdata('error_msg');
	        }
        
        // Get rows
        // $data['members'] = $this->main_model->getRows();
			$this->load->view('header');
			$this->load->view('upload_student',$data);
			$this->load->view('footer');
		   
		   // echo json_encode($output);
	  }
	  function view_subject(){
			
			$this->load->view('header');
			$this->load->view('view_subject');
			$this->load->view('footer');
		   
		   // echo json_encode($output);
	  }
	  function delete(){
		 $id = $this->input->post('id');
		 $tble = $this->input->post('tble');
		 $data = array (
			 'deleted_at' => date('Y-m-d h:i:s'),
			);
			$this->main_model->update_delete_record($data,$id,$tble);
			echo json_encode($data);  

	 } 
	   /******************************* */
		/*	END SECTION YR LEVEL			*/
		/****************************** */ 

		public function doLogout()
		{
			$this->session->unset_userdata('login');
			redirect(site_url('main/index'));
		}

		public function reset_session()
		{
			$this->session->unset_userdata('sd');
		}

		public function import()
		{
	        $data = array();
	        $memData = array();
        
        	// If import request is submitted
       		if($this->input->post('importSubmit')){
	            // Form field validation rules
	            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;
                
                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row){ $rowCount++;
                            
                            // Prepare data for DB insertion
                            $memData = array(
                            	'student_id' => $row['student_id'],
                                'section/year_lvl_id' => $row['section/year_lvl_id'],
                                'lastname' => $row['lastname'],
                                'firstname' => $row['firstname'],
                                'middlename' => $row['middlename'],
                                 'email_address' => $row['email_address'],
                            );
                            
                            // Check whether email already exists in the database
                            $con = array(
                                'where' => array(
                                    'email_address' => $row['email_address']
                                ),
                                'returnType' => 'count'
                            );
                            $prevCount = $this->main_model->getRowsImport($con);
                            
                            if($prevCount > 0){
                                // Update member data
                                $condition = array('email_address' => $row['email_address']);
                                $update = $this->main_model->updateImport($memData, $condition);
                                
                                if($update){
                                    $updateCount++;
                                }
                            }else{
                                // Insert member data
                                $insert = $this->main_model->insertImport($memData);
                                
                                if($insert){
                                    $insertCount++;
                                }
                            }
                        }
                        
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                        $this->session->set_userdata('success_msg', $successMsg);
                    }
	                }else{
	                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
	                }
	            }else{
	                $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
	            }
	        }
	        redirect('main/upload_student');
	    }
	        /*
     * Callback function to check file value and type during validation
     */
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
           }
        }

        /***********************/
        /* CLASSES RELATED 	*/

        public function classes(){
			$this->load->view('header');
			$this->load->view('classes');
			$this->load->view('footer');
		}
		/******************************* */
		/*	CHECK ATTENDANCE			*/
		/****************************** */
		public function check_attendance(){
			$this->load->view('header');
			$this->load->view('check_attendance');
			$this->load->view('footer');

		}
        public function add_attendance_log(){
        	date_default_timezone_set("Asia/Manila");
			$db ="attandance_logs";
			$db2 ="students";  
			$check = new main_model();
			$studentID = $this->input->post('student_id');
			$checking = $check->checkStudentID($studentID, $db2);

			if ( $this->input->post("class") == '') {
				$msg = "Class is required. Please Select a Class";
			}
			elseif(count($checking) == 0){
				$msg = "Student Number Not Found";
				
			}
			else{
				$date = $this->input->post('datenow');
				$in = date('g:i a');
				$classid = $this->input->post("class");
				$studentID = $this->input->post("student_id");

				$checkduplicate = $this->main_model->checkDuplicteLogs($date,$classid,$studentID,$in);

				if(count($checkduplicate) == 0){
					$insert_data = array(  
					  'date'=>$this->input->post('datenow'),  
					  'in'=> date('g:i a'),
					  'class_id'=> $this->input->post("class"),
					  'student_id'=>$this->input->post("student_id")
					);
					$insert = $this->main_model->insert_data($db,$insert_data);   
				}

			}
			// $insert = $this->main_model->insert_data($db,$insert_data); 
			echo json_encode($msg);
	   }
	  function createExcel() {
	  	$classid = $_GET['classid'];
		$fileName = 'attendance.xlsx';  
		$Data = $this->main_model->attendanceList($classid);   
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Student ID');
        $sheet->setCellValue('B1', 'Last Name');
        $sheet->setCellValue('C1', 'First Name');
        $sheet->setCellValue('D1', 'Middle Name');
		$sheet->setCellValue('E1', 'Date');
        $sheet->setCellValue('F1', 'Time In');    
        $rows = 2;
        foreach ($Data as $val){
            $sheet->setCellValue('A' . $rows, $val['student_id']);
            $sheet->setCellValue('B' . $rows, $val['lastname']);
            $sheet->setCellValue('C' . $rows, $val['firstname']);
            $sheet->setCellValue('D' . $rows, $val['middlename']);
	    	$sheet->setCellValue('E' . $rows, $val['date']);
            $sheet->setCellValue('F' . $rows, $val['in']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("upload/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/upload/".$fileName);              
    }  

}
