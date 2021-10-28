<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Url;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class UrlTest extends TestCase
{
    private TypeForm $formModel;

    public function testImmutability(): void
    {
        $url = Url::widget();
        $this->assertNotSame($url, $url->maxlength(0));
        $this->assertNotSame($url, $url->minlength(0));
        $this->assertNotSame($url, $url->pattern(''));
        $this->assertNotSame($url, $url->placeholder(''));
        $this->assertNotSame($url, $url->size(0));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Url::widget()->config($this->formModel, 'string')->maxlength(10)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Url::widget()->config($this->formModel, 'string')->minlength(4)->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="url" id="typeform-string" name="TypeForm[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        HTML;
        $html = Url::widget()
            ->config($this->formModel, 'string')
            ->pattern("^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$")
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Url::widget()->config($this->formModel, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" size="20">',
            Url::widget()->config($this->formModel, 'string')->size(20)->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<input type="url" id="typeform-tonull" name="TypeForm[toNull]">',
            Url::widget()->config($this->formModel, 'toNull')->render(),
        );

        // value string 'https://yiiframework.com'
        $this->formModel->setAttribute('string', 'https://yiiframework.com');
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Url::widget()->config($this->formModel, 'int')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
