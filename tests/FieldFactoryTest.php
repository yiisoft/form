<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Factory\Factory;
use Yiisoft\Form\FieldFactory;
use Yiisoft\Form\FieldFactoryConfig;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\InputTextForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\Validator;
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
                <label for="inputtextform-name">Name</label>
                <input type="text" id="inputtextform-name" name="InputTextForm[name]" value placeholder="Typed your name here">
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
                <label for="inputtextform-job">Job</label>
                <input type="text" id="inputtextform-job" name="InputTextForm[job]" value>
                </section>
                HTML,
                [
                    'containerTag()' => ['section'],
                    'containerTagAttributes()' => [['class' => 'wrapper']],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <label for="inputtextform-job">Job</label>
                <input type="text" id="inputtextform-job" name="InputTextForm[job]" value>
                HTML,
                [
                    'useContainer()' => [false],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <div>
                <div class="wrap">
                <div>Input your full name.</div>
                <label for="inputtextform-name">Name</label>
                <div>Value cannot be blank.</div>
                <input type="text" id="inputtextform-name" name="InputTextForm[name]" value placeholder="Typed your name here">
                </div>
                </div>
                HTML,
                [
                    'template()' => ["<div class=\"wrap\">\n{hint}\n{label}\n{error}\n{input}\n</div>"],
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label>Job</label>
                <input type="text" class="form-control" name="InputTextForm[job]" value>
                </div>
                HTML,
                [
                    'setInputIdAttribute()' => [false],
                    'formElementTagAttributes()' => [['class' => 'form-control']],
                ],
                'job',
            ],
            [
                <<<'HTML'
                <div>
                <label>Name</label>
                <input type="text" id="inputtextform-name" name="InputTextForm[name]" value placeholder="Typed your name here">
                <div class="info">Input your full name.</div>
                <div class="red">Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'labelConfig()' => [
                        [
                            'setForAttribute()' => [false],
                        ]
                    ],
                    'hintConfig()' => [
                        [
                            'tagAttributes()' => [['class' => 'info']]
                        ]
                    ],
                    'errorConfig()' => [
                        [
                            'tagAttributes()' => [['class' => 'red']]
                        ]
                    ],
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label for="inputtextform-name">Name</label>
                <input type="text" id="inputtextform-name" name="InputTextForm[name]" value>
                <div>Input your full name.</div>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'usePlaceholder()' => [false],
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div>
                <label for="inputtextform-name">Name</label>
                <input type="text" id="inputtextform-name" name="InputTextForm[name]" value>
                <div>Input your full name.</div>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'usePlaceholder()' => [false],
                ],
                'name',
            ],
            [
                <<<'HTML'
                <div class="wrapper" data-value="42">
                <label for="inputtextform-job">Job</label>
                <input type="text" id="inputtextform-job" name="InputTextForm[job]" value data-type="field" data-kind="input-text">
                </div>
                HTML,
                [
                    'containerTag()' => ['section'],
                    'containerTagAttributes()' => [['class' => 'wrapper']],
                    'formElementTagAttributes()' => [['data-type' => 'field']],
                    'inputTextConfig()' => [
                        [
                            'containerTag()' => ['div'],
                            'containerTagAttributes()' => [['data-value' => 42]],
                            'formElementTagAttributes()' => [['data-kind' => 'input-text']],
                        ]
                    ],
                ],
                'job',
            ],
        ];
    }

    /**
     * @dataProvider dataInputText
     */
    public function testInputText(string $expected, array $config, string $attribute): void
    {
        $field = $this->createFieldFactory($config);

        $form = new InputTextForm();
        (new Validator())->validate($form);

        $result = $field->inputText($form, $attribute)->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function dataLabel(): array
    {
        return [
            [
                <<<'HTML'
                <label for="inputtextform-job">Job</label>
                HTML,
                [],
            ],
            [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'setInputIdAttribute()' => [false],
                ],
            ],
            [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'labelConfig()' => [
                        [
                            'setForAttribute()' => [false],
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataLabel
     */
    public function testLabel(string $expected, array $config): void
    {
        $field = $this->createFieldFactory($config);

        $result = $field->label(new InputTextForm(), 'job')->render();

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
                    'hintConfig()' => [
                        [
                            'tag()' => ['b'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataHint
     */
    public function testHint(string $expected, array $config): void
    {
        $field = $this->createFieldFactory($config);

        $result = $field->hint(new InputTextForm(), 'name')->render();

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
                    'errorConfig()' => [
                        [
                            'tag()' => ['b'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataError
     */
    public function testError(string $expected, array $config): void
    {
        $field = $this->createFieldFactory($config);

        $form = new InputTextForm();
        (new Validator())->validate($form);

        $result = $field->error($form, 'name')->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    private function createFieldFactory(array $config = []): FieldFactory
    {
        $container = new SimpleContainer();

        WidgetFactory::initialize($container);

        $factory = new Factory($container, [FieldFactoryConfig::class => $config]);

        return new FieldFactory($factory->create(FieldFactoryConfig::class));
    }
}
