<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\File;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
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
                <input name="avatar" id="id-test" type="file">
                </div>
                HTML,
                new InputData(name: 'avatar', id: 'id-test', label: 'Avatar'),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input name="avatar" class="valid" type="file">
                </div>
                HTML,
                new InputData(name: 'avatar', value: '', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input name="avatar" type="file">
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
            '<input name="avatar" accept=".png,.jpg" type="file">',
            $result,
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
            '<input name="avatar" multiple type="file">',
            $result,
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
            '<input name="avatar" required type="file">',
            $result,
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
            '<input name="avatar" disabled type="file">',
            $result,
        );
    }

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                '<input name="avatar" aria-describedby="hint" type="file">',
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                '<input name="avatar" aria-describedby="hint1 hint2" type="file">',
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                '<input name="avatar" aria-describedby="hint1 hint2 hint3" type="file">',
            ],
            'only null' => [
                [null, null],
                '<input name="avatar" type="file">',
            ],
            'empty string' => [
                [''],
                '<input name="avatar" aria-describedby type="file">',
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
            '<input name="avatar" aria-label="test" type="file">',
            $result,
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
            '<input name="avatar" tabindex="3" type="file">',
            $result,
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
            <input type="hidden" name="avatar" value="0"><input name="avatar" type="file">
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
            <input type="hidden" name="avatar" value="0" disabled><input name="avatar" disabled type="file">
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
            <input type="hidden" name="avatar" value="0" form="CreatePost"><input name="avatar" form="CreatePost" type="file">
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
            <input type="hidden" name="avatar" value="0" data-key="100" id="TEST"><input name="avatar" type="file">
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
            <input type="hidden" name="avatar" value="0" id="TEST"><input name="avatar" type="file">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = File::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <input data-test="1" type="file">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = File::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input required type="file">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = File::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="file">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = File::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <input type="file">
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = File::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

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
            <input name="company" class="invalid" type="file">
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
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
