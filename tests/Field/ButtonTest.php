<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Button;
use Yiisoft\Form\Theme\ThemeContainer;

final class ButtonTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Button::widget()
            ->content('Click Me')
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <button type="button">Click Me</button>
            </div>
            HTML,
            $result
        );
    }
}
