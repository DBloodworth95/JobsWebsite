<?php
//Handles application pages
namespace Classes\Controllers;

class Apply {
    public $applicantTable;
    public $jobsTable;
    public $categoryTable;
    public $authentication;
    private $get;
    private $post;
    private $uploader;

    public function __construct($applicantTable, $jobsTable, $categoryTable, $authentication, array $get, array $post, $uploader) {
        $this->applicantTable = $applicantTable;
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->authentication = $authentication;
        $this->get = $get;
        $this->post = $post;
        $this->uploader = $uploader;
    }
    //Handles an application post
    public function submitApp() {
        $errors = $this->validateApplication();
        if(count($errors) == 0) {
        if ($_FILES['cv']['error'] == 0) {
            $parts = explode('.', $_FILES['cv']['name']);
            $extension = end($parts);
            $fileName = uniqid() . '.' . $extension;
            $this->uploader->handleUpload('cv', 'cvs/' . $fileName);
            $values = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'details' => $_POST['details'],
                'jobId' => $_POST['jobId'],
                'cv' => $fileName
            ];
            $this->applicantTable->insert($values);
            header('location: /');
        }  } else {
            return $this->submitAppForm($errors);
        }
    }
    //Form validation
    public function validateApplication() {
        $errors = [];
        if(empty($this->post['name'])) {
            $errors[] = "You must enter your name!";
        }
        if(empty($this->post['email'])) {
            $errors[] = "You must enter your email!";
        }
        if(empty($this->post['details'])) {
            $errors[] = "You must enter your details!";
        }
        if($_FILES['cv']['size'] == 0) {
            $errors[] = "You must upload a cv!";
        }
        return $errors;
    }

//    public function validateSubmit() {
//        $errors = $this->validateApplication($this->post['application']);
//        if(count($errors) == 1) {
//            $this->applicantTable->save($this->post['application']);
//            return ['template' => 'apply.html.php',
//                'title' => 'Jo\'s Jobs - Job List',
//                'variables' => [
//                ]
//            ];
//        } else {
//            return $this->submitAppForm($errors);
//        }
//    }
    //Handles post request for testing
    public function submitAppForm($errors = []) {
        $application = $_POST['application'] ?? [];
        $categories = $this->categoryTable->findAll();
        if (isset($_GET['id'])) {
            $result = $this->jobsTable->find('id', $_GET['id']);
            $job = $result[0];
        } else {
            $job = false;
        }
        return ['template' => 'apply.html.php',
                'title' => 'Job List',
                'variables' => [
                    'job' => $job, 'categories' => $categories, 'application' => $application, 'errors' => $errors
                ]
            ];
    }
    //Handles page to list applicants for each job
    public function listApplicants() {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        if (isset($_GET['id'])) {
            $result = $this->jobsTable->find('id', $_GET['id']);
            $job = $result[0];
        } else {
            $job = false;
        }
        return ['template' => 'applicants.html.php',
            'title' => 'Applicants',
            'variables' => [
                'job' => $job, 'categories' => $categories, 'authorId' => $authorId
            ]
        ];
    }
}