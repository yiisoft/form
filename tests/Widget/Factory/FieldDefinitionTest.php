<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\AttributesValidatorForm;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldDefinitionTest extends TestCase
{
    use TestTrait;

    public function definitionDataProvider(): array
    {
        $definitions = [
            [
                'checkbox',
                ['value' => '1'],
                [Field::TYPE_CHECKBOX => 'test-containerClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-errorClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-hintClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-inputClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-invalidClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-labelClass-checkbox'],
                [Field::TYPE_CHECKBOX => 'test-validClass-checkbox'],
                [
                    [
                        'value' => '',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-checkbox">
                        <input type="hidden" name="AttributesValidatorForm[checkbox]" value="0"><label><input type="checkbox" id="attributesvalidatorform-checkbox" class="test-inputClass-checkbox test-invalidClass-checkbox" name="AttributesValidatorForm[checkbox]" value="1" required> Checkbox</label>
                        <div class="test-hintClass-checkbox">Mark the checkbox.</div>
                        <div class="test-errorClass-checkbox">Value cannot be blank.</div>
                        </div>
                        HTML,
                    ],
                    [
                        'value' => '1',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-checkbox">
                        <input type="hidden" name="AttributesValidatorForm[checkbox]" value="0"><label><input type="checkbox" id="attributesvalidatorform-checkbox" class="test-inputClass-checkbox test-validClass-checkbox" name="AttributesValidatorForm[checkbox]" value="1" checked required> Checkbox</label>
                        <div class="test-hintClass-checkbox">Mark the checkbox.</div>
                        </div>
                        HTML,
                    ],
                ],
            ],
            [
                'email',
                [],
                [Field::TYPE_EMAIL => 'test-containerClass-email'],
                [Field::TYPE_EMAIL => 'test-errorClass-email'],
                [Field::TYPE_EMAIL => 'test-hintClass-email'],
                [Field::TYPE_EMAIL => 'test-inputClass-email'],
                [Field::TYPE_EMAIL => 'test-invalidClass-email'],
                [Field::TYPE_EMAIL => 'test-labelClass-email'],
                [Field::TYPE_EMAIL => 'test-validClass-email'],
                [
                    [
                        'value' => 'a',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-email">
                        <label class="test-labelClass-email" for="attributesvalidatorform-email">Email</label>
                        <input type="email" id="attributesvalidatorform-email" class="test-inputClass-email test-invalidClass-email" name="AttributesValidatorForm[email]" value="a" maxlength="20" minlength="8" required pattern="^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$">
                        <div class="test-hintClass-email">Write your email.</div>
                        <div class="test-errorClass-email">Is too short.</div>
                        </div>
                        HTML,
                    ],
                    [
                        'value' => 'admin@example.com',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-email">
                        <label class="test-labelClass-email" for="attributesvalidatorform-email">Email</label>
                        <input type="email" id="attributesvalidatorform-email" class="test-inputClass-email test-validClass-email" name="AttributesValidatorForm[email]" value="admin@example.com" maxlength="20" minlength="8" required pattern="^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$">
                        <div class="test-hintClass-email">Write your email.</div>
                        </div>
                        HTML,
                    ],
                ],
            ],
            [
                'text',
                [],
                [Field::TYPE_TEXT => 'test-containerClass-text'],
                [Field::TYPE_TEXT => 'test-errorClass-text'],
                [Field::TYPE_TEXT => 'test-hintClass-text'],
                [Field::TYPE_TEXT => 'test-inputClass-text'],
                [Field::TYPE_TEXT => 'test-invalidClass-text'],
                [Field::TYPE_TEXT => 'test-labelClass-text'],
                [Field::TYPE_TEXT => 'test-validClass-text'],
                [
                    [
                        'value' => '',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-text">
                        <label class="test-labelClass-text" for="attributesvalidatorform-text">Text</label>
                        <input type="text" id="attributesvalidatorform-text" class="test-inputClass-text test-invalidClass-text" name="AttributesValidatorForm[text]" maxlength="6" minlength="3" required pattern="^[a-zA-Z0-9_.-]+$">
                        <div class="test-errorClass-text">Value cannot be blank.</div>
                        </div>
                        HTML,
                    ],
                    [
                        'value' => 'sam',
                        'expected' => <<<'HTML'
                        <div class="test-containerClass-text">
                        <label class="test-labelClass-text" for="attributesvalidatorform-text">Text</label>
                        <input type="text" id="attributesvalidatorform-text" class="test-inputClass-text test-validClass-text" name="AttributesValidatorForm[text]" value="sam" maxlength="6" minlength="3" required pattern="^[a-zA-Z0-9_.-]+$">
                        </div>
                        HTML,
                    ],
                ],
            ],
        ];

        return $definitions;
    }

    /**
     * @dataProvider definitionDataProvider
     *
     * @param string $type
     * @param array $attributes
     * @param array $containerClass
     * @param array $errorClass
     * @param array $hintClass
     * @param array $inputClass
     * @param array $invalidClass
     * @param array $labelClass
     * @param array $validClass
     * @param array $expecteds
     */
    public function testDefinition(
        string $type,
        array $attributes,
        array $containerClass,
        array $errorClass,
        array $hintClass,
        array $inputClass,
        array $invalidClass,
        array $labelClass,
        array $validClass,
        array $expecteds
    ): void {
        // Create form model object.
        $this->createFormModel(AttributesValidatorForm::class);

        // Create validator.
        $validator = $this->createValidatorMock();

        // Set factory definition widget.
        $this->FactoryWidget(
            [
                Field::class => [
                    'addContainerClass()' => [$containerClass],
                    'addErrorClass()' => [$errorClass],
                    'addHintClass()' => [$hintClass],
                    'addInputClass()' => [$inputClass],
                    'addInvalidClass()' => [$invalidClass],
                    'addLabelClass()' => [$labelClass],
                    'addValidClass()' => [$validClass],
                ]
            ]
        );

        foreach ($expecteds as $expected) {
            // Set field attribute value.
            $this->formModel->setAttribute($type, $expected['value']);

            // Validate form.
            $validator->validate($this->formModel);

            // Check test.
            $this->assertEqualsWithoutLE(
                $expected['expected'],
                Field::widget()->for($this->formModel, $type)->$type([], $attributes)->render(),
            );
        }
    }

    public function testAddTemplate(): void
    {
        // Create form model object.
        $this->createFormModel(TypeForm::class);

        // Set factory widget.
        $template = [
            Field::TYPE_TEXT => '{input}',
            Field::TYPE_RADIO_LIST => '{input}{hint}{error}',
        ];
        $this->FactoryWidget([Field::class => ['addTemplate()' => [$template]]]);

        $expected = <<<'HTML'
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]" placeholder="Typed your text string.">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->render(),
        );

        $expected = <<<'HTML'
        <div>
        <div id="typeform-tonull">
        <label><input type="radio" name="TypeForm[toNull]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[toNull]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'toNull')
                ->radioList(['items()' => [[1 => 'Female', 2 => 'Male']]])
                ->render(),
        );
    }

    private function factoryWidget(array $definitions): void
    {
        WidgetFactory::initialize(new SimpleContainer(), $definitions);
    }
}
