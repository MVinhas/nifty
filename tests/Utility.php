<?php
namespace Nifty\Tests;

use Nifty\Db;
use PDO;
use PHPUnit\Framework\TestCase;


class Utility extends TestCase
{
    public function mockConnection(): object
    {
        $pdo = $this->createMock(PDO::class);
        $mock = $this->createMock(Db::class);
        $mock->method('initialize')->willReturn($pdo);
        return $mock;
    }
}