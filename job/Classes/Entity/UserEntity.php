<?php
//Entity class for user, handles  adding/deleting requests.
namespace Classes\Entity;

class UserEntity {

    public $id;
    public $username;
    public $password;
    public $accessLevel;
    public $usersTable;
    public $jobsTable;
    public $categoryTable;
    public $archiveTable;


    public function __construct(\CSY2028\DatabaseTable $usersTable, \CSY2028\DatabaseTable $jobsTable, \CSY2028\DatabaseTable $categoryTable, \CSY2028\DatabaseTable $archiveTable) {
        $this->usersTable = $usersTable;
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->archiveTable = $archiveTable;
    }

    public function addJob($job) {
        $job['authorId'] = $this->id;
        return $this->jobsTable->save($job);
    }

    public function archiveJob($job) {
        $this->archiveTable->save($job);
        return $this->jobsTable->delete('id', $_POST['job']['id']);
    }

    public function repostJob($job) {
        $this->jobsTable->save($job);
        return $this->archiveTable->delete('id', $_POST['archivejob']['id']);
    }

    public function deleteJob($job) {
       return $this->jobsTable->delete('id', $_POST['job']['id']);
    }

    public function addCategory($category) {
        return $this->categoryTable->save($category);
    }

    public function deleteCategory($category) {
        return $this->categoryTable->delete('id', $_POST['category']['id']);
    }

    public function addUser($user) {
        return $this->usersTable->save($user);
    }

    public function deleteUser($user) {
        return $this->usersTable->delete('id', $_POST['user']['id']);
    }
}
