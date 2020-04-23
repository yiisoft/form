<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\FormBuilder;
use Yiisoft\Form\Widget\FieldBuilder;

final class FormBuilderTest extends TestCase
{
    public function testBooleanAttributes()
    {
        $data = new StubForm();

        $form = FormBuilder::begin()->action('/something')->start();

            echo $form->field($data, 'fieldString')
                ->template('{input}')
                ->input('email');

        $html = FormBuilder::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-stubform-fieldstring">
<input type="email" id="stubform-fieldstring" class="form-control" name="StubForm[fieldString]" aria-required="true" required>
</div></form>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);

        $form = FormBuilder::begin()->action('/something')->options(['class' => 'formTestMe'])->start();

            echo $form->field($data, 'fieldString', ['class' => 'fieldTestMe'])
                ->template('{input}')
                ->required(false)
                ->input('email');

        $html = FormBuilder::end();

        $expected = <<<'HTML'
<form class="formTestMe" action="/something" method="POST"><div class="form-group field-stubform-fieldstring fieldTestMe">
<input type="email" id="stubform-fieldstring" class="form-control" name="StubForm[fieldString]" aria-required="true">
</div></form>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }
}
