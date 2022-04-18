<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\FieldsetForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldsetTest extends TestCase
{
    use AssertTrait;

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

        $this->assertStringContainsStringIgnoringLineEndings(
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

        $this->assertStringContainsStringIgnoringLineEndings(
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
}
