<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\File;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class FileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'base' => [
                <<<HTML
                <div>
                <label for="id-test">Avatar</label>
                <input type="file" id="id-test" name="avatar">
                </div>
                HTML,
                new InputData(name: 'avatar', id: 'id-test', label: 'Avatar'),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="file" class="valid" name="avatar">
                </div>
                HTML,
                new InputData(name: 'avatar', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="file" name="avatar">
                </div>
                HTML,
                new InputData(name: 'avatar', value: '', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, InputData $inputData, array $theme = []): void
    {
        ThemeContainer::initialize(
            configs: ['default' => $theme],
            defaultConfig: 'default',
        );

        $result = File::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testAccept(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->accept('.png,.jpg')
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" accept=".png,.jpg">',
            $result
        );
    }

    public function testMultiple(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->multiple()
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" multiple>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" disabled>',
            $result
        );
    }

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                '<input type="file" name="avatar" aria-describedby="hint">',
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                '<input type="file" name="avatar" aria-describedby="hint1 hint2">',
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                '<input type="file" name="avatar" aria-describedby="hint1 hint2 hint3">',
            ],
            'only null' => [
                [null, null],
                '<input type="file" name="avatar">',
            ],
            'empty string' => [
                [''],
                '<input type="file" name="avatar" aria-describedby>',
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" aria-label="test">',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(3)
            ->render();

        $this->assertSame(
            '<input type="file" name="avatar" tabindex="3">',
            $result
        );
    }

    public function testUncheckValue(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->uncheckValue('0')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="avatar" value="0"><input type="file" name="avatar">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueDisabled(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->uncheckValue('0')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="avatar" value="0" disabled><input type="file" name="avatar" disabled>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueForm(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->uncheckValue('0')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="avatar" value="0" form="CreatePost"><input type="file" name="avatar" form="CreatePost">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddUncheckInputAttributes(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->uncheckValue('0')
            ->addUncheckInputAttributes(['data-key' => '100'])
            ->addUncheckInputAttributes(['id' => 'TEST'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" id="TEST" name="avatar" value="0" data-key="100"><input type="file" name="avatar">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckInputAttributes(): void
    {
        $result = File::widget()
            ->name('avatar')
            ->hideLabel()
            ->uncheckValue('0')
            ->uncheckInputAttributes(['data-key' => '100'])
            ->uncheckInputAttributes(['id' => 'TEST'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" id="TEST" name="avatar" value="0"><input type="file" name="avatar">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = File::widget()->enrichFromValidationRules()->render();

        $expected = <<<HTML
            <div>
            <input type="file" data-test="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        ThemeContainer::initialize(validationRulesEnricher: new RequiredValidationRulesEnricher());

        $actualHtml = File::widget()
            ->enrichFromValidationRules()
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="file" required>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = File::widget()->render();

        $expected = <<<HTML
            <div>
            <input type="file">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = File::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="file" class="invalid" name="company">
            <div>Value cannot be blank.</div>
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
