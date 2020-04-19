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
        $form = new StubForm();
        ob_start();

        $forms = FormBuilder::begin()->action('/something')->start();
        FormBuilder::end();

        ob_end_clean();

        $expected = <<<'HTML'
<div class="form-group field-stubform-fieldstring">
<input type="email" id="stubform-fieldstring" class="form-control" name="StubForm[fieldString]" required aria-required="true">
</div>
HTML;
        $created = FieldBuilder::widget()
            ->withForm($forms)
            ->form($form)
            ->attribute('fieldString')
            ->template('{input}')
            ->input('email', ['required' => true])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'HTML'
<div class="form-group field-stubform-fieldstring">
<input type="email" id="stubform-fieldstring" class="form-control" name="StubForm[fieldString]" aria-required="true">
</div>
HTML;
        $created = FieldBuilder::widget()
            ->withForm($forms)
            ->form($form)
            ->attribute('fieldString')
            ->template('{input}')
            ->input('email', ['required' => false])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $expected = <<<'HTML'
<div class="form-group field-stubform-fieldstring">
<input type="email" id="stubform-fieldstring" class="form-control" name="StubForm[fieldString]" required="test" aria-required="true">
</div>
HTML;
        $created = FieldBuilder::widget()
            ->withForm($forms)
            ->form($form)
            ->attribute('fieldString')
            ->template('{input}')
            ->input('email', ['required' => 'test'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
