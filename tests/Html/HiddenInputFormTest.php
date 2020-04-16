<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\HiddenInputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class HiddenInputFormTest extends TestCase
{
    public function testHiddenInputForm(): void
    {
        $form = new StubForm();

        $this->assertEquals(
            '<input type="hidden" id="stubform-fieldhidden" name="test">',
            HiddenInputForm::create($form, 'fieldHidden', ['name' => 'test'])
        );

        $this->assertEquals(
            '<input type="hidden" id="stubform-fieldhidden" class="test" name="test" value="value">',
            HiddenInputForm::create($form, 'fieldHidden', ['name' => 'test', 'value' => 'value', 'class' => 'test'])
        );
    }
}
