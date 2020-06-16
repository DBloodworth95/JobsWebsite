<?php
//Handles login pages
namespace Classes\Controllers;

class Login {
    private $authentication;

    public function __construct($categoryTable, \Authentication\Authentication $authentication) {
        $this->categoryTable = $categoryTable;
        $this->authentication = $authentication;
    }
    //Displays login page
    public function login() {
        $categories = $this->categoryTable->findAll();
        return ['template' => 'login.html.php',
            'title' => 'Jo\'s Jobs - Login',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }
    //Displays logout page and removes session
    public function logout() {
        $categories = $this->categoryTable->findAll();
        session_destroy();
        return ['template' => 'logout.html.php',
            'title' => 'Jo\'s Jobs - Logged out',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }
    //Handles request to login, authenticates the credentials.
    public function loginSubmit() {
        $categories = $this->categoryTable->findAll();
        if ($this->authentication->login($_POST['username'], $_POST['password'])) {
            header('location: /adminjobs');
        }
        else {
            return ['template' => 'login.html.php',
                'title' => 'Jo\'s Jobs - Login',
                'variables' => [
                    'categories' => $categories, 'error' => 'Invalid username/password.'
                ]
            ];
        }

    }
}