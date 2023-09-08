<?php

declare(strict_types=1);

namespace PhpOdt\Tests\TestCase;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected string $path;

    public function getFixture(string $relative): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . $relative;
    }

    public function getTempnam(): string
    {
        return tempnam('/tmp', 'phpodt');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        if ($this->path !== null) {
            unlink($this->path);
        }
    }
}
