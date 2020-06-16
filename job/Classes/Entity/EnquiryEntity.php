<?php
//Entity class for enquiries
namespace Classes\Entity;

class EnquiryEntity {
    public $enquiryTable;
    public $usersTable;
    public $id;
    public $name;
    public $telephone;
    public $enquiry;
    public $responseId;

    public function __construct(\CSY2028\DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }
    //Gets the user who marked asc complete
    public function getResponder() {
        return $this->usersTable->find('id', $this->responseId)[0];
    }
}