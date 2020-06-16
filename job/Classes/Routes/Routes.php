<?php
//Handles each page URL. Instances of each table are initialized followed by an instance of each controller.
//Stores an array of routes (pages) which are assigned a controller and a function which is called upon a certain URL being requested.
namespace Classes\Routes;

use Authentication\Authentication;

class Routes implements \CSY2028\Routes {
    private $categoryTable;
    private $applicantTable;
    private $archiveTable;
    private $jobsTable;
    private $usersTable;
    private $enquiryTable;
    private $fileUploader;
    public $authentication;

    public function __construct() {
        include __DIR__ . '/../../Connection/pdo.php';
        $this->categoryTable = new \CSY2028\DatabaseTable($pdo, 'category', 'id', '\Classes\Entity\CategoryEntity', [&$this->jobsTable, &$this->categoryTable]);
        $this->applicantTable = new \CSY2028\DatabaseTable($pdo, 'applicants', 'id', '\Classes\Entity\ApplicationEntity', [&$this->applicantTable]);
        $this->archiveTable = new \CSY2028\DatabaseTable($pdo, 'archive', 'id', '\Classes\Entity\ArchiveJobEntity', [&$this->categoryTable]);
        $this->jobsTable = new \CSY2028\DatabaseTable($pdo, 'job', 'id', '\Classes\Entity\JobEntity', [&$this->applicantTable, &$this->categoryTable]);
        $this->usersTable = new \CSY2028\DatabaseTable($pdo, 'users', 'id', '\Classes\Entity\UserEntity', [&$this->usersTable, &$this->jobsTable, &$this->categoryTable, &$this->archiveTable]);
        $this->enquiryTable = new \CSY2028\DatabaseTable($pdo, 'enquiry', 'id', '\Classes\Entity\EnquiryEntity', [&$this->usersTable]);
        $this->authentication = new \Authentication\Authentication($this->usersTable, 'username', 'password');
        $this->fileUploader = new \CSY2028\FileUploader($_FILES);
    }

    public function getRoutes(): array {
        $homeController = new \Classes\Controllers\Home($this->categoryTable, $this->jobsTable);
        $jobController = new \Classes\Controllers\Job($this->jobsTable, $this->categoryTable, $_GET, $_POST);
        $loginController = new \Classes\Controllers\Login($this->categoryTable, $this->authentication);
        $adminJobController = new \Classes\Controllers\AdminJobs($this->jobsTable, $this->categoryTable, $this->applicantTable, $this->archiveTable, $this->authentication, $_GET, $_POST);
        $adminCategoryController = new \Classes\Controllers\AdminCategory($this->categoryTable, $this->authentication, $_GET, $_POST);
        $deleteController = new \Classes\Controllers\Delete($this->jobsTable, $this->categoryTable, $this->archiveTable, $this->authentication, $this->usersTable, $_POST);
        $applyController = new \Classes\Controllers\Apply($this->applicantTable, $this->jobsTable, $this->categoryTable, $this->authentication, $_GET, $_POST, $this->fileUploader);
        $registerController = new \Classes\Controllers\Register($this->jobsTable, $this->categoryTable, $this->usersTable, $this->authentication, $_GET, $_POST);
        $userController = new \Classes\Controllers\User($this->categoryTable, $this->usersTable, $this->authentication);
        $enquiryController = new \Classes\Controllers\Enquiry($this->categoryTable, $this->enquiryTable, $this->authentication, $_GET, $_POST);
        $routes = [
            'jobedit' => [
                'GET' => [
                    'controller' => $adminJobController,
                    'function' => 'editJobForm'
                ],
                'loggedin' => true,
                'POST' => [
                    'controller' => $adminJobController,
                    'function' => 'editJobSubmit'
                ],
                'loggedin' => true
            ],
            '' => [
                'GET' => [
                    'controller' => $homeController,
                    'function' => 'home'
                ],
            ],
            'enquiry' => [
                'GET' => [
                    'controller' => $enquiryController,
                    'function' => 'enquiryForm'
                ],
                'POST' => [
                    'controller' => $enquiryController,
                    'function' => 'enquirySubmit'
                ]
            ],
            'about' => [
                'GET' => [
                    'controller' => $homeController,
                    'function' => 'about'
                ]
            ],
            'jobs/' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'listIt'
                ],
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'sortLocation'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'login'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'function' => 'loginSubmit'
                ]
            ],
            'adminjobs' => [
                'GET' => [
                    'controller' => $adminJobController,
                    'function' => 'jobs'
                ],
                'POST' => [
                    'controller' => $adminJobController,
                    'function' => 'sortJobs'
                ],
                'loggedin' => true
            ],
            'adminjobs/delete' => [
                'POST' => [
                    'controller' => $deleteController,
                    'function' => 'delete'
                ],
                'loggedin' => true
            ],
            'adminjobs/archive' => [
                'POST' => [
                    'controller' => $adminJobController,
                    'function' => 'archiveJob'
                ],
                'loggedin' => true
            ],
            'adminjobs/repost' => [
                'POST' => [
                    'controller' => $adminJobController,
                    'function' => 'repostJob'
                ],
                'loggedin' => true
            ],
            'admincategories' => [
                'GET' => [
                    'controller' => $adminCategoryController,
                    'function' => 'populatePage'
                ],
                'POST' => [
                    'controller' => $adminCategoryController,
                    'function' => 'populatePage'
                ],
                'loggedin' => true
            ],
            'catedit' => [
                'GET' => [
                    'controller' => $adminCategoryController,
                    'function' => 'editCatForm'
                ],
                'loggedin' => true,
                'POST' => [
                    'controller' => $adminCategoryController,
                    'function' => 'editCatSubmit'
                ],
                'loggedin' => true
            ],
            'admincategories/delete' => [
                'POST' => [
                    'controller' => $deleteController,
                    'function' => 'deleteCat'
                ]
            ],
            'jobs/apply' => [
                'GET' => [
                    'controller' => $applyController,
                    'function' => 'submitAppForm'
                ],
                'POST' => [
                    'controller' => $applyController,
                    'function' => 'submitApp'
                ]
            ],
            'applicants' => [
                'GET' => [
                    'controller' => $applyController,
                    'function' => 'listApplicants'
                ],
                'loggedin' => true
            ],
            'faq' => [
                'GET' => [
                    'controller' => $homeController,
                    'function' => 'faq'
                ]
            ],
            'user/add' => [
                'GET' => [
                    'controller' => $registerController,
                    'function' => 'regForm'
                ],
                'POST' => [
                    'controller' => $registerController,
                    'function' => 'regFormSubmit'
                ],
                'loggedin' => true
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'logout'
                ]
            ],
            'user/manage' => [
                'GET' => [
                    'controller' => $userController,
                    'function' => 'list'
                ],
                'POST' => [
                    'controller' => $deleteController,
                    'function' => 'deleteUser'
                ],
                'loggedin' => true
            ],
            'enquirymanage' => [
                'GET' => [
                    'controller' => $enquiryController,
                    'function' => 'list'
                ],
                'POST' => [
                    'controller' => $enquiryController,
                    'function' => 'completeEnquiry'
                ],
                'loggedin' => true
            ],
        ];
        return $routes;
    }

    public function getAuth(): Authentication {
        return $this->authentication;
    }
    //Gets variables for layout page.
    public function getVarsForLayout($title, $output): array {
        $categories = $this->categoryTable->findAll();
        $loggedIn = $this->getAuth()->isLoggedIn();
        return [
            'title' => $title,
            'output' => $output,
            'loggedIn' => $loggedIn,
            'categories' => $categories
        ];
    }
}
