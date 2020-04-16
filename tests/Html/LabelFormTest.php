<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\LabelForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class LabelFormTest extends TestCase
{
    public function testLabelForm(): void
    {
        $form = new StubForm();

        $expected = '<label for="stubform-name">Name</label>';
        $this->assertEquals($expected, LabelForm::create($form, 'name'));

        $expected = '<label class="test" for="stubform-name">Name</label>';
        $this->assertEquals($expected, LabelForm::create($form, 'name', ['class' => 'test']));
    }
}
