<?php
//Handles all pages related to  category managing.
namespace Classes\Controllers;


class AdminCategory
{
    private $categoryTable;
    private $authentication;
    private $get;
    private $post;

    public function __construct($categoryTable, $authentication, $get, $post) {
        $this->categoryTable = $categoryTable;
        $this->authentication = $authentication;
        $this->get = $get;
        $this->post = $post;
    }
    //Populates categories page.
    public function populatePage()  {
        $authorId = $this->authentication->getUser();
        $categories = $this->categoryTable->findAll();
        return ['template' => 'categories.html.php',
            'title' => 'Jo\'s Jobs - Admin Categories',
            'variables' => [
                'categories' => $categories, 'authorId' => $authorId
            ]
        ];
    }
    //Adds a new category when user clicks submit.
    public function editCatSubmit() {
        $errors = $this->validateCategory();
        if(count($errors) == 0) {
            $authorId = $this->authentication->getUser();
            if ($authorId->accessLevel != 1 && $authorId->accessLevel != 2 && isset($_GET['action']) && ($_GET['action'] == 'update')) {
                return;
            }
            if ($authorId->accessLevel != 1 && $authorId->accessLevel != 2 && isset($_GET['action']) && ($_GET['action'] == 'add')) {
                return;
            }
            $newCategory = $_POST['category'];
            $authorId->addCategory($newCategory);
            header('location: /admincategories');
        } else {
            return $this->editCatForm($errors);
        }
    }
    //Displays the form to edit a category.
    public function editCatForm($errors = []) {
        $category = $_POST['category'] ?? [];
        $authorId = $this->authentication->getUser();
        $this->categoryTable->findAll();
        if (isset($_GET['id'])) {
            $result = $this->categoryTable->find('id', $_GET['id']);
            $categories = $result[0];
        } else {
            $categories = false;
        }
        return ['template' => 'editcategory.html.php',
            'variables' => ['categories' => $categories, 'authorId' => $authorId, 'errors' => $errors, 'category' => $category],
            'title' => 'Edit Home'
        ];
    }
    //Form validation
    public function validateCategory() {
        $errors = [];
        if(empty($this->post['category']['name'])) {
            $errors[] = "You must enter a name!";
        }
        return $errors;
    }
    //Tests submission of new category.
    public function validateSubmit() {
        $errors = $this->validateCategory($this->post['category']);
        if(count($errors) == 0) {
            $this->categoryTable->save($this->post['category']);
            return ['template' => 'adminjobs.html.php',
                'title' => 'Jo\'s Jobs - Manage Jobs',
                'variables' => [
                ]
            ];
        } else {
            return $this->editCatForm($errors);
        }
    }
}