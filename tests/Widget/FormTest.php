<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;

final class FormTest extends TestCase
{
    public function testFormsBegin(): void
    {
        $expected = '<form action="/test" method="POST">';
        $created = Form::widget()
            ->action('/test')
            ->begin();
        $this->assertEquals($expected, $created);

        $expected = '<form action="/example" method="GET">';
        $created = Form::widget()
            ->action('/example')
            ->method('GET')
            ->begin();
        $this->assertEquals($expected, $created);

        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Form::widget()->action('/example?id=1&title=%3C')->method('GET')->begin()
        );

        $expected = '<form action="/foo" method="GET">%A<input type="hidden" name="p" value="">';
        $actual = Form::widget()
            ->action('/foo?p')
            ->method('GET')
            ->begin();
        $this->assertStringMatchesFormat($expected, $actual);
    }

    public function testFormEmptyBegin(): void
    {
        $expected = '<form action="" method="POST">';
        $created = Form::widget()->begin();
        $this->assertEquals($expected, $created);
    }

    /**
     * Data provider for {@see testFormsBeginSimulateViaPost()}.
     *
     * @return array test data
     */
    public function dataProviderFormsBeginSimulateViaPost(): array
    {
        return [
            ['<form action="/foo" method="GET" _csrf="tokenCsrf">', 'GET',  ['_csrf' => 'tokenCsrf']],
            ['<form action="/foo" method="POST" _csrf="tokenCsrf">', 'POST', ['_csrf' => 'tokenCsrf']],
        ];
    }

    /**
     * @dataProvider dataProviderFormsBeginSimulateViaPost
     *
     * @param string $expected
     * @param string $method
     * @param array $options
     */
    public function testFormsBeginSimulateViaPost(string $expected, string $method, array $options = []): void
    {
        $actual = Form::widget()
            ->action('/foo')
            ->method($method)
            ->options($options)
            ->begin();
        $this->assertStringMatchesFormat($expected, $actual);
    }

    public function testFormsEnd(): void
    {
        Form::widget()->begin();
        $this->assertEquals('</form>', Form::end());
    }

    public function testFormsSimpleFields(): void
    {
        $data = new PersonalForm();

        $data->email('admin@example.com');
        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'email')
                ->template('{input}')
                ->input('email');
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-email">
<input type="email" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com" placeholder="Email">
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Form::widget()->action('/something')->options(['class' => 'formTestMe'])->begin();
        $html .= Field::widget()
                ->config($data, 'email')
                ->enclosedByContainer(true, ['class' => 'fieldTestMe'])
                ->template('{input}')
                ->input('email', ['required' => true]);
        $html .= Form::end();

        $expected = <<<'HTML'
<form class="formTestMe" action="/something" method="POST"><div class="form-group field-personalform-email fieldTestMe">
<input type="email" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com" required placeholder="Email">
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFormsFieldsOptions(): void
    {
        $data = new PersonalForm();

        $data->name('yii test');
        $data->validate();

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'name')
                ->inputCssClass('form-testme');
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-testme" name="PersonalForm[name]" value="yii test" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'name')
                ->inputCssClass('form-testme');
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-testme" name="PersonalForm[name]" value="yii test" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFormsIssue5356(): void
    {
        $citys = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];

        $data = new PersonalForm();
        $data->cityBirth(2);

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'cityBirth')
                ->template('{input}')
                ->listBox($citys, ['multiple' => true, 'unselect' => '1']);
        $html .= Form::end();

        /** https://github.com/yiisoft/yii2/issues/5356 */
        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-citybirth">
<input type="hidden" name="PersonalForm[cityBirth]" value="1"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'cityBirth')
                ->listBox($citys, ['multiple' => true, 'unselect' => '1']);
        $html .= Form::end();

        /** https://github.com/yiisoft/yii2/issues/5356 */
        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-citybirth">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<input type="hidden" name="PersonalForm[cityBirth]" value="1"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFormsFieldsValidationOnContainer(): void
    {
        $fieldConfig = [
            'validationStateOn()' => ['container'],
        ];

        $data = new PersonalForm();
        $data->name('yii');
        $data->email('admin@example.com');
        $data->validate();

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget($fieldConfig)
                ->config($data, 'name');
        $html .= Field::widget($fieldConfig)
                ->config($data, 'email');
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name has-error">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div><div class="form-group field-personalform-email has-error">
<label class="control-label" for="personalform-email">Email</label>
<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com" placeholder="Email">

<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFormsFieldsValidationOnInput(): void
    {
        $data = new PersonalForm();
        $data->name('yii');
        $data->email('admin');
        $data->validate();

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget()
                ->config($data, 'name');
        $html .= Field::widget()
                ->config($data, 'email');
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block">Is too short.</div>
</div><div class="form-group field-personalform-email">
<label class="control-label" for="personalform-email">Email</label>
<input type="text" id="personalform-email" class="form-control has-error" name="PersonalForm[email]" value="admin" aria-invalid="true" placeholder="Email">

<div class="help-block">This value is not a valid email address.</div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testForms(): void
    {
        $fieldConfig = [
            'inputCssClass()' => ['form-control testMe'],
            'validationStateOn()' => ['container'],
        ];

        $cities = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];

        $record = [
            'PersonalForm' => [
                'id' => 1,
                'email' => 'admin@.com',
                'name' => 'Jack Ryan',
                'cityBirth' => 2,
                'entryDate' => '2019-04-20',
                'sex' => 1,
                'terms' => true,
            ],
        ];

        $data = new PersonalForm();
        $data->load($record);
        $data->validate();

        $html = Form::widget()->action('/something')->begin();
        $html .= Field::widget($fieldConfig)
                ->config($data, 'id')
                ->textinput();
        $html .= Field::widget($fieldConfig)
                ->config($data, 'email')
                ->input('email');
        $html .= Field::widget($fieldConfig)
                ->config($data, 'name')
                ->textinput();
        $html .= Field::widget($fieldConfig)
                ->config($data, 'cityBirth')
                ->listBox($cities, ['multiple' => true, 'unselect' => '1']);
        $html .= Field::widget($fieldConfig)
                ->config($data, 'entryDate')
                ->input('date');
        $html .= Field::widget($fieldConfig)
                ->config($data, 'sex')
                ->checkboxList(['Female', 'Male'], ['unselect' => '0']);
        $html .= Field::widget($fieldConfig)
                ->config($data, 'terms')
                ->radio(['unselect' => '0']);
        $html .= Form::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-id has-error">
<label class="control-label" for="personalform-id">Id</label>
<input type="text" id="personalform-id" class="form-control testMe" name="PersonalForm[id]" value="1" placeholder="Id">

<div class="help-block"></div>
</div><div class="form-group field-personalform-email has-error">
<label class="control-label" for="personalform-email">Email</label>
<input type="email" id="personalform-email" class="form-control testMe" name="PersonalForm[email]" value="admin@.com" aria-invalid="true" placeholder="Email">

<div class="help-block">This value is not a valid email address.</div>
</div><div class="form-group field-personalform-name has-error">
<label class="control-label required" for="personalform-name">Name</label>
<input type="text" id="personalform-name" class="form-control testMe" name="PersonalForm[name]" value="Jack Ryan" aria-required="true" placeholder="Name">
<div class="hint-block">Write your first name.</div>
<div class="help-block"></div>
</div><div class="form-group field-personalform-citybirth has-error">
<label class="control-label" for="personalform-citybirth">City Birth</label>
<input type="hidden" name="PersonalForm[cityBirth]" value="1"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div><div class="form-group field-personalform-entrydate has-error">
<label class="control-label" for="personalform-entrydate">Entry Date</label>
<input type="date" id="personalform-entrydate" class="form-control testMe" name="PersonalForm[entryDate]" value="2019-04-20">

<div class="help-block"></div>
</div><div class="form-group field-personalform-sex has-error">
<label class="control-label" for="personalform-sex">Sex</label>
<input type="hidden" name="PersonalForm[sex]" value="0"><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label></div>

<div class="help-block"></div>
</div><div class="form-group field-personalform-terms has-error">

<input type="hidden" name="PersonalForm[terms]" value="0"><label><input type="radio" id="personalform-terms" name="PersonalForm[terms]" value="1" checked unselect="0"> Terms</label>

<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
