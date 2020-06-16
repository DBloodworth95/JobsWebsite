<?php
//Handles the page to manage jobs.
namespace Classes\Controllers;

use \Authentication\Authentication;

class AdminJobs {
    private $jobsTable;
    private $categoryTable;
    private $applicantTable;
    private $archiveTable;
    private $authentication;
    private $get;
    private $post;

    public function __construct($jobsTable, $categoryTable, $applicantTable, $archiveTable, $authentication, array $get, array $post) {
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->applicantTable = $applicantTable;
        $this->archiveTable = $archiveTable;
        $this->authentication = $authentication;
        $this->get = $get;
        $this->post = $post;
    }
    //Displays all jobs for the main manage jobs page
    public function jobs() {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        if ($authorId->accessLevel == 1 || $authorId->accessLevel == 2) {
            $jobs = $this->jobsTable->findAll();
            $archive = $this->archiveTable->findAll();
        } else {
            $jobs = $this->jobsTable->find('authorId', $authorId->id);
            $archive = $this->archiveTable->find('authorId', $authorId->id);
        }
        return ['template' => 'adminjobs.html.php',
            'title' => 'Jo\'s Jobs - Admin Jobs',
            'variables' => [
                'jobs' => $jobs,'categories' => $categories, 'archive' => $archive, 'authorId' => $authorId
            ]
        ];
    }
    //Handles job sorting
    public function sortJobs() {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        if ($authorId->accessLevel == 1 || $authorId->accessLevel == 2) {
            $jobs = $this->jobsTable->find('categoryId', $_POST['categoryType']);
            $archive = $this->archiveTable->find('categoryId', $_POST['categoryType']);
        } else {
            $jobs = $this->jobsTable->andFind('categoryId', $_POST['categoryType'], 'authorId', $authorId->id);
            $archive = $this->archiveTable->andFind('categoryId', $_POST['categoryType'], 'authorId', $authorId->id);
        }
        return ['template' => 'adminjobs.html.php',
            'title' => 'Jo\'s Jobs - Admin Jobs',
            'variables' => [
                'jobs' => $jobs,'categories' => $categories, 'archive' => $archive, 'authorId' => $authorId
            ]
        ];
    }
    //Handles job archiving
    public function archiveJob() {
        $authorId = $this->authentication->getUser();
        $result = $this->jobsTable->find('id', $_POST['job']['id']);
        $job = $result[0];
        if ($job->authorId != $authorId->id && $authorId->accessLevel != 1 && $authorId->accessLevel != 2) {
            return;
        }
        $archiveJob = $_POST['job'];
        $authorId->archiveJob($archiveJob);
        header('location: /adminjobs');
    }
    //Handles job reposting
    public function repostJob() {
        $authorId = $this->authentication->getUser();
        $result = $this->archiveTable->find('id', $_POST['archivejob']['id']);
        $job = $result[0];
        if ($job->authorId != $authorId->id && $authorId->accessLevel != 1 && $authorId->accessLevel != 2) {
            return;
        }
        $repostJob = $_POST['archivejob'];
        $authorId->repostJob($repostJob);
        header('location: /adminjobs');
    }
    //Handles post request for editing a job
    public function editJobSubmit() {
        $errors = $this->validateJob();
        if(count($errors) == 0) {
            $authorId = $this->authentication->getUser();
            $result = $this->jobsTable->find('id', $_POST['job']['id']);
            $job = $result[0];
            if ($job->authorId != $authorId->id && $authorId->accessLevel != 1 && $authorId->accessLevel != 2 && isset($_GET['action']) && ($_GET['action'] == 'update')) {
                return;
            }
            $newJob = $_POST['job'];
            $authorId->addJob($newJob);
            header('location: /adminjobs');
        } else {
            return $this->editJobForm($errors);
        }
    }
    //Displays form to add/edit a job
    public function editJobForm($errors = []) {
        $jobs = $_POST['job'] ?? [];
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        if (isset($_GET['id'])) {
            $result = $this->jobsTable->find('id', $_GET['id']);
            $job = $result[0];
        } else {
            $job = false;
        }
        return ['template' => 'editjob.html.php',
            'variables' => ['job' => $job, 'categories' => $categories, 'userId' => $authorId->id ?? null, 'authorId' => $authorId, 'jobs' => $jobs, 'errors' => $errors],
            'title' => 'Jobs List'
        ];
    }
    //Form validation
    public function validateJob() {
        $errors = [];
        if(empty($this->post['job']['title'])) {
            $errors[] = "You must enter a title!";
        }
        if(empty($this->post['job']['description'])) {
            $errors[] = "You must enter a description!";
        }
        if(empty($this->post['job']['salary'])) {
            $errors[] = "You must enter a salary!";
        }
        if(empty($this->post['job']['location'])) {
            $errors[] = "You must enter a location!";
        }
        if(empty($this->post['job']['closingDate'])) {
            $errors[] = "You must enter a closing date!";
        }
        return $errors;
    }
    //Tests post request.
    public function validateSubmit() {
        $errors = $this->validateJob($this->post['job']);
        if(count($errors) == 0) {
            $this->jobsTable->save($this->post['job']);
            return ['template' => 'adminjobs.html.php',
                'title' => 'Jo\'s Jobs - Manage Jobs',
                'variables' => [
                ]
            ];
        } else {
            return $this->editJobForm($errors);
        }
    }
}
