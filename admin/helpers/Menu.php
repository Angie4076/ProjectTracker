<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbartopleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-home "></i>'
		),
		
		array(
			'path' => 'projects', 
			'label' => 'Projects', 
			'icon' => '<i class="fa fa-list "></i>'
		),
		
		array(
			'path' => 'students', 
			'label' => 'Students', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'supervisors', 
			'label' => 'Supervisors', 
			'icon' => '<i class="fa fa-briefcase "></i>'
		)
	);
		
	
	
			public static $review_progress = array(
		array(
			"value" => "Pending Review", 
			"label" => "Pending Review", 
		),
		array(
			"value" => "Under Review", 
			"label" => "Under Review", 
		),
		array(
			"value" => "Review Complete", 
			"label" => "Review Complete", 
		),);
		
}