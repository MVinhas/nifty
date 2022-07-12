<?php

namespace Nifty\Tests;

use Nifty\Env;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    public function testFileEnvIsReadable(): void
    {
        $filePath = __DIR__ . '/../config/.env';
        $this->assertNull((new Env($filePath))->load());
    }
}
