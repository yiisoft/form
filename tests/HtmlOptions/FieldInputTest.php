<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\HtmlOptions;

use Yiisoft\Form\Tests\Stub\HtmlOptionsForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldInputTest extends TestCase
{
    public function testFieldsInput(): void
    {
        $data = new HtmlOptionsForm();

        $expected = <<<'HTML'
<div class="form-group field-htmloptionsform-name">
<label class="control-label" for="htmloptionsform-name">Name</label>
<input type="name" id="htmloptionsform-name" class="form-control" name="HtmlOptionsForm[name]" value="" min="4" max="5" placeholder="Name">

<div class="help-block"></div>
</div>
HTML;
        $html = Field::widget()
            ->config($data, 'name')
            ->input('name')
            ->run();
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
