<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\Label;

final class LabelTest extends TestCase
{
    public function testLabelForm(): void
    {
        $form = new StubForm();

        $expected = '<label for="stubform-fieldstring">Field String</label>';
        $created = Label::widget()
            ->config($form, 'fieldString')
            ->run();
        $this->assertEquals($expected, $created);

        $expected = '<label class="test" placeholder="Field String" for="stubform-fieldstring">Field String</label>';
        $created = Label::widget()
            ->config($form, 'fieldString', ['class' => 'test', 'placeholder' => true])
            ->run();
        $this->assertEquals($expected, $created);

        $expected = '<label class="test" placeholder="Custom PlaceHolder" for="stubform-fieldstring">Field String</label>';
        $created = Label::widget()
            ->config($form, 'fieldString', ['class' => 'test'])
            ->addPlaceHolder(false, 'Custom PlaceHolder')
            ->run();
        $this->assertEquals($expected, $created);
    }
}
