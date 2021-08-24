<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\HtmlOptions;

use Yiisoft\Factory\Exception\InvalidConfigException;
use Yiisoft\Form\Tests\Stub\HtmlOptionsForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Field;

final class FieldInputTest extends TestCase
{
    /**
     * @dataProvider htmlOptionsDataProvider
     *
     * @param string $propertyName
     * @param string $expectedHtml
     *
     * @throws InvalidConfigException
     */
    public function testFieldsInput(string $propertyName, string $expectedHtml): void
    {
        $data = new HtmlOptionsForm();

        $actualHtml = Field::widget()
            ->config($data, $propertyName)
            ->run();
        $this->assertEqualsWithoutLE($expectedHtml, $actualHtml);
    }

    public function htmlOptionsDataProvider(): array
    {
        return [
            'number' => [
                'number',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-number">
                <label class="control-label" for="htmloptionsform-number">Number</label>
                <input type="number" id="htmloptionsform-number" class="form-control" name="HtmlOptionsForm[number]" value min="4" max="5" placeholder="Number">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
            'hasLength' => [
                'hasLength',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-haslength">
                <label class="control-label" for="htmloptionsform-haslength">Has Length</label>
                <input type="text" id="htmloptionsform-haslength" class="form-control" name="HtmlOptionsForm[hasLength]" value maxlength="5" minlength="4" placeholder="Has Length">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
            'required' => [
                'required',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-required">
                <label class="control-label required" for="htmloptionsform-required">Required</label>
                <input type="text" id="htmloptionsform-required" class="form-control" name="HtmlOptionsForm[required]" value required placeholder="Required">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
            'pattern' => [
                'pattern',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-pattern">
                <label class="control-label" for="htmloptionsform-pattern">Pattern</label>
                <input type="text" id="htmloptionsform-pattern" class="form-control" name="HtmlOptionsForm[pattern]" value pattern="\w+" placeholder="Pattern">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
            'email' => [
                'email',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-email">
                <label class="control-label" for="htmloptionsform-email">Email</label>
                <input type="email" id="htmloptionsform-email" class="form-control" name="HtmlOptionsForm[email]" value placeholder="Email">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
            'combined' => [
                'combined',
                <<<'HTML'
                <div class="form-group field-htmloptionsform-combined">
                <label class="control-label required" for="htmloptionsform-combined">Combined</label>
                <input type="number" id="htmloptionsform-combined" class="form-control" name="HtmlOptionsForm[combined]" value maxlength="5" minlength="4" min="4" max="5" required pattern="\w+" placeholder="Combined">

                <div class="help-block"></div>
                </div>
                HTML,
            ],
        ];
    }
}
