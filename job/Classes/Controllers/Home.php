<?php
//Handles home page
namespace Classes\Controllers;
class Home {
    private $categoryTable;
    private $jobsTable;

    public function __construct($categoryTable, $jobsTable) {
        $this->categoryTable = $categoryTable;
        $this->jobsTable = $jobsTable;
    }
    //Displays home page
    public function home() {
        $jobs = $this->jobsTable->findLessThanOrdered('closingDate', 'closingDate', (new \DateTime())->format('Y-m-d'));
        $categories = $this->categoryTable->findAll();
        return ['template' => 'home.html.php',
            'title' => 'Jo\'s Jobs - Home',
            'variables' => [
                'categories' => $categories, 'jobs'=> $jobs
            ]
        ];
    }
    //Displays FAQ page
    public function faq() {
        $categories = $this->categoryTable->findAll();
        return ['template' => 'faq.html.php',
            'title' => 'Jo\'s Jobs - FAQ',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }
    //Displays about page
    public function about() {
        $categories = $this->categoryTable->findAll();
        return ['template' => 'about.html.php',
            'title' => 'Jo\'s Jobs - About Us',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }
}