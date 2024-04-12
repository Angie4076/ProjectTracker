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
     * getcount_projects Model Action
     * @return Value
     */
	function getcount_projects(){
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
     * getcount_students Model Action
     * @return Value
     */
	function getcount_students(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM students";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_supervisors Model Action
     * @return Value
     */
	function getcount_supervisors(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM supervisors";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

}
