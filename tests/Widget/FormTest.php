<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Stringable;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FormTest extends TestCase
{
    use TestTrait;

    public function testAcceptCharset(): void
    {
        $this->assertSame(
            '<form method="POST" accept-charset="UTF-8">',
            Form::widget()->acceptCharset('UTF-8')->begin(),
        );
    }

    public function testAction(): void
    {
        $this->assertSame('<form action="/test" method="POST">', Form::widget()->action('/test')->begin());
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<form class="test-class" method="POST">',
            Form::widget()->attributes(['class' => 'test-class'])->begin(),
        );
    }

    public function testAutocomplete(): void
    {
        /** on value */
        $this->assertSame(
            '<form method="POST" autocomplete="on">',
            Form::widget()->autocomplete()->begin(),
        );
        /** off value */
        $this->assertSame(
            '<form method="POST" autocomplete="off">',
            Form::widget()->autocomplete(false)->begin(),
        );
    }

    public function testBegin(): void
    {
        $this->assertSame('<form method="POST">', Form::widget()->begin());
        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertSame(
            '<form action="/example" method="GET">' . PHP_EOL . implode(PHP_EOL, $hiddens),
            Form::widget()->action('/example?id=1&title=%3C')->method('GET')->begin()
        );
        $this->assertStringMatchesFormat(
            '<form action="/foo" method="GET">%A<input type="hidden" name="p" value>',
            Form::widget()->action('/foo?p')->method('GET')->begin(),
        );
    }

    /**
     * Data provider for {@see testCsrf()}.
     *
     * @return array test data
     */
    public function dataProviderCsrf(): array
    {
        return [
            // empty csrf name and token
            ['<form action="/foo" method="POST">', 'POST', '', ''],
            // empty csrf token
            ['<form action="/foo" method="POST">', 'POST', '', 'myToken'],
            // only csrf token value
            ['<form action="/foo" method="GET" _csrf="tokenCsrf">', 'GET', 'tokenCsrf', ''],
            // only csrf custom name
            [
                '<form action="/foo" method="POST" myToken="tokenCsrf">' . PHP_EOL .
                '<input type="hidden" name="myToken" value="tokenCsrf">',
                'POST',
                'tokenCsrf',
                'myToken',
            ],
            // object stringable
            [
                '<form action="/foo" method="POST" myToken="tokenCsrf">' . PHP_EOL .
                '<input type="hidden" name="myToken" value="tokenCsrf">',
                'POST',
                new class () {
                    public function __toString(): string
                    {
                        return 'tokenCsrf';
                    }
                },
                'myToken',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCsrf
     *
     * @param string $expected
     * @param string $method
     * @param string|Stringable $csrfToken
     * @param string $csrfName
     */
    public function testCsrf(string $expected, string $method, $csrfToken, string $csrfName): void
    {
        $formWidget = $csrfName !== ''
            ? Form::widget()->action('/foo')->csrf($csrfToken, $csrfName)->method($method)->begin()
            : Form::widget()->action('/foo')->csrf($csrfToken)->method($method)->begin();
        $this->assertSame($expected, $formWidget);
    }

    public function testCsrfExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('csrfToken must be a string or Stringable object.');
        Form::widget()->action('/foo')->csrf(1)->begin();
    }

    public function testCsrfExceptionNotStringable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('csrfToken must be a string or Stringable object.');
        Form::widget()->action('/foo')->csrf(new StdClass())->begin();
    }

    public function testEnd(): void
    {
        Form::widget()->begin();
        $this->assertSame('</form>', Form::end());
    }

    public function testEnctype(): void
    {
        $this->assertSame(
            '<form id="multipart/form-data" method="POST">',
            Form::widget()->enctype('multipart/form-data')->begin(),
        );
    }

    public function testId(): void
    {
        $this->assertSame('<form id="form-id" method="POST">', Form::widget()->id('form-id')->begin());
        $this->assertSame(
            '<form id="form-id" method="POST">',
            Form::widget()->attributes(['id' => 'form-id'])->begin(),
        );
    }

    public function testImmutability(): void
    {
        $form = Form::widget();
        $this->assertNotSame($form, $form->acceptCharset(''));
        $this->assertNotSame($form, $form->action(''));
        $this->assertNotSame($form, $form->attributes([]));
        $this->assertNotSame($form, $form->autocomplete());
        $this->assertNotSame($form, $form->csrf(''));
        $this->assertNotSame($form, $form->enctype(''));
        $this->assertNotSame($form, $form->id(''));
        $this->assertNotSame($form, $form->method(''));
        $this->assertNotSame($form, $form->noHtmlValidation());
        $this->assertNotSame($form, $form->target(''));
    }

    public function testMethod(): void
    {
        $this->assertSame('<form method="GET">', Form::widget()->method('get')->begin());
        $this->assertSame('<form method="POST">', Form::widget()->method('post')->begin());
    }

    public function testNoHtmlValidatation(): void
    {
        $this->assertSame('<form method="POST" novalidate>', Form::widget()->noHtmlValidation()->begin());
    }

    public function testTarget(): void
    {
        $this->assertSame('<form method="POST" target="_blank">', Form::widget()->target('_blank')->begin());
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
