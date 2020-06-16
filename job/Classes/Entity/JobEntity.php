<?php
//Entity class for jobs
namespace Classes\Entity;

use DateTime;

class JobEntity {
    public $applicantTable;
    public $categoryTable;
    public $id;
    public $title;
    public $categoryId;
    public $description;
    public $salary;
    public $closingDate;
    public $location;
    public $authorId;

    public function __construct(\CSY2028\DatabaseTable $applicantTable, \CSY2028\DatabaseTable $categoryTable) {
        $this->applicantTable = $applicantTable;
        $this->categoryTable = $categoryTable;
    }
    //Get the applicant count of each job
    public function getApplicantCount() {
        return $this->applicantTable->count($this->id, 'jobId');
    }
    //Gets applicants of each job
    public function getApplicants() {
        return $this->applicantTable->find('jobId', $this->id);
    }
    //Formats the closing date
    public function formatDate() {
        $date = new DateTime($this->closingDate);
        return $closingDate = $date->format('Y-m-d');
    }
    //Gets the category for each job
    public function getCategory() {
        return $this->categoryTable->find('id', $this->categoryId)[0];
    }
}