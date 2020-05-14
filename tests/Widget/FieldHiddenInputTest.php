<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Field;

final class FieldHiddenInputTest extends TestCase
{
    public function testFieldHiddenInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<div class="form-group field-personalform-name">

<input type="hidden" id="personalform-name" class="form-control" name="PersonalForm[name]">


</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->hiddenInput()
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
