<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Theme;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Theme\ThemePath;

final class ThemePathTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertFileExists(ThemePath::BOOTSTRAP5_HORIZONTAL);
        $this->assertFileExists(ThemePath::BOOTSTRAP5_VERTICAL);
    }
}
