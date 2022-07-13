<?php

namespace Nifty\Tests;

use PDOException;
use PHPUnit\Framework\TestCase;

require_once 'config/env_loader.php';

class DbTest extends TestCase
{
    private $connection;
    public function setUp(): void
    {
        $this->connection = (new \Nifty\Tests\Utility())->mockConnection();
    }
    public function testCreate(): void
    {
        $this->assertNull($this->connection->create('table', ['field1 INT NOT NULL', 'field2 VARCHAR(60)']));
    }

    public function testUpsert(): void
    {
        $this->assertNull($this->connection->upsert('table', ['field1', 'field2'], [1, "2"]));
    }

    public function testClean(): void
    {
        $this->assertNull($this->connection->clean('table'));
    }

    public function testDrop(): void
    {
        $this->assertNull($this->connection->drop('table'));
    }

    public function tearDown(): void
    {
        $pdo = null;
        $mock = null;
    }
}
