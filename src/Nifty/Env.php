<?php

namespace Nifty;
use Nifty\Exceptions\EnvException;

class Env
{
    protected $path;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            die((new EnvException())->throwEnvNotFound());
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            die((new EnvException())->throwEnvNotReadable());
        }

        $lines = file(
            $this->path,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );
        foreach ($lines ?? array() as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
            }
        }
    }
}
