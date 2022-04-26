<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\FieldFactory;
use Yiisoft\Form\Tests\Support\Form\ErrorSummaryForm;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldFactoryTest extends TestCase
{
    public function dataText(): array
    {
        return [
            [
                <<<'HTML'
                <div>
                <label for="textform-name">Name</label>
                <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
                <div>Input your full name.</div>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-company">Company</label>
                <input type="text" id="textform-company" name="TextForm[company]" value required>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'enrichmentFromRules' => true,
                ],
                'company',
            ],
            [
                <<<'HTML'
                <section class="wrapper">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                </section>
                HTML,
                [
                    'containerTag' => 'section',
                    'containerTagAttributes' => ['class' => 'wrapper'],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                HTML,
                [
                    'useContainer' => false,
                ],
                'job',
            ],
            'common-template' => [
                <<<'HTML'
                <div>
                <div class="wrap">
                <div>Input your full name.</div>
                <label for="textform-name">Name</label>
                <div>Value cannot be blank.</div>
                <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
                </div>
                </div>
                HTML,
                [
                    'template' => "<div class=\"wrap\">\n{hint}\n{label}\n{error}\n{input}\n</div>",
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label>Job</label>
                <input type="text" class="form-control" name="TextForm[job]" value>
                </div>
                HTML,
                [
                    'setInputIdAttribute' => false,
                    'inputTagAttributes' => ['class' => 'form-control'],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <div>
                <label>Name</label>
                <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Typed your name here">
                <div class="info">Input your full name.</div>
                <div class="red">Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'labelConfig' => [
                        'setForAttribute()' => [false],
                    ],
                    'hintConfig' => [
                        'tagAttributes()' => [['class' => 'info']],
                    ],
                    'errorConfig' => [
                        'tagAttributes()' => [['class' => 'red']],
                    ],
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-name">Name</label>
                <input type="text" id="textform-name" name="TextForm[name]" value>
                <div>Input your full name.</div>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'usePlaceholder' => false,
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-name">Name</label>
                <input type="text" id="textform-name" name="TextForm[name]" value>
                <div>Input your full name.</div>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'usePlaceholder' => false,
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div class="main-wrapper">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value data-type="input-text">
                </div>
                HTML,
                [
                    'containerTag' => 'section',
                    'containerTagAttributes' => ['class' => 'wrapper'],
                    'inputTagAttributes' => ['data-type' => 'field'],
                    'fieldConfigs' => [
                        Text::class => [
                            'containerTag()' => ['div'],
                            'containerTagAttributes()' => [['class' => 'main-wrapper']],
                            'inputTagAttributes()' => [['data-type' => 'input-text']],
                        ],
                    ],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <div class="wrapper valid">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                </div>
                HTML,
                [
                    'validClass' => 'valid',
                    'containerTagAttributes' => ['class' => 'wrapper'],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <div class="wrapper invalid">
                <label for="textform-company">Company</label>
                <input type="text" id="textform-company" name="TextForm[company]" value>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'invalidClass' => 'invalid',
                    'containerTagAttributes' => ['class' => 'wrapper'],
                ],
                'company',
            ],
        ];
    }

    /**
     * @dataProvider dataText
     */
    public function testText(string $expected, array $factoryParameters, string $attribute): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->text(TextForm::validated(), $attribute)->render();

        $this->assertSame($expected, $result);
    }

    public function dataErrorSummary(): array
    {
        return [
            'base' => [
                <<<'HTML'
                <div>
                <p>Please fix the following errors:</p>
                <ul>
                <li>Value cannot be blank.</li>
                </ul>
                </div>
                HTML,
                [],
            ],
            'non-exists-common-methods' => [
                <<<'HTML'
                <div>
                <p>Please fix the following errors:</p>
                <ul>
                <li>Value cannot be blank.</li>
                </ul>
                </div>
                HTML,
                [
                    'template' => '{input}',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataErrorSummary
     */
    public function testErrorSummary(string $expected, array $factoryParameters): void
    {
        $factoryParameters = array_merge(
            [
                'fieldConfigs' => [
                    ErrorSummary::class => [
                        'onlyAttributes()' => ['name'],
                    ],
                ],
            ],
            $factoryParameters
        );

        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->errorSummary(ErrorSummaryForm::validated())->render();

        $this->assertSame($expected, $result);
    }

    public function dataFieldSet(): array
    {
        return [
            'empty' => [
                <<<HTML
                <div>
                <fieldset>
                </fieldset>
                </div>
                HTML,
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataFieldSet
     */
    public function testFieldSet(string $expected, array $factoryParameters): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->fieldset()->render();

        $this->assertSame($expected, $result);
    }

    public function testFieldSetWithOverrideTemplateBeginAndTemplateEnd(): void
    {
        $field = $this->createFieldFactory([
            'templateBegin' => "before\n{input}",
            'templateEnd' => "{input}\nafter",
        ]);

        $field = $field->fieldset();

        $result = $field->begin() . 'hello' . $field::end();

        $expected = <<<HTML
            <div>
            before
            <fieldset>hello</fieldset>
            after
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataLabel(): array
    {
        return [
            'simple' => [
                <<<'HTML'
                <label for="textform-job">Job</label>
                HTML,
                [],
            ],
            'set-input-id-attribute-false' => [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'labelConfig' => [
                        'useInputIdAttribute()' => [false],
                    ],
                ],
            ],
            'set-for-attribute-false' => [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'labelConfig' => [
                        'setForAttribute()' => [false],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataLabel
     */
    public function testLabel(string $expected, array $factoryParameters): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->label(new TextForm(), 'job')->render();

        $this->assertSame($expected, $result);
    }

    public function dataHint(): array
    {
        return [
            [
                <<<'HTML'
                <div>Input your full name.</div>
                HTML,
                [],
            ],
            [
                <<<'HTML'
                <b>Input your full name.</b>
                HTML,
                [
                    'hintConfig' => [
                        'tag()' => ['b'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataHint
     */
    public function testHint(string $expected, array $factoryParameters): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->hint(new TextForm(), 'name')->render();

        $this->assertSame($expected, $result);
    }

    public function dataError(): array
    {
        return [
            [
                <<<'HTML'
                <div>Value cannot be blank.</div>
                HTML,
                [],
            ],
            [
                <<<'HTML'
                <b>Value cannot be blank.</b>
                HTML,
                [
                    'errorConfig' => [
                        'tag()' => ['b'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataError
     */
    public function testError(string $expected, array $factoryParameters): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->error(TextForm::validated(), 'name')->render();

        $this->assertSame($expected, $result);
    }

    public function testNotInputFieldInInputMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Input widget must be instance of "Yiisoft\Form\Field\Base\InputField".');
        $this->createFieldFactory()->input(ErrorSummary::class, new ErrorSummaryForm(), 'name');
    }

    private function createFieldFactory(array $parameters = []): FieldFactory
    {
        $container = new SimpleContainer();

        WidgetFactory::initialize($container);

        return new FieldFactory(...$parameters);
    }
}
