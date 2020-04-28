<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Forms;
use Yiisoft\Form\Widget\Fields;

final class FormsTest extends TestCase
{
    public function testFormsBegin(): void
    {
        $expected = '<form action="/test" method="POST">';
        $created = Forms::begin()
            ->action('/test')
            ->start();
        $this->assertEquals($expected, $created);

        $expected = '<form action="/example" method="GET">';
        $created = Forms::begin()
            ->action('/example')
            ->method('GET')
            ->start();
        $this->assertEquals($expected, $created);

        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Forms::begin()->action('/example?id=1&title=%3C')->method('GET')->start()
        );

        $expected = '<form action="/foo" method="GET">%A<input type="hidden" name="p" value="">';
        $actual = Forms::begin()
            ->action('/foo?p')
            ->method('GET')
            ->start();
        $this->assertStringMatchesFormat($expected, $actual);
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
     *
     * @throws InvalidConfigException
     */
    public function testFormsBeginSimulateViaPost(string $expected, string $method, array $options = []): void
    {
        $actual = Forms::begin()
            ->action('/foo')
            ->method($method)
            ->options($options)
            ->start();
        $this->assertStringMatchesFormat($expected, $actual);
    }

    public function testFormsEnd(): void
    {
        $this->assertEquals('</form>', Forms::end());
    }

    public function testFormsSimpleFields(): void
    {
        $data = new PersonalForm();

        $data->email('admin@example.com');
        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()
                ->config($data, 'email')
                ->template('{input}')
                ->input('email');
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-email">
<input type="email" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com">
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Forms::begin()->action('/something')->options(['class' => 'formTestMe'])->start();
            $html .= Fields::widget()
                ->config($data, 'email', ['class' => 'fieldTestMe'])
                ->template('{input}')
                ->input('email', ['required' => true]);
        $html .= Forms::end();

        $expected = <<<'HTML'
<form class="formTestMe" action="/something" method="POST"><div class="form-group field-personalform-email fieldTestMe">
<input type="email" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com" required>
</div></form>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFormsFieldsOptions(): void
    {
        $data = new PersonalForm();

        $data->name('yii test');
        $data->validate();

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()
                ->config($data, 'name')
                ->inputCss('form-testme');
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-testme" name="PersonalForm[name]" value="yii test" aria-required="true">
<div class="hint-block">Write your firts name.</div>
<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()
                ->config($data, 'name')
                ->inputCss('form-testme');
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-testme" name="PersonalForm[name]" value="yii test" aria-required="true">
<div class="hint-block">Write your firts name.</div>
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
            '4' => 'Ekaterinburgo'
        ];

        $data = new PersonalForm();
        $data->cityBirth(2);

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()
                ->config($data, 'cityBirth')
                ->template('{input}')
                ->listBox($citys, ['multiple' => true, 'unselect' => '1']);
        $html .= Forms::end();

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

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()
                ->config($data, 'cityBirth')
                ->listBox($citys, ['multiple' => true, 'unselect' => '1']);
        $html .= Forms::end();

        /** https://github.com/yiisoft/yii2/issues/5356 */
        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-citybirth">

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
        $data = new PersonalForm();
        $data->name('yii');
        $data->email('admin@example.com');
        $data->validate();

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()->config($data, 'name')->validationStateOn('container');
            $html .= Fields::widget()->config($data, 'email')->validationStateOn('container');
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name has-error">

<input type="text" id="personalform-name" class="form-control" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true">
<div class="hint-block">Write your firts name.</div>
<div class="help-block">Is too short.</div>
</div><div class="form-group field-personalform-email has-error">

<input type="text" id="personalform-email" class="form-control" name="PersonalForm[email]" value="admin@example.com">

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

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget()->config($data, 'name');
            $html .= Fields::widget()->config($data, 'email');
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-name">

<input type="text" id="personalform-name" class="form-control has-error" name="PersonalForm[name]" value="yii" aria-required="true" aria-invalid="true">
<div class="hint-block">Write your firts name.</div>
<div class="help-block">Is too short.</div>
</div><div class="form-group field-personalform-email">

<input type="text" id="personalform-email" class="form-control has-error" name="PersonalForm[email]" value="admin" aria-invalid="true">

<div class="help-block">This value is not a valid email address.</div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testForms(): void
    {
        $fieldConfig = [
            'inputCss()' => ['form-control testMe'],
            'validationStateOn()' => ['container'],
        ];

        $citys = [
            '1' => 'Moscu',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo'
        ];

        $record = [
            'PersonalForm' => [
                'id' => 1,
                'email' => 'admin@.com',
                'name' => 'Jack Ryan',
                'cityBirth' => 2,
                'entryDate' => '2019-04-20',
                'sex' => 1,
                'terms' => true
            ]
        ];

        $data = new PersonalForm();
        $data->load($record);
        $data->validate();

        $html = Forms::begin()->action('/something')->start();
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'id')
                ->label(true)
                ->textinput();
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'email')
                ->label(true, ['placeholder' => true])
                ->input('email');
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'name')
                ->label(true)
                ->textinput();
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'cityBirth')
                ->label(true)
                ->listBox($citys, ['multiple' => true, 'unselect' => '1']);
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'entryDate')
                ->label(true)
                ->input('date');
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'sex')
                ->label(true)
                ->checkboxList(['Female', 'Male'], ['unselect' => '0']);
            $html .= Fields::widget($fieldConfig)
                ->config($data, 'terms')
                ->checkbox(['unselect' => '0']);
        $html .= Forms::end();

        $expected = <<<'HTML'
<form action="/something" method="POST"><div class="form-group field-personalform-id has-error">
<label class="control-label" for="personalform-id">id</label>
<input type="text" id="personalform-id" class="form-control testMe" name="PersonalForm[id]" value="1">

<div class="help-block"></div>
</div><div class="form-group field-personalform-email has-error">
<label class="control-label" placeholder="Email" for="personalform-email">email</label>
<input type="email" id="personalform-email" class="form-control testMe" name="PersonalForm[email]" value="admin@.com" aria-invalid="true">

<div class="help-block">This value is not a valid email address.</div>
</div><div class="form-group field-personalform-name has-error">
<label class="control-label" for="personalform-name">name</label>
<input type="text" id="personalform-name" class="form-control testMe" name="PersonalForm[name]" value="Jack Ryan" aria-required="true">
<div class="hint-block">Write your firts name.</div>
<div class="help-block"></div>
</div><div class="form-group field-personalform-citybirth has-error">
<label class="control-label" for="personalform-citybirth">cityBirth</label>
<input type="hidden" name="PersonalForm[cityBirth]" value="1"><select id="personalform-citybirth" name="PersonalForm[cityBirth][]" multiple size="4">
<option value="1">Moscu</option>
<option value="2" selected>San Petersburgo</option>
<option value="3">Novosibirsk</option>
<option value="4">Ekaterinburgo</option>
</select>

<div class="help-block"></div>
</div><div class="form-group field-personalform-entrydate has-error">
<label class="control-label" for="personalform-entrydate">entryDate</label>
<input type="date" id="personalform-entrydate" class="form-control testMe" name="PersonalForm[entryDate]" value="2019-04-20">

<div class="help-block"></div>
</div><div class="form-group field-personalform-sex has-error">
<label class="control-label" for="personalform-sex">sex</label>
<input type="hidden" name="PersonalForm[sex]" value="0"><div id="personalform-sex"><label><input type="checkbox" name="PersonalForm[sex][]" value="0"> Female</label>
<label><input type="checkbox" name="PersonalForm[sex][]" value="1" checked> Male</label></div>

<div class="help-block"></div>
</div><div class="form-group field-personalform-terms has-error">

<label><input type="checkbox" id="personalform-terms" name="PersonalForm[terms]" value="1" checked unselect="0"> Terms</label>

<div class="help-block"></div>
</div></form>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
