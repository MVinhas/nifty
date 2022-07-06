<?php
use Nifty\Db;
use PHPUnit\Framework\TestCase;

require_once 'config/env_loader.php';

class DbTest extends TestCase
{
    public function getConnection()
    {
        $pdo = $this->createMock(PDO::class);
        $mock = $this->createMock(Db::class);
        $mock->method('initialize')->willReturn($pdo);
        return $mock;
    }

    public function testCreate()
    {
        $this->assertNull($this->getConnection()->create('table', ['field1 INT NOT NULL', 'field2 VARCHAR(60)']));
    }

    public function testSelect()
    {
        $this->assertIsObject($this->getConnection()->select(['1'], "users", ["1=1"]));
    }

    public function testUpsert()
    {
        $this->assertNull($this->getConnection()->upsert('table', ['field1', 'field2'], [1, "2"]));
    }

    public function testClean()
    {
        $this->assertNull($this->getConnection()->clean('table'));
    }

    public function testDrop()
    {
        $this->assertNull($this->getConnection()->drop('table'));
    }
}
