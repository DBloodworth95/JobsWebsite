<?php
//Handles job pages
namespace Classes\Controllers;
class Job {
    private $jobsTable;
    private $categoryTable;
    private $get;
    private $post;


    public function __construct($jobsTable, $categoryTable, array $get, array $post) {
        $this->jobsTable = $jobsTable;
        $this->categoryTable = $categoryTable;
        $this->get = $get;
        $this->post = $post;
    }
    //Lists jobs based on the category selected
    public function listIt() {
        $chosenCategory = $this->categoryTable->find('id', $_GET['id'])[0];
        $categories = $this->categoryTable->findAll();
        $locations = $this->jobsTable->fetchColumn('location');
        return ['template' => 'jobs.html.php',
            'title' => 'Job List',
            'variables' => [
                'categories' => $categories, 'chosenCategory' => $chosenCategory, 'locations' => $locations
            ]
        ];
    }
    //Handles location sorting
    public function sortLocation() {
        $chosenCategory = $this->categoryTable->find('id', $_GET['id'])[0];
        $categories = $this->categoryTable->findAll();
        $locations = $this->jobsTable->fetchColumn('location');
        return ['template' => 'jobs.html.php',
            'title' => 'Jo\'s Jobs - Job Listing',
            'variables' => [
                'categories' => $categories, 'chosenCategory' => $chosenCategory, 'locations' => $locations
            ]
        ];
    }
}