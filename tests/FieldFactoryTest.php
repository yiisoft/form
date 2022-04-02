<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\FieldFactory;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldFactoryTest extends TestCase
{
    use AssertTrait;

    public function dataInputText(): array
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
            [
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
        ];
    }

    /**
     * @dataProvider dataInputText
     */
    public function testInputText(string $expected, array $factoryParameters, string $attribute): void
    {
        $field = $this->createFieldFactory($factoryParameters);

        $result = $field->widget(Text::class, TextForm::validated(), $attribute)->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function dataLabel(): array
    {
        return [
            [
                <<<'HTML'
                <label for="textform-job">Job</label>
                HTML,
                [],
            ],
            [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'setInputIdAttribute' => false,
                ],
            ],
            [
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

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
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

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    private function createFieldFactory(array $parameters = []): FieldFactory
    {
        $container = new SimpleContainer();

        WidgetFactory::initialize($container);

        return new FieldFactory(...$parameters);
    }
}
