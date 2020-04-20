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
        $created = Label::widget()->data($form)->attribute('fieldString')->run();
        $this->assertEquals($expected, $created);

        $expected = '<label class="test" for="stubform-fieldstring">Field String</label>';
        $created = Label::widget()->data($form)->attribute('fieldString')->options(['class' => 'test'])->run();
        $this->assertEquals($expected, $created);
    }
}
