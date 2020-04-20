<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\ErrorSummary;

final class ErrorSummaryTest extends TestCase
{
    public function dataProviderErrorSummary(): array
    {
        return [
            [
                'ok',
                [],
                '<div style="display:none"><p>Please fix the following errors:</p><ul></ul></div>',
            ],
            [
                'ok',
                ['header' => 'Custom header', 'footer' => 'Custom footer', 'style' => 'color: red'],
                '<div style="color: red; display:none">Custom header<ul></ul>Custom footer</div>',
            ],
            [
                str_repeat('x', 110),
                ['showAllErrors' => true],
                '<div><p>Please fix the following errors:</p><ul><li>This value should contain at most {max, number} {max, plural, one{character} other{characters}}.</li></ul></div>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderErrorSummary
     *
     * @param string $value
     * @param array $options
     * @param string $expected
     *
     * @throws InvalidConfigException
     */
    public function testErrorSummary(string $value, array $options, string $expected): void
    {
        $data = [
            'StubForm' => [
                'fieldString' => $value
            ]
        ];

        $form = new StubForm();

        $form->load($data);
        $form->validate();
        $created = ErrorSummary::widget()->data($form)->options($options)->run();

        $this->assertEqualsWithoutLE($expected, $created);
    }
}
