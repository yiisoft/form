<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ResetButton;
use Yiisoft\Form\Theme\ThemeContainer;

final class ResetButtonTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = ResetButton::widget()
            ->content('Reset Form')
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <button type="reset">Reset Form</button>
            </div>
            HTML,
            $result,
        );
    }
}
