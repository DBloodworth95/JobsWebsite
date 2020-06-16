<?php
//Handles enquiry pages

namespace Classes\Controllers;

class Enquiry {

    private $categoryTable;
    private $enquiryTable;
    private $authentication;
    private $get;
    private $post;

    public function __construct($categoryTable, $enquiryTable, $authentication, array $get, array $post) {
        $this->categoryTable = $categoryTable;
        $this->enquiryTable = $enquiryTable;
        $this->authentication = $authentication;
        $this->get = $get;
        $this->post = $post;
    }
    //Form validation
    public function enquiryForm($errors = []) {
        $categories = $this->categoryTable->findAll();
        $enquiry = $_POST['enquiry'] ?? [];
        return ['template' => 'enquiry.html.php',
            'title' => 'Jo\'s Jobs - Ask a question',
            'variables' => [
                'categories' => $categories, 'errors' => $errors, 'enquiry' => $enquiry
            ]
        ];
    }
    //Handles post request for new enquiry
    public function enquirySubmit() {
        $errors = $this->validateEnquiry($this->post['enquiry']);
        if(count($errors) == 0) {
            $this->enquiryTable->save($this->post['enquiry']);
            $categories = $this->categoryTable->findAll();
            return ['template' => 'enquirysuccess.html.php',
                'title' => 'Jo\'s Jobs - Ask a question',
                'variables' => [
                    'categories' => $categories
                ]
            ];
        } else {
            return $this->enquiryForm($errors);
        }
    }
    //Handles enquiries page.
    public function list() {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        $enquiries = $this->enquiryTable->findAll();
        return ['template' => 'manageenquiries.html.php',
            'title' => 'Jo\'s Jobs - All Enquiries',
            'variables' => [
                'categories' => $categories, 'enquiries' => $enquiries, 'authorId' => $authorId
            ]
        ];
    }

    public function completeEnquiry() {
        $authorId = $this->authentication->getUser();
        $values = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'telephone' => $_POST['telephone'],
            'email' => $_POST['email'],
            'enquiry' => $_POST['enquiry'],
            'responseId' => $authorId->id,
        ];
        if ($authorId->accessLevel != 1 && $authorId->accessLevel != 2) {
            return;
        }
        $this->enquiryTable->save($values);
        header('location: /enquirymanage');
    }

    public function validateEnquiry() {
        $errors = [];

        if(empty($this->post['enquiry']['name'])) {
            $errors[] = "You must enter your name!";
        }
        if(empty($this->post['enquiry']['email'])) {
            $errors[] = "You must enter your email!";
        }
        if(empty($this->post['enquiry']['enquiry'])) {
            $errors[] = "You must enter your enquiry!";
        }
        if(empty($this->post['enquiry']['telephone'])) {
            $errors[] = "You must enter your telephone!";
        }
        return $errors;
    }

    public function validateSubmit() {
        $errors = $this->validateEnquiry($this->post['enquiry']);
        if(count($errors) == 0) {
            $this->enquiryTable->save($this->post['enquiry']);
            return ['template' => 'enquirysuccess.html.php',
                'title' => 'Jo\'s Jobs - Ask a question',
                'variables' => [
                ]
            ];
        } else {
            return $this->enquiryForm($errors);
        }
    }
}