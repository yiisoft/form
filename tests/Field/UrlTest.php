<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Url;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\UrlForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class UrlTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
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
                '<input type="url" id="urlform-shop" name="UrlForm[shop]" value pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">',
                'shop',
            ],
            'url-regex' => [
                '<input type="url" id="urlform-beach" name="UrlForm[beach]" value pattern="\w+">',
                'beach',
            ],
            'regex-url' => [
                '<input type="url" id="urlform-beach2" name="UrlForm[beach2]" value pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">',
                'beach2',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules1(string $expected, string $attribute): void
    {
        $field = Url::widget()
            ->attribute(new UrlForm(), $attribute)
            ->hideLabel()
            ->enrichmentFromRules(true)
            ->useContainer(false);

        $this->assertSame($expected, $field->render());
    }
}
