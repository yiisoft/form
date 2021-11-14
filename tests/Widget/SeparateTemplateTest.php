<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\CheckboxList;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Widget\WidgetFactory;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Form\Widget\Text;
use Yiisoft\Form\Widget\Label;
use Yiisoft\Form\Widget\SubmitButton;
use Yiisoft\Form\Widget\Number;
use Yiisoft\Form\Widget\Url;
use Yiisoft\Form\Widget\Telephone;

final class SeparateTemplateTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }

    public function testSeparateTemplates(): void
    {
        $field = Field::widget()
            ->template('{label}<div class="col-sm-10">{input}</div>')
            ->widgetTemplates([
                CheckboxList::class => '<div class="col-sm-10">{input}</div>',
                SubmitButton::class => '<div class="col-sm-10 offset-sm-2">{input}</div>',
            ]);

        $this->assertEqualsWithoutLE(
            '<div>' .
                Label::widget()->config($this->formModel, 'toCamelCase')->render() .
                '<div class="col-sm-10">' .
                     Text::widget()->config($this->formModel, 'toCamelCase')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'toCamelCase')->text()->render())
        );

        $this->assertEqualsWithoutLE(
            '<div>' .
                '<div class="col-sm-10">' .
                    str_replace("\n", '', CheckboxList::widget()->config($this->formModel, 'array')->render()) .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'array')->checkboxList()->render())
        );

        $this->assertEqualsWithoutLE(
            '<div>' .
                '<div class="col-sm-10 offset-sm-2">' .
                    SubmitButton::widget()->id('test-id')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->submitButton(['id' => 'test-id'])->render())
        );
    }

    public function testSeparateDropTemplates(): void
    {
        $field = Field::widget()
            ->template('{label}<div class="col-sm-10">{input}</div>')
            ->widgetTemplates([
                Number::class => '<div class="custom-number-class">{input}</div>',
                Url::class => '<div class="custom-url-class">{input}</div>',
                Telephone::class => '<div class="custom-telephone-class">{input}</div>',
            ]);

        $this->assertEqualsWithoutLE(
            '<div>' .
                '<div class="custom-number-class">' .
                     Number::widget()->config($this->formModel, 'number')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'number')->number()->render())
        );

        $field = $field->widgetTemplate(Number::class, null);

        $this->assertEqualsWithoutLE(
            '<div>' .
                Label::widget()->config($this->formModel, 'number')->render() .
                '<div class="col-sm-10">' .
                     Number::widget()->config($this->formModel, 'number')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'number')->number()->render())
        );

        $this->assertEqualsWithoutLE(
            '<div>' .
                '<div class="custom-url-class">' .
                    Url::widget()->config($this->formModel, 'toCamelCase')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'toCamelCase')->url()->render())
        );

        $field = $field->widgetTemplate(Url::class, null);

        $this->assertEqualsWithoutLE(
            '<div>' .
                Label::widget()->config($this->formModel, 'toCamelCase')->render() .
                '<div class="col-sm-10">' .
                    Url::widget()->config($this->formModel, 'toCamelCase')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'toCamelCase')->url()->render())
        );

        $this->assertEqualsWithoutLE(
            '<div>' .
                '<div class="custom-telephone-class">' .
                    Telephone::widget()->config($this->formModel, 'toCamelCase')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'toCamelCase')->telephone()->render())
        );

        $field = $field->widgetTemplate(Telephone::class, null);

        $this->assertEqualsWithoutLE(
            '<div>' .
                Label::widget()->config($this->formModel, 'toCamelCase')->render() .
                '<div class="col-sm-10">' .
                    Telephone::widget()->config($this->formModel, 'toCamelCase')->render() .
                '</div>' .
            '</div>',
            str_replace("\n", '', $field->config($this->formModel, 'toCamelCase')->telephone()->render())
        );
    }
}
