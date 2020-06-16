<?php
//Handles manage user page
namespace Classes\Controllers;

class User {
    private $categoryTable;
    private $usersTable;
    private $authentication;


    public function __construct($categoryTable, $usersTable, $authentication) {
        $this->categoryTable = $categoryTable;
        $this->usersTable = $usersTable;
        $this->authentication = $authentication;
    }
    //Displays page to list all users
    public function list() {
        $authorId = $this->authentication->getUser();
        $users = $this->usersTable->findAll();
        $categories = $this->categoryTable->findAll();
        return ['template' => 'users.html.php',
            'title' => 'Jo\'s Jobs - User Management',
            'variables' => [
                'categories' => $categories, 'authorId' => $authorId, 'users' => $users
            ]
        ];
    }

}