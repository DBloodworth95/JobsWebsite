<?php
//Handles any deleting requests.
namespace Classes\Controllers;

class Delete {
    private $jobsTable;
    private $categoryTable;
    private $archiveTable;
    private $userTable;
    private $authentication;
    private $post;

    public function __construct($jobsTable, $categoryTable, $archiveTable, $authentication, $userTable, $post) {
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->archiveTable = $archiveTable;
        $this->authentication = $authentication;
        $this->userTable = $userTable;
        $this->post = $post;
    }

    public function delete() {
        $authorId = $this->authentication->getUser();
        $result = $this->jobsTable->find('id', $this->post['job']['id']);
        $job = $result[0];
        if ($job->authorId != $authorId->id && $authorId->accessLevel != 1 && $authorId->accessLevel != 2) {
            return;
        }
        $deleteJob = $this->post['job'];
        $authorId->deleteJob($deleteJob);
        header('location: /adminjobs');
    }

    public function deleteCat() {
        $authorId = $this->authentication->getUser();
        if ($authorId->accessLevel != 1 && $authorId->accessLevel != 2) {
            return;
        }
        $deleteCategory = $this->post['category'];
        $authorId->deleteCategory($deleteCategory);
        header('location: /admincategories');
    }

    public function deleteUser() {
        $authorId = $this->authentication->getUser();
        if ($authorId->accessLevel != 1) {
            return;
        }
        $deleteUser = $this->post['user'];
        $authorId->deleteUser($deleteUser);
        header('location: /user/manage');
    }
}