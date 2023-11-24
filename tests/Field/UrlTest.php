<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Field\Url;
use Yiisoft\Form\Tests\Support\Form\UrlForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class UrlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function tesBase(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'site'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="urlform-site">Your site</label>
            <input type="url" id="urlform-site" name="UrlForm[site]" value>
            <div>Enter your site URL.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->maxlength(95)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" maxlength="95">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMinlength(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->minlength(3)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" minlength="3">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testPattern(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->pattern('\w+')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" pattern="\w+">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReadonly(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->readonly()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" readonly>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->required()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->disabled()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->ariaDescribedBy('hint')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" aria-describedby="hint">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->ariaLabel('test')
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" aria-label="test">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->autofocus()
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" autofocus>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->tabIndex(5)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" tabindex="5">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $result = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'post'))
            ->size(99)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="url" id="urlform-post" name="UrlForm[post]" size="99">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<input type="url" id="urlform-company" name="UrlForm[company]" value required>',
                'company',
            ],
            'has-length' => [
                '<input type="url" id="urlform-home" name="UrlForm[home]" value maxlength="199" minlength="50">',
                'home',
            ],
            'regex' => [
                '<input type="url" id="urlform-code" name="UrlForm[code]" value pattern="\w+">',
                'code',
            ],
            'regex-not' => [
                '<input type="url" id="urlform-nocode" name="UrlForm[nocode]" value>',
                'nocode',
            ],
            'url' => [
                '<input type="url" id="urlform-shop" name="UrlForm[shop]" value pattern="^((?i)http|https):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">',
                'shop',
            ],
            'url-regex' => [
                '<input type="url" id="urlform-beach" name="UrlForm[beach]" value pattern="\w+">',
                'beach',
            ],
            'regex-url' => [
                '<input type="url" id="urlform-beach2" name="UrlForm[beach2]" value pattern="^((?i)http|https):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">',
                'beach2',
            ],
            'url-with-idn' => [
                '<input type="url" id="urlform-urlwithidn" name="UrlForm[urlWithIdn]" value>',
                'urlWithIdn',
            ],
            'regex-and-url-with-idn' => [
                '<input type="url" id="urlform-regexandurlwithidn" name="UrlForm[regexAndUrlWithIdn]" value pattern="\w+">',
                'regexAndUrlWithIdn',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), $attribute))
            ->hideLabel()
            ->enrichmentFromRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }

    public function testInvalidValue(): void
    {
        $widget = Url::widget()
            ->inputData(new FormModelInputData(new UrlForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('URL field requires a string or null value.');
        $widget->render();
    }

    public function testImmutability(): void
    {
        $field = Url::widget();

        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->pattern(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->size(null));
    }
}
