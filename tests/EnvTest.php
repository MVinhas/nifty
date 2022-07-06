<?php
use Nifty\Env;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    public function testFileEnvIsReadable()
    {
        $filePath = __DIR__ . '/../config/.env';
        $this->assertNull((new Env($filePath))->load());
    }
}
