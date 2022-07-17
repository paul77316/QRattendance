<?php
class main_model extends CI_Model
{
	public $Modal;
//section year level
	var $table = "section_year_lvl";
	// var $table = "subjects";
	var $where = "deleted_at = '0'";
	var $select_column = array("id", "year_level", "section_name", "deleted_at");    
	var $order_column = array(null, "year_level", "section_name", null, null);

//subjects
	var $table2 = "subjects";
	var $where2 = "subjects.deleted_at = '0'";
	var $select_column2 = array("subjects.id as sbj_id","section_year_lvl.id as syl_id", "section_year_lvl.year_level","section_year_lvl.section_name", "subjects.subject_name as subject_name", "subjects.status as status","subjects.deleted_at as sbj_deleted");    
	var $order_column2 = array(null, "year_level", "section_name", null, null);  

//classess
	var $table3 = "subjects";
	var $where3 = "subjects.deleted_at = '0'";
	var $select_column3 = array("subjects.id as sbj_id","section_year_lvl.id as syl_id", "section_year_lvl.year_level","section_year_lvl.section_name", "subjects.subject_name as subject_name", "subjects.status as status","subjects.deleted_at as sbj_deleted");    
	var $order_column3 = array(null, "year_level", "section_name", null, null);  



	public function __construct()
	{
		parent::__construct();
  
	}
	 function make_query($module)  
	 {  

	 	if($module == "syl")
	 	{
	 		 $this->db->select($this->select_column);
			$this->db->from($this->table);
			// $this->db->join('section_year_lvl', 'section_year_lvl.id = Books.BookID', 'left');
			$this->db->where($this->where);
		   if(isset($_POST["search"]["value"]))  
		   {  
				$this->db->like("year_level", $_POST["search"]["value"]);  
				$this->db->or_like("section_name", $_POST["search"]["value"]);  
		   }  
		   if(isset($_POST["order"]))  
		   {  
				$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		   }  
		   else  
		   {  
				$this->db->order_by('id', 'DESC');

		   } 	
	 	}
	 	elseif($module == "sbj")
	 	{
	 		$this->db->select($this->select_column2);
			$this->db->from($this->table2);
			$this->db->join('section_year_lvl', 'section_year_lvl.id = subjects.section_year_lvl_id', 'left');
			$this->db->where($this->where2);
		   if(isset($_POST["search"]["value"]))  
		   {  
				$this->db->like("year_level", $_POST["search"]["value"]);  
				$this->db->or_like("section_name", $_POST["search"]["value"]);  
		   }  
		   if(isset($_POST["order"]))  
		   {  
				$this->db->order_by($this->order_column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		   }  
		   else  
		   {  
				$this->db->order_by('sbj_id', 'DESC');

		   } 

	 	}
	 	elseif($module == "classes")
	 	{
	 		$this->db->select($this->select_column2);
			$this->db->from($this->table2);
			$this->db->join('section_year_lvl', 'section_year_lvl.id = subjects.section_year_lvl_id', 'left');
			$this->db->where($this->where2);
		   if(isset($_POST["search"]["value"]))  
		   {  
				$this->db->like("year_level", $_POST["search"]["value"]);  
				$this->db->or_like("section_name", $_POST["search"]["value"]);  
		   }  
		   if(isset($_POST["order"]))  
		   {  
				$this->db->order_by($this->order_column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		   }  
		   else  
		   {  
				$this->db->order_by('sbj_id', 'DESC');

		   } 

	 	}

	 
	 }

		 // function make_query()  
	 	//  {  
			// // $this->db->select($this->select_column);
			// $this->db->from("subjects");
			// $this->db->lefJoin("section_year_lvl on subjects.section_year_lvl=section_year_lvl.id");
			// $this->db->where("subjects.deleted_at=0");
		 //   if(isset($_POST["search"]["value"]))  
		 //   {  
			// 	$this->db->like("year_level", $_POST["search"]["value"]);  
			// 	$this->db->or_like("section_name", $_POST["search"]["value"]);  
		 //   }  
		 //   if(isset($_POST["order"]))  
		 //   {  
			// 	$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		 //   }  
		 //   else  
		 //   {  
			// 	$this->db->order_by('id', 'DESC');

		 //   }  
	  //    }

	  // function getSectionNameAutoComplete($section_name){
		 //   $this->db->like('section_name', $section_name, 'both');
		 //   $this->db->order_by('id');
		 //   $this->db->limit(5);
		 // return $this->db->get('section_year_lvl')->result();
	  // } 
	  function getRows($params = array(),$db,$field){
       

        	$this->db->select("*");
	        $this->db->where("deleted_at='0'");
	        $this->db->from($db);	
    
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        
        //search by terms
        if(!empty($params['searchTerm'])){
            $this->db->like($field, $params['searchTerm']);
        }
        
        $this->db->order_by($field, 'asc');
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            $query = $this->db->get();
            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
        }

        //return fetched data
        return $result;
    }
	function get_all_data($module)  
	{  
	   $this->db->select("*");
	   if($module == "syl"){
	   	    $this->db->where($this->where);
	   		$this->db->from($this->table);
	   }
	   elseif($module == "sbj"){
			 $this->db->where($this->where2);
	   		$this->db->from($this->table2);
	   }
	 
	   return $this->db->count_all_results();  
	}  
	function make_datatables($module){  
       $this->make_query($module);

       if($_POST["length"] != -1)  
       {  
		$this->db->limit($_POST['length'], $_POST['start']);  
       }  
       $query = $this->db->get();  
       return $query->result();  
	}
	function get_filtered_data($module){  
	   $this->make_query($module);
	   if($module == 'syl')
	   {
	   	   $this->db->where($this->where); 
	   }
	   elseif($module == 'sbj'){
	   	   $this->db->where($this->where2); 
	   }
	 
	   $query = $this->db->get();

	   return $query->num_rows();  
	 }   

	/*function to use fetch the data from users table*/
	function validate($user, $pass)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('password', $pass);
		$this->db->where('user_name', $user);
		$query = $this->db->get();
		$res = $query->result();
		return $res;
	}
	//insert model
	function insert_data($db,$data)  
	{  
		 $query = $this->db->insert($db, $data);
		 return $query;

	}
	function fetch_single_record($where,$tble)  
	{      if($tble == "subjects")
			{
				$this->db->where("subjects.id", $where);
				$this->db->join('section_year_lvl', 'section_year_lvl.id = subjects.section_year_lvl_id', 'left');
				$this->db->from($tble);  
		   		$query=$this->db->get(); 
			}
			else
			{
				$this->db->where("id", $where);  
		   		$query=$this->db->get($tble);  

			}
		 
		   return $query->result();  
	}  

	 public function fetchAllData($table)
	{
		$query = $this->db->get($table);
		 return $query->result();
	}
	function update_record($data,$id,$tble)
	{
		if($tble == 'subjects'){
			$this->db->where('id', $id);
			$this->db->update('subjects', $data);
		}
		elseif ($tble == 'section_year_lvl') {
			$this->db->where('id', $id);
			$this->db->update('section_year_lvl', $data);
		}
		
	}

	function update_delete_record($data,$id,$tble)
	{
		if($tble == 'subjects'){
			$this->db->where('id', $id);
			$this->db->update('subjects', $data);
		}
		elseif ($tble == 'section_year_lvl') {
			$this->db->where('id', $id);
			$this->db->update('section_year_lvl', $data);
		}
		
	}
	function update_subject_status($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('subjects', $data);
	}

	 function getRowsImport($params = array())
	 {
        $this->db->select('*');
        $this->db->from("students");
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('id', 'desc');
                if(array_key_exists("
                	",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }
     /*
     * Insert members data into the database
     * @param $data data to be insert based on the passed parameters
     */
    public function insertImport($data = array()) {
        if(!empty($data)){
            // Add created and modified date if not included
            // if(!array_key_exists("created", $data)){
            //     $data['created'] = date("Y-m-d H:i:s");
            // }
            // if(!array_key_exists("modified", $data)){
            //     $data['modified'] = date("Y-m-d H:i:s");
            // }
            
            // Insert member data
            $insert = $this->db->insert("students", $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }
     /*
     * Update member data into the database
     * @param $data array to be update based on the passed parameters
     * @param $condition array filter data
     */
    public function updateImport($data, $condition = array()) {
        if(!empty($data)){
            // Add modified date if not included
            // if(!array_key_exists("modified", $data)){
            //     $data['modified'] = date("Y-m-d H:i:s");
            // }
            
            // Update member data
            $update = $this->db->update("students", $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }
    

}
?>