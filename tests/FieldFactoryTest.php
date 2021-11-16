<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Factory\Factory;
use Yiisoft\Form\FieldFactory;
use Yiisoft\Form\FieldFactoryConfig;
use Yiisoft\Form\Tests\TestSupport\AssertTrait;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Widget\WidgetFactory;

final class FieldFactoryTest extends TestCase
{
    use AssertTrait;

    public function dataInputText(): array
    {
        return [
            [
                'string',
                [],
                <<<'HTML'
                <div>
                <label for="typeform-string">String</label>
                <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
                <div>Write your text string.</div>
                </div>
                HTML
            ],
            [
                'string',
                [
                    'template()' => ["{hint}\n{error}\n{input}\n{label}"],
                ],
                <<<'HTML'
                <div>
                <div>Write your text string.</div>
                <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
                <label for="typeform-string">String</label>
                </div>
                HTML
            ],
            [
                'string',
                [
                    'setInputIdAttribute()' => [false],
                ],
                <<<'HTML'
                <div>
                <label>String</label>
                <input type="text" name="TypeForm[string]" value placeholder="Typed your text string.">
                <div>Write your text string.</div>
                </div>
                HTML
            ],
            [
                'string',
                [
                    'template()' => ["{hint}\n{error}\n{input}\n{label}"],
                    'inputTextConfig()' => [
                        [
                            'template()' => ['{input}'],
                        ],
                    ],
                ],
                <<<'HTML'
                <div>
                <input type="text" id="typeform-string" name="TypeForm[string]" value placeholder="Typed your text string.">
                </div>
                HTML
            ],
        ];
    }

    /**
     * @dataProvider dataInputText
     */
    public function testInputText(string $attribute, array $config, string $expected): void
    {
        $field = $this->createFieldFactory($config);

        $result = $field->inputText(new TypeForm(), $attribute)->render();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    private function createFieldFactory(array $config = []): FieldFactory
    {
        WidgetFactory::initialize();

        $factory = new Factory(null, [FieldFactoryConfig::class => $config]);

        return new FieldFactory($factory->create(FieldFactoryConfig::class));
    }
}
