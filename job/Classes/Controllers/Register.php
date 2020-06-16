<?php
//Handless Register page for account creation
namespace Classes\Controllers;

use CSY2028\DatabaseTable;

class Register {
    private $jobsTable;
    private $categoryTable;
    private $usersTable;
    private $authentication;
    private $get;
    private $post;

    public function __construct($jobsTable, $categoryTable, $usersTable, $authentication, $get, $post) {
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->usersTable = $usersTable;
        $this->authentication = $authentication;
        $this->get = $get;
        $this->post = $post;
    }
    //Displays form to create account
    public function regForm($errors = []) {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        if (isset($_GET['id'])) {
            $result = $this->usersTable->find('id', $_GET['id']);
            $user = $result[0];
        } else {
            $user = false;
        }
        return ['template' => 'adduser.html.php',
            'title' => 'Jo\'s Jobs - Add a User',
            'variables' => [
                'categories' => $categories, 'authorId' => $authorId, 'user' => $user, 'errors' => $errors
            ]
        ];
    }
    //Handles post request for new user
    public function regFormSubmit() {
        $authorId = $this->authentication->getUser();
        $_POST['user']['username'] = strtolower($_POST['user']['username'] ?? []);
        $errors = $this->validateUser();
        if(count($errors) == 0) {
            $_POST['user']['password'] = password_hash($_POST['user']['password'], PASSWORD_DEFAULT);
            if ($authorId->accessLevel != 1) {
                return;
            }
            $newUser = $_POST['user'];
            $authorId->addUser($newUser);
            $categories = $this->categoryTable->findAll();
            return ['template' => 'addusersuccess.html.php',
                'title' => 'Jo\'s Jobs - Registration Complete!',
                'variables' => [
                    'categories' => $categories, 'authorId' => $authorId
                ]
            ];
        } else {
            return $this->regForm($errors);
        }
    }
    //Form validation
    public function validateUser() {
        $errors = [];
        if(empty($this->post['user']['username'])) {
            $errors[] = "You must enter a username!";
        }
        if(empty($this->post['user']['password'])) {
            $errors[] = "You must enter a password!";
        }
        if ($this->usersTable->find('username', $this->post['user']['username']) != null && isset($this->get['action']) && ($this->get['action'] == 'add'))  {
            $errors[] = "This username has already been taken!";
        }
        return $errors;
    }
    //Validates post request for testing.
    public function validateSubmit() {
       $errors = $this->validateUser();
        if(count($errors) == 0) {
            $this->usersTable->save($this->post['user']);
            return ['template' => 'adminjobs.html.php',
                'title' => 'Jo\'s Jobs - Manage Jobs',
                'variables' => [
                ]
            ];
        } else {
            return $this->regForm($errors);
        }
    }
}