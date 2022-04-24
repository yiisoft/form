<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Tests\Support\Form\FieldsetForm;
use Yiisoft\Html\Tag\Legend;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldsetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $form = new FieldsetForm();

        $result = Fieldset::widget()->begin()
            . Field::text($form, 'firstName')->useContainer(false)
            . "\n"
            . Field::text($form, 'lastName')->useContainer(false)
            . Fieldset::end();

        $this->assertSame(
            <<<HTML
            <div>
            <fieldset>
            <label for="fieldsetform-firstname">First name</label>
            <input type="text" id="fieldsetform-firstname" name="FieldsetForm[firstName]" value>
            <label for="fieldsetform-lastname">Last name</label>
            <input type="text" id="fieldsetform-lastname" name="FieldsetForm[lastName]" value>
            </fieldset>
            </div>
            HTML,
            $result
        );
    }

    public function testContent(): void
    {
        $form = new FieldsetForm();

        $result = Fieldset::widget()
            ->content(
                Field::text($form, 'firstName')->useContainer(false),
                "\n",
                Field::text($form, 'lastName')->useContainer(false),
            )
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <fieldset>
            <label for="fieldsetform-firstname">First name</label>
            <input type="text" id="fieldsetform-firstname" name="FieldsetForm[firstName]" value>
            <label for="fieldsetform-lastname">Last name</label>
            <input type="text" id="fieldsetform-lastname" name="FieldsetForm[lastName]" value>
            </fieldset>
            </div>
            HTML,
            $result
        );
    }

    public function testLegend(): void
    {
        $result = Fieldset::widget()
            ->legend('test')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset>
            <legend>test</legend>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testLegendTag(): void
    {
        $result = Fieldset::widget()
            ->legendTag(Legend::tag()->content('test'))
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset>
            <legend>test</legend>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Fieldset::widget()
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset disabled>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = Fieldset::widget()
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset form="CreatePost">
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testName(): void
    {
        $result = Fieldset::widget()
            ->name('test')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset name="test">
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Fieldset::widget();

        $this->assertNotSame($field, $field->legend(null));
        $this->assertNotSame($field, $field->legendTag(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->name(null));
    }
}
