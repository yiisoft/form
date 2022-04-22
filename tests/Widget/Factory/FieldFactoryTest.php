<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\AttributesValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldFactoryTest extends TestCase
{
    use TestTrait;

    public function definitionDataProvider(): array
    {
        return [
            [
                // Set field type.
                'checkbox',
                // Set attributes.
                ['value' => '1'],
                // Set definitions.
                [
                    'containerClass()' => ['container-class'],
                ],
                // Set defaultValues.
                [
                    'checkbox' => [
                        'definitions' => [
                            'labelAttributes()' => [['class' => 'form-check-label']],
                        ],
                        'containerClass' => 'container-class-checkbox',
                        'errorClass' => 'invalid-feedback',
                        'hintClass' => 'form-text text-muted',
                        'inputClass' => 'form-check-input',
                        'invalidClass' => 'is-invalid',
                        'validClass' => 'is-valid',
                    ],
                ],
                //expecteds
                [
                    [
                        // Set value validation.
                        'value' => '',
                        // Expected.
                        'expected' => <<<HTML
                        <div class="container-class-checkbox">
                        <input type="hidden" name="AttributesValidatorForm[checkbox]" value="0"><label class="form-check-label"><input type="checkbox" id="attributesvalidatorform-checkbox" class="form-check-input is-invalid" name="AttributesValidatorForm[checkbox]" value="1"> Checkbox</label>
                        <div class="form-text text-muted">Mark the checkbox.</div>
                        <div class="invalid-feedback">Value cannot be blank.</div>
                        </div>
                        HTML,
                    ],
                    [
                        // Set value validation.
                        'value' => '1',
                        // Expected.
                        'expected' => <<<HTML
                        <div class="container-class-checkbox">
                        <input type="hidden" name="AttributesValidatorForm[checkbox]" value="0"><label class="form-check-label"><input type="checkbox" id="attributesvalidatorform-checkbox" class="form-check-input is-valid" name="AttributesValidatorForm[checkbox]" value="1" checked> Checkbox</label>
                        <div class="form-text text-muted">Mark the checkbox.</div>
                        </div>
                        HTML,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider definitionDataProvider
     *
     * @param string $type
     * @param array $attributes
     * @param array $definitions
     * @param array $defaultValues
     * @param array $expecteds
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefinition(
        string $type,
        array $attributes,
        array $definitions,
        array $defaultValues,
        array $expecteds
    ): void {
        // Set factory definition widget.
        $this->FactoryWidget(
            [
                Field::class => [
                    'defaultValues()' => [$defaultValues],
                ],
            ]
        );

        /** @psalm-var string[][] $expecteds */
        foreach ($expecteds as $expected) {
            // Create form model object.
            $formModel = new AttributesValidatorForm();
            // Set field attribute value.
            $formModel->setAttribute($type, $expected['value']);
            // Validate form.
            $this->createValidatorMock()->validate($formModel);
            // Check test.
            $this->assertEqualsWithoutLE(
                $expected['expected'],
                Field::widget($definitions)->attributes($attributes)->$type($formModel, $type)->render(),
            );
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function factoryWidget(array $definitions): void
    {
        WidgetFactory::initialize(new SimpleContainer(), $definitions);
    }
}
