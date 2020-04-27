<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\Hint;

final class HintTest extends TestCase
{
    public function testHint(): void
    {
        $form = new StubForm();
        $expected = '<div>Enter your name.</div>';
        $created = Hint::widget()->config($form, 'fieldString')->run();
        $this->assertEquals($expected, $created);

        $expected = '<div class="test">Enter your name.</div>';
        $created = Hint::widget()->config($form, 'fieldString', ['class' => 'test'])->run();
        $this->assertEquals($expected, $created);
    }
}
