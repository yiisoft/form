<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\ResetButton;
use Yiisoft\Html\Html;

final class ResetButtonTest extends TestCase
{
    use TestTrait;

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="reset" id="w1-reset" name="w1-reset">', ResetButton::widget()->render());
    }
}
