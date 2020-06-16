<?php
require 'Classes/Controllers/Apply.php';

class ApplicationTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $applicationTable;
    private $pdo;

    public function setUp() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=job;charset=utf8', 'student', 'student',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->applicationTable = new \CSY2028\DatabaseTable($this->pdo, 'applicants', 'id');
    }
    public function testInvalidName() {
        $_FILES = [
            'cv' => [
                'error'    => UPLOAD_ERR_OK,
                'name'     => 'test.csv',
                'size'     => 123,
                'tmp_name' => __FILE__,
                'type'     => 'text/csv'
            ]
        ];
            $application = [
                'name' => '',
                'email' => 'test@test.com',
                'details' => '1234',
                'cv' => $_FILES['cv']
            ];
            $this->controller = new \Classes\Controllers\Apply($this->applicationTable, null, null, null, [], $application, null);
            $errors = $this->controller->validateApplication();
            $this->assertEquals(count($errors), 1);
            $_FILES = [];
    }
    public function testInvalidEmail() {
        $_FILES = [
            'cv' => [
                'error'    => UPLOAD_ERR_OK,
                'name'     => 'test.csv',
                'size'     => 123,
                'tmp_name' => __FILE__,
                'type'     => 'text/csv'
            ]
        ];
        $application = [
            'name' => 'test',
            'email' => '',
            'details' => '1234',
            'cv' => $_FILES['cv']
        ];
        $this->controller = new \Classes\Controllers\Apply($this->applicationTable, null, null,null,[], $application, null);
        $errors = $this->controller->validateApplication();
        $this->assertEquals(count($errors), 1);
        $_FILES = [];
    }
    public function testInvalidDetails() {
        $_FILES = [
            'cv' => [
                'error'    => UPLOAD_ERR_OK,
                'name'     => 'test.csv',
                'size'     => 123,
                'tmp_name' => __FILE__,
                'type'     => 'text/csv'
            ]
        ];
        $application = [
            'name' => 'test',
            'email' => 'test@test.com',
            'details' => '',
            'cv' => $_FILES['cv']
        ];
        $this->controller = new \Classes\Controllers\Apply($this->applicationTable, null, null,null,[], $application, null);
        $errors = $this->controller->validateApplication();
        $this->assertEquals(count($errors), 1);
        $_FILES = [];
    }
    public function testInvalidCV() {
        $_FILES = [
            'cv' => [
                'error'    => UPLOAD_ERR_OK,
                'name'     => 'test.csv',
                'size'     => 0,
                'tmp_name' => __FILE__,
                'type'     => 'text/csv'
            ]
        ];
        $application = [
            'name' => 'test',
            'email' => 'test@test.com',
            'details' => '1234',
            'cv' => $_FILES['cv']
        ];
        $this->controller = new \Classes\Controllers\Apply($this->applicationTable, null, null,null,[], $application, null);
        $errors = $this->controller->validateApplication();
        $this->assertEquals(count($errors), 1);
        $_FILES = [];
    }
//    public function testValidSubmit() {
//        $_FILES = [
//            'cv' => [
//                'error'    => UPLOAD_ERR_OK,
//                'name'     => 'test.csv',
//                'size'     => 123,
//                'tmp_name' => __FILE__,
//                'type'     => 'text/csv'
//            ]
//        ];
//        $application = [
//                'name' => 'test',
//                'email' => 'test@test.com',
//                'telephone' => '1234',
//                'cv' => $_FILES['cv']
//        ];
//        $testTable = $this->getMockBuilder('\CSY2028\DatabaseTable')->disableOriginalConstructor()->getMock();
//        $testTable->expects($this->once())
//            ->method('save')
//            ->with($this->equalTo($application));
//        $this->controller = new \Classes\Controllers\Apply($testTable, null, null,null,[], $application, null);
//        $result = $this->controller->validateSubmit();
//        $this->assertEquals($result['template'], 'apply.html.php');
//        $_FILES = [];
//    }
}