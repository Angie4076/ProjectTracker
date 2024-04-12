<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * projects_admission_number_option_list Model Action
     * @return array
     */
	function projects_admission_number_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT student_number AS value,student_number AS label FROM students ORDER BY student_number ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * projects_supervisor_option_list Model Action
     * @return array
     */
	function projects_supervisor_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT supervisor_name AS value,supervisor_name AS label FROM supervisors ORDER BY supervisor_name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * projects_projectssubmission_status_option_list Model Action
     * @return array
     */
	function projects_projectssubmission_status_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT submission_status AS value,submission_status AS label FROM projects ORDER BY submission_status";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * projects_projectsreview_progress_option_list Model Action
     * @return array
     */
	function projects_projectsreview_progress_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT review_progress AS value,review_progress AS label FROM projects ORDER BY review_progress";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * getcount_submittedprojects Model Action
     * @return Value
     */
	function getcount_submittedprojects(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM projects";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_completedprojects Model Action
     * @return Value
     */
	function getcount_completedprojects(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM completed_projects";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_pendingprojects Model Action
     * @return Value
     */
	function getcount_pendingprojects(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM pending_projects";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
	* piechart_reviewstatus Model Action
	* @return array
	*/
	function piechart_reviewstatus(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(p.id) AS count_of_id, p.review_progress FROM projects AS p GROUP BY p.review_progress";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_id');
		$dataset_labels =  array_column($dataset1, 'review_progress');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}
