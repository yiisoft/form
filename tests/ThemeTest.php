<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class ThemeTest extends TestCase
{
    public static function dataText(): array
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
                new PureInputData(
                    name: 'TextForm[name]',
                    value: '',
                    label: 'Name',
                    hint: 'Input your full name.',
                    placeholder: 'Typed your name here',
                    id: 'textform-name',
                    validationErrors: ['Value cannot be blank.'],
                ),
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
                    'enrichFromValidationRules' => true,
                ],
                new PureInputData(
                    name: 'TextForm[company]',
                    value: '',
                    label: 'Company',
                    id: 'textform-company',
                    validationErrors: ['Value cannot be blank.'],
                ),
                ['inputAttributes' => ['required' => true]],
            ],
            [
                <<<HTML
                <div>
                <input type="text" name="TextForm[company]" value>
                </div>
                HTML,
                [
                    'enrichFromValidationRules' => false,
                ],
                new PureInputData(
                    name: 'TextForm[company]',
                    value: '',
                ),
                ['inputAttributes' => ['required' => true]],
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
                    'containerAttributes' => ['class' => 'wrapper'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<HTML
                <div class="wrapper">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                </div>
                HTML,
                ['containerClass' => 'wrapper'],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<HTML
                <div class="wrapper red">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                </div>
                HTML,
                ['containerClass' => ['wrapper', 'red']],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<HTML
                <div>
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" class="red" name="TextForm[job]" value>
                </div>
                HTML,
                ['inputClass' => 'red'],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<HTML
                <div>
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" class="red blue" name="TextForm[job]" value>
                </div>
                HTML,
                ['inputClass' => ['red', 'blue']],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<'HTML'
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" name="TextForm[job]" value>
                HTML,
                [
                    'useContainer' => false,
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
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
                new PureInputData(
                    name: 'TextForm[name]',
                    value: '',
                    label: 'Name',
                    hint: 'Input your full name.',
                    placeholder: 'Typed your name here',
                    id: 'textform-name',
                    validationErrors: ['Value cannot be blank.'],
                ),
            ],
            [
                <<<'HTML'
                <div>
                <label>Job</label>
                <input type="text" class="form-control" name="TextForm[job]" value>
                </div>
                HTML,
                [
                    'setInputId' => false,
                    'inputAttributes' => ['class' => 'form-control'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
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
                        'setFor()' => [false],
                    ],
                    'hintConfig' => [
                        'attributes()' => [['class' => 'info']],
                    ],
                    'errorConfig' => [
                        'attributes()' => [['class' => 'red']],
                    ],
                ],
                new PureInputData(
                    name: 'TextForm[name]',
                    value: '',
                    label: 'Name',
                    hint: 'Input your full name.',
                    placeholder: 'Typed your name here',
                    id: 'textform-name',
                    validationErrors: ['Value cannot be blank.'],
                ),
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
                new PureInputData(
                    name: 'TextForm[name]',
                    value: '',
                    label: 'Name',
                    hint: 'Input your full name.',
                    placeholder: 'Typed your name here',
                    id: 'textform-name',
                    validationErrors: ['Value cannot be blank.'],
                ),
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
                new PureInputData(
                    name: 'TextForm[name]',
                    value: '',
                    label: 'Name',
                    hint: 'Input your full name.',
                    placeholder: 'Typed your name here',
                    id: 'textform-name',
                    validationErrors: ['Value cannot be blank.'],
                ),
            ],
            [
                <<<HTML
                <div class="main-wrapper">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" class="test-class" name="TextForm[job]" value data-type="input-text">
                </div>
                HTML,
                [
                    'containerTag' => 'section',
                    'containerAttributes' => ['class' => 'wrapper'],
                    'inputAttributes' => ['data-type' => 'field'],
                    'inputClass' => ['test-class'],
                    'fieldConfigs' => [
                        Text::class => [
                            'containerTag()' => ['div'],
                            'containerAttributes()' => [['class' => 'main-wrapper']],
                            'inputAttributes()' => [['data-type' => 'input-text']],
                        ],
                    ],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
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
                    'containerAttributes' => ['class' => 'wrapper'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                    validationErrors: [],
                ),
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
                    'containerAttributes' => ['class' => 'wrapper'],
                ],
                new PureInputData(
                    name: 'TextForm[company]',
                    value: '',
                    label: 'Company',
                    id: 'textform-company',
                    validationErrors: ['Value cannot be blank.'],
                ),
            ],
            [
                <<<'HTML'
                <div class="wrapper">
                <label for="textform-job">Job</label>
                <input type="text" id="textform-job" class="valid" name="TextForm[job]" value>
                </div>
                HTML,
                [
                    'inputValidClass' => 'valid',
                    'containerAttributes' => ['class' => 'wrapper'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                    validationErrors: [],
                ),
            ],
            [
                <<<'HTML'
                <div class="wrapper">
                <label for="textform-company">Company</label>
                <input type="text" id="textform-company" class="invalid" name="TextForm[company]" value>
                <div>Value cannot be blank.</div>
                </div>
                HTML,
                [
                    'inputInvalidClass' => 'invalid',
                    'containerAttributes' => ['class' => 'wrapper'],
                ],
                new PureInputData(
                    name: 'TextForm[company]',
                    value: '',
                    label: 'Company',
                    id: 'textform-company',
                    validationErrors: ['Value cannot be blank.'],
                ),
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-job">Job</label>
                <div class="control"><input type="text" id="textform-job" name="TextForm[job]" value></div>
                </div>
                HTML,
                [
                    'inputContainerTag' => 'div',
                    'inputContainerAttributes' => ['class' => 'control'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-job">Job</label>
                <div class="control"><input type="text" id="textform-job" name="TextForm[job]" value></div>
                </div>
                HTML,
                [
                    'inputContainerTag' => 'div',
                    'inputContainerClass' => 'control',
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
            [
                <<<'HTML'
                <div>
                <label for="textform-job">Job</label>
                <div class="control red"><input type="text" id="textform-job" name="TextForm[job]" value></div>
                </div>
                HTML,
                [
                    'inputContainerTag' => 'div',
                    'inputContainerClass' => ['control', 'red'],
                ],
                new PureInputData(
                    name: 'TextForm[job]',
                    value: '',
                    label: 'Job',
                    id: 'textform-job',
                ),
            ],
        ];
    }

    #[DataProvider('dataText')]
    public function testText(
        string $expected,
        array $factoryParameters,
        PureInputData $inputData,
        ?array $enricherResult = null,
    ): void {
        $this->initializeThemeContainer($factoryParameters, $enricherResult);

        $result = Text::widget()
            ->inputData($inputData)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataTextWithNotDefaultTheme(): array
    {
        return [
            'labelConfig' => [
                <<<'HTML'
                <div>
                <label class="red">Job</label>
                <input type="text" name="job" value>
                </div>
                HTML,
                [
                    'labelConfig' => ['class()' => ['red']],
                ],
                new PureInputData(
                    name: 'job',
                    value: '',
                    label: 'Job',
                ),
            ],
            'hintConfig' => [
                <<<'HTML'
                <div>
                <input type="text" name="job" value>
                <div class="red">Job</div>
                </div>
                HTML,
                [
                    'hintConfig' => ['class()' => ['red']],
                ],
                new PureInputData(
                    name: 'job',
                    value: '',
                    hint: 'Job',
                ),
            ],
            'errorConfig' => [
                <<<'HTML'
                <div>
                <input type="text" name="job" value>
                <div class="red">Error</div>
                </div>
                HTML,
                [
                    'errorConfig' => ['class()' => ['red']],
                ],
                new PureInputData(
                    name: 'job',
                    value: '',
                    validationErrors: ['Error'],
                ),
            ],
        ];
    }

    #[DataProvider('dataTextWithNotDefaultTheme')]
    public function testTextWithNotDefaultTheme(
        string $expected,
        array $factoryParameters,
        PureInputData $inputData,
    ): void {
        ThemeContainer::initialize(
            ['default' => [], 'custom-theme' => $factoryParameters],
            defaultConfig: 'default',
        );

        $result = Text::widget(theme: 'custom-theme')
            ->inputData($inputData)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testTextWithCustomTheme(): void
    {
        ThemeContainer::initialize([
            'custom-theme' => [
                'inputContainerTag' => 'div',
                'inputContainerClass' => ['control', 'red'],
            ],
        ]);

        $inputData = new PureInputData(
            id: 'textform-job',
            label: 'Job',
            name: 'TextForm[job]',
            value: '',
        );

        $result = Text::widget(theme: 'custom-theme')
            ->inputData($inputData)
            ->render();

        $this->assertSame(
            <<<'HTML'
                <div>
                <label for="textform-job">Job</label>
                <div class="control red"><input type="text" id="textform-job" name="TextForm[job]" value></div>
                </div>
                HTML,
            $result
        );
    }

    public static function dataFieldSet(): array
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

    #[DataProvider('dataFieldSet')]
    public function testFieldSet(string $expected, array $factoryParameters): void
    {
        $this->initializeThemeContainer($factoryParameters);

        $result = Fieldset::widget()->render();

        $this->assertSame($expected, $result);
    }

    public function testFieldSetWithOverrideTemplateBeginAndTemplateEnd(): void
    {
        $this->initializeThemeContainer([
            'templateBegin' => "before\n{input}",
            'templateEnd' => "{input}\nafter",
        ]);

        $field = Fieldset::widget();

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

    public static function dataLabel(): array
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
                        'useInputId()' => [false],
                    ],
                ],
            ],
            'set-for-attribute-false' => [
                <<<'HTML'
                <label>Job</label>
                HTML,
                [
                    'labelConfig' => [
                        'setFor()' => [false],
                    ],
                ],
            ],
            'label-class-string' => [
                '<label class="red" for="textform-job">Job</label>',
                ['labelClass' => 'red'],
            ],
            'label-class-array' => [
                '<label class="red blue" for="textform-job">Job</label>',
                ['labelClass' => ['red', 'blue']],
            ],
            'label-class-null' => [
                '<label for="textform-job">Job</label>',
                ['labelClass' => null],
            ],
        ];
    }

    #[DataProvider('dataLabel')]
    public function testLabel(string $expected, array $factoryParameters): void
    {
        $this->initializeThemeContainer($factoryParameters);

        $result = Label::widget()
            ->inputData(new PureInputData(id: 'textform-job', label: 'Job'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataHint(): array
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
            'hint-class-string' => [
                '<div class="red">Input your full name.</div>',
                ['hintClass' => 'red'],
            ],
            'hint-class-array' => [
                '<div class="red blue">Input your full name.</div>',
                ['hintClass' => ['red', 'blue']],
            ],
            'hint-class-null' => [
                '<div>Input your full name.</div>',
                ['hintClass' => null],
            ],
        ];
    }

    #[DataProvider('dataHint')]
    public function testHint(string $expected, array $factoryParameters): void
    {
        $this->initializeThemeContainer($factoryParameters);

        $result = Hint::widget()
            ->content('Input your full name.')
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataError(): array
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
            'error-class-string' => [
                '<div class="red">Value cannot be blank.</div>',
                ['errorClass' => 'red'],
            ],
            'error-class-array' => [
                '<div class="red blue">Value cannot be blank.</div>',
                ['errorClass' => ['red', 'blue']],
            ],
            'error-class-null' => [
                '<div>Value cannot be blank.</div>',
                ['errorClass' => null],
            ],
        ];
    }

    #[DataProvider('dataError')]
    public function testError(string $expected, array $factoryParameters): void
    {
        $this->initializeThemeContainer($factoryParameters);

        $result = Error::widget()
            ->message('Value cannot be blank.')
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testNotExistTheme(): void
    {
        $this->initializeThemeContainer();

        $html = Text::widget(theme: 'not-exist')->render();

        $this->assertSame(
            <<<HTML
            <div>
            <input type="text">
            </div>
            HTML,
            $html
        );
    }

    private function initializeThemeContainer(array $parameters = [], ?array $enricherResult = null): void
    {
        ThemeContainer::initialize(
            ['default' => $parameters],
            defaultConfig: 'default',
            validationRulesEnricher: new StubValidationRulesEnricher($enricherResult),
        );
    }
}
