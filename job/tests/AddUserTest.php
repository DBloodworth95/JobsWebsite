<?php
require 'Classes/Controllers/Register.php';

class AddUserTestextends extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $userTable;
    private $pdo;

    public function setUp() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=job;charset=utf8', 'student', 'student',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->userTable = new \CSY2028\DatabaseTable($this->pdo, 'users', 'id');
    }

    public function testInvalidUsername() {
        $user = [
            'user' => [
                'username' => '',
                'password' => 'test',
                'accessLevel' => '0'
            ]
        ];
        $this->controller = new \Classes\Controllers\Register(null, null, $this->userTable, null, null, $user);
        $errors = $this->controller->validateUser();
        $this->assertEquals(count($errors), 1);
    }

    public function testInvalidPassword() {
        $user = [
            'user' => [
                'username' => 'test',
                'password' => '',
                'accessLevel' => '0'
            ]
        ];
        $this->controller = new \Classes\Controllers\Register(null, null, $this->userTable, null, null, $user);
        $errors = $this->controller->validateUser();
        $this->assertEquals(count($errors), 1);
    }

    public function testValidSubmit() {
        $user = [
            'user' => [
                'username' => 'test',
                'password' => 'test',
                'accessLevel' => '0'
            ]
        ];
        $testTable = $this->getMockBuilder('\CSY2028\DatabaseTable')->disableOriginalConstructor()->getMock();
        $testTable->expects($this->once())
            ->method('save')
            ->with($this->equalTo($user['user']));
        $this->controller = new \Classes\Controllers\Register(null, null, $testTable, null, null, $user);
        $result = $this->controller->validateSubmit();


        $this->assertEquals($result['template'], 'adminjobs.html.php');
    }

    public function testDatabaseTableSave() {
        $this->pdo->query('DELETE FROM users WHERE username = "test"');
        $stmt = $this->pdo->query('SELECT * FROM users WHERE username = "test"');
        $record = $stmt->fetch();
        $this->assertFalse($record);
        $user = [
            'username' => 'test',
            'password' => 'test',
            'accessLevel' => '0'
        ];
        $this->userTable->save($user);
        $stmt = $this->pdo->query('SELECT * FROM users WHERE username = "test"');
        $record = $stmt->fetch();
        $this->assertEquals($record['username'], $user['username']);
        $this->assertEquals($record['password'], $user['password']);
        $this->assertEquals($record['accessLevel'], $user['accessLevel']);
    }
}