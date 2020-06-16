<?php

require 'Classes/Controllers/AdminCategory.php';
require 'Classes/Controllers/Delete.php';
class AddCategoryTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $categoryTable;
    private $pdo;

    public function setUp() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=job;charset=utf8', 'student', 'student',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->categoryTable = new \CSY2028\DatabaseTable($this->pdo, 'category', 'id');
    }

    public function testInvalidName() {
        $category = [
            'category' => [
                'name' => ''
            ]
        ];
        $this->controller = new \Classes\Controllers\AdminCategory($this->categoryTable, null, null, $category);
        $errors = $this->controller->validateCategory();
        $this->assertEquals(count($errors), 1);
    }

    public function testValidSubmit() {
        $category = [
            'category' => [
                'name' => 'test'
            ]
        ];
        $testTable = $this->getMockBuilder('\CSY2028\DatabaseTable')->disableOriginalConstructor()->getMock();
        $testTable->expects($this->once())
            ->method('save')
            ->with($this->equalTo($category['category']));
        $this->controller = new \Classes\Controllers\AdminCategory($testTable, null, null, $category);
        $result = $this->controller->validateSubmit();
        $this->assertEquals($result['template'], 'adminjobs.html.php');
    }

    public function testDatabaseTableSave() {
        $this->pdo->query('DELETE FROM category WHERE name = "test"');
        $stmt = $this->pdo->query('SELECT * FROM category WHERE name = "test"');
        $record = $stmt->fetch();
        $this->assertFalse($record);
        $category = [
            'name' => 'test'
        ];
        $this->categoryTable->save($category);
        $stmt = $this->pdo->query('SELECT * FROM category WHERE name = "test"');
        $record = $stmt->fetch();
        $this->assertEquals($record['name'], $category['name']);
    }
}