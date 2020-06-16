<?php
//Entity class for applicants
namespace Classes\Entity;

class ApplicationEntity {
    public $applicantTable;
    public $jobsTable;
    public $id;
    public $name;
    public $email;
    public $details;
    public $jobId;
    public $cv;

    public function __construct(\CSY2028\DatabaseTable $applicantTable) {
        $this->applicantTable = $applicantTable;
    }
}