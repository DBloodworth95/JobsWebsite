<?php
//Entity class for categories
namespace Classes\Entity;

class CategoryEntity {

    public $jobsTable;
    public $id;
    public $name;

    public function __construct(\CSY2028\DatabaseTable $jobsTable) {
        $this->jobsTable = $jobsTable;
    }
    //Get jobs by category
    public function getJobs() {
        return $this->jobsTable->lessThanFind('categoryId', $this->id, 'closingDate', (new \DateTime())->format('Y-m-d'));
    }
    //Get All locations
    public function getLocations() {
        return $this->jobsTable->fetchColumn('location');
    }
    //Sort jobs from the category by location
    public function sortLocation() {
        return $this->jobsTable->lessThanAndFind('location', $_POST['locationType'], 'categoryId', $this->id, 'closingDate', (new \DateTime())->format('Y-m-d'));
    }
}


