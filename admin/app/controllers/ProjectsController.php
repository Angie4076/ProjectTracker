<?php 
/**
 * Projects Page Controller
 * @category  Controller
 */
class ProjectsController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "projects";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"project_name", 
			"admission_number", 
			"supervisor", 
			"expected_date", 
			"feedback", 
			"submission_status", 
			"review_progress");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				projects.id LIKE ? OR 
				projects.project_name LIKE ? OR 
				projects.admission_number LIKE ? OR 
				projects.supervisor LIKE ? OR 
				projects.expected_date LIKE ? OR 
				projects.project_file LIKE ? OR 
				projects.feedback LIKE ? OR 
				projects.submission_status LIKE ? OR 
				projects.review_progress LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "projects/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("projects.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->projects_submission_status)){
			$val = $request->projects_submission_status;
			$db->where("projects.submission_status", $val , "=");
		}
		if(!empty($request->projects_review_progress)){
			$val = $request->projects_review_progress;
			$db->where("projects.review_progress", $val , "=");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		if(	!empty($records)){
			foreach($records as &$record){
				$record['expected_date'] = human_datetime($record['expected_date']);
			}
		}
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Student Projects";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("projects/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"project_name", 
			"admission_number", 
			"supervisor", 
			"expected_date", 
			"project_file", 
			"feedback", 
			"submission_status", 
			"review_progress");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("projects.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$record['expected_date'] = human_datetime($record['expected_date']);
			$page_title = $this->view->page_title = "Projects Details";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("projects/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("project_name","admission_number","supervisor","expected_date","feedback","review_progress");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'project_name' => 'required',
				'admission_number' => 'required',
				'supervisor' => 'required',
				'expected_date' => 'required',
				'feedback' => 'required',
				'review_progress' => 'required',
			);
			$this->sanitize_array = array(
				'project_name' => 'sanitize_string',
				'admission_number' => 'sanitize_string',
				'supervisor' => 'sanitize_string',
				'expected_date' => 'sanitize_string',
				'feedback' => 'sanitize_string',
				'review_progress' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Project added successfully", "success");
					return	$this->redirect("projects");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Projects";
		$this->render_view("projects/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","project_name","admission_number","supervisor","expected_date","feedback","review_progress");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'project_name' => 'required',
				'admission_number' => 'required',
				'supervisor' => 'required',
				'expected_date' => 'required',
				'feedback' => 'required',
				'review_progress' => 'required',
			);
			$this->sanitize_array = array(
				'project_name' => 'sanitize_string',
				'admission_number' => 'sanitize_string',
				'supervisor' => 'sanitize_string',
				'expected_date' => 'sanitize_string',
				'feedback' => 'sanitize_string',
				'review_progress' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("projects.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Project updated successfully", "success");
					return $this->redirect("projects");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("projects");
					}
				}
			}
		}
		$db->where("projects.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Projects";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("projects/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("projects.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("projects");
	}
}
