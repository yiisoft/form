<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Form\ThemeContainer;

final class ThemeContainerTest extends TestCase
{
    public function testGetThemeWithNonExistConfiguration(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Theme with name "non-exist" not found.');
        ThemeContainer::getTheme('non-exist');
    }
}
