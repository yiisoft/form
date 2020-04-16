<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\HintForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class HintFormTest extends TestCase
{
    public function testHintForm(): void
    {
        $form = new StubForm();
        $this->assertEquals(
            '<div>Enter your name.</div>',
            HintForm::create($form, 'name')
        );
        $this->assertEquals(
            '<div class="test">Enter your name.</div>',
            HintForm::create($form, 'name', ['class' => 'test'])
        );
    }
}
