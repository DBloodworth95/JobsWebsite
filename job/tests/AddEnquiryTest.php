<?php
require 'CSY2028/DatabaseTable.php';
require 'Classes/Controllers/Enquiry.php';

class AddEnquiryTest extends \PHPUnit\Framework\TestCase {

    private $controller;
    private $enquiryTable;
    private $pdo;

    public function setUp() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=job;charset=utf8', 'student', 'student',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->enquiryTable = new \CSY2028\DatabaseTable($this->pdo, 'enquiry', 'id');
    }
    public function testInvalidName() {
        $enquiry = [
            'enquiry' => [
            'name' => '',
            'email' => 'test@test.com',
            'telephone' => '1234',
            'enquiry' => 'enquiry'
                ]
        ];
        $this->controller = new \Classes\Controllers\Enquiry(null, $this->enquiryTable, null, [], $enquiry);
        $errors = $this->controller->validateEnquiry();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidEmail() {
        $enquiry = [
            'enquiry' => [
                'name' => 'test',
                'email' => '',
                'telephone' => '1234',
                'enquiry' => 'enquiry'
            ]
        ];
        $this->controller = new \Classes\Controllers\Enquiry(null, $this->enquiryTable, null, [], $enquiry);
        $errors = $this->controller->validateEnquiry();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidPhone() {
        $enquiry = [
            'enquiry' => [
                'name' => 'test',
                'email' => 'test@test.com',
                'telephone' => '',
                'enquiry' => 'enquiry'
            ]
        ];
        $this->controller = new \Classes\Controllers\Enquiry(null, $this->enquiryTable, null, [], $enquiry);
        $errors = $this->controller->validateEnquiry();
        $this->assertEquals(count($errors), 1);
    }
    public function testInvalidEnquiry() {
        $enquiry = [
            'enquiry' => [
                'name' => 'test',
                'email' => 'test@test.com',
                'telephone' => '1234',
                'enquiry' => ''
            ]
        ];
        $this->controller = new \Classes\Controllers\Enquiry(null, $this->enquiryTable, null, [], $enquiry);
        $errors = $this->controller->validateEnquiry();
        $this->assertEquals(count($errors), 1);
    }
    public function testValidSubmit() {
        $enquiry = [
            'enquiry' => [
                'name' => 'test',
                'email' => 'test@test.com',
                'telephone' => '1234',
                'enquiry' => 'test'
            ]
        ];
        $testTable = $this->getMockBuilder('\CSY2028\DatabaseTable')->disableOriginalConstructor()->getMock();
        $testTable->expects($this->once())
            ->method('save')
            ->with($this->equalTo($enquiry['enquiry']));
        $this->controller = new \Classes\Controllers\Enquiry(null, $testTable, null, [], $enquiry);
        $result = $this->controller->validateSubmit();
        $this->assertEquals($result['template'], 'enquirysuccess.html.php');
    }

    public function testDatabaseTableSave() {
        $this->pdo->query('DELETE FROM enquiry WHERE email = "test@test.com"');
        $stmt = $this->pdo->query('SELECT * FROM enquiry WHERE email = "test@test.com"');
        $record = $stmt->fetch();
        $this->assertFalse($record);
        $enquiry = [
                'name' => 'test',
                'email' => 'test@test.com',
                'telephone' => '1234',
                'enquiry' => 'test'
        ];

        $this->enquiryTable->save($enquiry);
        $stmt = $this->pdo->query('SELECT * FROM enquiry WHERE email = "test@test.com"');
        $record = $stmt->fetch();
        $this->assertEquals($record['name'], $enquiry['name']);
        $this->assertEquals($record['email'], $enquiry['email']);
        $this->assertEquals($record['telephone'], $enquiry['telephone']);
        $this->assertEquals($record['enquiry'], $enquiry['enquiry']);
    }
}