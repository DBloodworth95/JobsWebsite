<?php
//Entity class for archived jobs
namespace Classes\Entity;

class ArchiveJobEntity {

    public $applicantTable;
    public $categoryTable;
    public $id;
    public $title;
    public $categoryId;
    public $description;
    public $salary;
    public $closingDate;
    public $location;

    public function __construct(\CSY2028\DatabaseTable $categoryTable) {
        $this->categoryTable = $categoryTable;
    }

    public function getCategory() {
        return $this->categoryTable->find('id', $this->categoryId)[0];
    }
}