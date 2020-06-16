<?php
require 'Classes/Controllers/AdminJobs.php';

class AddJobTest extends \PHPUnit\Framework\TestCase {

    private $controller;
    private $jobTable;
    private $pdo;

    public function setUp() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=job;charset=utf8', 'student', 'student',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->jobTable = new \CSY2028\DatabaseTable($this->pdo, 'job', 'id');
    }
    public function testInvalidTitle() {
        $job = [
            'job' => [
                'title' => '',
                'description' => 'test@test.com',
                'salary' => '1234',
                'closingDate' => '2020-03-31',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1'
            ]
        ];
        $this->controller = new \Classes\Controllers\AdminJobs($this->jobTable, null,null,null,null,[], $job);
        $errors = $this->controller->validateJob();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidEmail() {
        $job = [
            'job' => [
                'title' => 'test',
                'description' => '',
                'salary' => '1234',
                'closingDate' => 'enquiry',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1'
            ]
        ];
        $this->controller = new \Classes\Controllers\AdminJobs($this->jobTable, null,null,null,null,[], $job);
        $errors = $this->controller->validateJob();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidSalary() {
        $job = [
            'job' => [
                'title' => 'test',
                'description' => 'test@test.com',
                'salary' => '',
                'closingDate' => 'enquiry',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1'
            ]
        ];
        $this->controller = new \Classes\Controllers\AdminJobs($this->jobTable, null,null,null,null,[], $job);
        $errors = $this->controller->validateJob();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidDate() {
        $job = [
            'job' => [
                'title' => 'test',
                'description' => 'test@test.com',
                'salary' => '1234',
                'closingDate' => '',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1'
            ]
        ];
        $this->controller = new \Classes\Controllers\AdminJobs($this->jobTable, null,null,null,null,[], $job);
        $errors = $this->controller->validateJob();
        $this->assertEquals(count($errors), 1);
    }

    public function testValidSubmit() {
        $job = [
            'job' => [
                'title' => 'test',
                'description' => 'test@test.com',
                'salary' => '1234',
                'closingDate' => '2020-03-31',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1'
            ]
        ];
        $testTable = $this->getMockBuilder('\CSY2028\DatabaseTable')->disableOriginalConstructor()->getMock();
        $testTable->expects($this->once())
            ->method('save')
            ->with($this->equalTo($job['job']));
        $this->controller = new \Classes\Controllers\AdminJobs($testTable, null,null,null,null,[], $job);
        $result = $this->controller->validateSubmit();
        $this->assertEquals($result['template'], 'adminjobs.html.php');
    }

    public function testDatabaseTableSave() {
        $this->pdo->query('DELETE FROM job WHERE title = "test"');
        $stmt = $this->pdo->query('SELECT * FROM job WHERE title = "test"');
        $record = $stmt->fetch();
        $this->assertFalse($record);
        $job = [
                'title' => 'test',
                'description' => 'test@test.com',
                'salary' => '1234',
                'closingDate' => '2020-03-31',
                'categoryId' => '1',
                'location' => 'test',
                'authorId' => '1',
        ];
        $this->jobTable->save($job);
        $stmt = $this->pdo->query('SELECT * FROM job WHERE title = "test"');
        $record = $stmt->fetch();
        $this->assertEquals($record['title'], $job['title']);
        $this->assertEquals($record['description'], $job['description']);
        $this->assertEquals($record['salary'], $job['salary']);
        $this->assertEquals($record['closingDate'], $job['closingDate']);
        $this->assertEquals($record['categoryId'], $job['categoryId']);
        $this->assertEquals($record['location'], $job['location']);
        $this->assertEquals($record['authorId'], $job['authorId']);
    }
}