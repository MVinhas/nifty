<?php

use Nifty\Models\Home;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    private bool|object $posts;
    public function setUp(): void
    {
        $this->posts = (new Home())->getPosts();
    }
}
