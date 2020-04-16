<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\ErrorSummaryForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class ErrorSummaryFormTest extends TestCase
{
    public function errorSummaryDataProvider(): array
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
     * @dataProvider errorSummaryDataProvider
     *
     * @param string $value
     * @param array $options
     * @param string $expectedHtml
     */
    public function testErrorSummaryForm(string $value, array $options, string $expectedHtml): void
    {
        $data = [
            'StubForm' => [
                'fieldString' => $value
            ]
        ];

        $form = new StubForm();

        $form->load($data);
        $form->validate();

        $this->assertEqualsWithoutLE($expectedHtml, ErrorSummaryForm::create($form, $options));
    }
}
