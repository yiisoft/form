<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftYiiValidatableForm\FormModelInputData;
use Yiisoft\Form\Field\File;
use Yiisoft\Form\Tests\Support\Form\FileForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiisoftYiiValidatableForm\ValidationRulesEnricher;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            validationRulesEnricher: new ValidationRulesEnricher()
        );
    }

    public function testBase(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="fileform-avatar">Avatar</label>
            <input type="file" id="fileform-avatar" name="FileForm[avatar]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAccept(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->accept('.png,.jpg')
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" accept=".png,.jpg">',
            $result
        );
    }

    public function testMultiple(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->multiple()
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" multiple>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" aria-label="test">',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(3)
            ->render();

        $this->assertSame(
            '<input type="file" id="fileform-avatar" name="FileForm[avatar]" tabindex="3">',
            $result
        );
    }

    public function testUncheckValue(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->uncheckValue('0')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="FileForm[avatar]" value="0"><input type="file" id="fileform-avatar" name="FileForm[avatar]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueDisabled(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->uncheckValue('0')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="FileForm[avatar]" value="0" disabled><input type="file" id="fileform-avatar" name="FileForm[avatar]" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueForm(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->uncheckValue('0')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="FileForm[avatar]" value="0" form="CreatePost"><input type="file" id="fileform-avatar" name="FileForm[avatar]" form="CreatePost">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddUncheckInputAttributes(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->uncheckValue('0')
            ->addUncheckInputAttributes(['data-key' => '100'])
            ->addUncheckInputAttributes(['id' => 'TEST'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" id="TEST" name="FileForm[avatar]" value="0" data-key="100"><input type="file" id="fileform-avatar" name="FileForm[avatar]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckInputAttributes(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'avatar'))
            ->hideLabel()
            ->uncheckValue('0')
            ->uncheckInputAttributes(['data-key' => '100'])
            ->uncheckInputAttributes(['id' => 'TEST'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" id="TEST" name="FileForm[avatar]" value="0"><input type="file" id="fileform-avatar" name="FileForm[avatar]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRules(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'image'))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="file" id="fileform-image" name="FileForm[image]" required>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesWithWhen(): void
    {
        $result = File::widget()
            ->inputData(new FormModelInputData(new FileForm(), 'photo'))
            ->hideLabel()
            ->enrichFromValidationRules(true)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="file" id="fileform-photo" name="FileForm[photo]">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = File::widget();

        $this->assertNotSame($field, $field->accept(null));
        $this->assertNotSame($field, $field->multiple());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->uncheckValue(null));
        $this->assertNotSame($field, $field->uncheckInputAttributes([]));
        $this->assertNotSame($field, $field->addUncheckInputAttributes([]));
    }
}
