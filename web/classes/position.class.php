<?php
/**
* @author Joshua Anderson
* Date: 1/5/14
* Description: Class for a Position
* A position object contains information regarding that specific position as well as combining the three primary entities - student, 
* company, and suerpvisor.
*
*/

//require('../library/common/config.php');
//require('bindparam.class.php');
include_once('student.class.php');
include_once('supervisor.class.php'); //only student and supervisor here because supervisor includes company.class.php

class Position {
	public $positionId;
	public $title;
	public $term;
	public $year;
	public $is_paid;
	public $notes;
	public $est_hours_week;

	public $Student; //fk object to Student
	public $Company; //fk object to Company
	public $Supervisor; //fk object to Supervisor

	function __construct() {
		$this->Student = new Student();
    	$this->Company = new Company();
    	$this->Supervisor = new Supervisor();
    }

    
	
}

?>