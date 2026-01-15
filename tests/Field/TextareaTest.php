<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\NullValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\RequiredValidationRulesEnricher;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\Theme\ThemeContainer;

final class TextareaTest extends TestCase
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
                <label for="test-id">Description</label>
                <textarea id="test-id" name="desc"></textarea>
                </div>
                HTML,
                new InputData('desc', id: 'test-id', label: 'Description'),
            ],
            'stringable-value' => [
                <<<HTML
                <div>
                <textarea name="desc">test</textarea>
                </div>
                HTML,
                new InputData('desc', new StringableObject('test')),
            ],
            'array-of-strings-value' => [
                <<<HTML
                <div>
                <textarea name="desc">a
                b
                c</textarea>
                </div>
                HTML,
                new InputData('desc', ['a', 'b', 'c']),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <textarea class="valid" name="desc"></textarea>
                </div>
                HTML,
                new InputData(name: 'desc', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <textarea name="desc"></textarea>
                </div>
                HTML,
                new InputData(name: 'desc', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
            'placeholder' => [
                <<<HTML
                <div>
                <textarea name="desc" placeholder="test"></textarea>
                </div>
                HTML,
                new InputData(name: 'desc', placeholder: 'test'),
            ],
            'value-with-newlines' => [
                <<<HTML
                <div>
                <textarea name="desc">


                one


                two


                </textarea>
                </div>
                HTML,
                new InputData('desc', "\n\n\none\n\n\ntwo\n\n\n"),
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testTextarea(string $expected, InputData $inputData, array $theme = []): void
    {
        ThemeContainer::initialize(
            configs: ['default' => $theme],
            defaultConfig: 'default',
        );

        $result = Textarea::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->maxlength(100)
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" maxlength="100"></textarea>',
            $result,
        );
    }

    public function testMinlength(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->minlength(7)
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" minlength="7"></textarea>',
            $result,
        );
    }

    public function testDirname(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->dirname('test')
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" dirname="test"></textarea>',
            $result,
        );
    }

    public function testReadonly(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->readonly()
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" readonly></textarea>',
            $result,
        );
    }

    public function testRequired(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" required></textarea>',
            $result,
        );
    }

    public function testDisabled(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" disabled></textarea>',
            $result,
        );
    }

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                '<textarea name="TextareaForm[desc]" aria-describedby="hint"></textarea>',
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                '<textarea name="TextareaForm[desc]" aria-describedby="hint1 hint2"></textarea>',
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                '<textarea name="TextareaForm[desc]" aria-describedby="hint1 hint2 hint3"></textarea>',
            ],
            'only null' => [
                [null, null],
                '<textarea name="TextareaForm[desc]"></textarea>',
            ],
            'empty string' => [
                [''],
                '<textarea name="TextareaForm[desc]" aria-describedby></textarea>',
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" aria-label="test"></textarea>',
            $result,
        );
    }

    public function testAutofocus(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" autofocus></textarea>',
            $result,
        );
    }

    public function testTabIndex(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" tabindex="5"></textarea>',
            $result,
        );
    }

    public function testCols(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->cols(12)
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" cols="12"></textarea>',
            $result,
        );
    }

    public function testRows(): void
    {
        $result = Textarea::widget()
            ->name('TextareaForm[desc]')
            ->hideLabel()
            ->useContainer(false)
            ->rows(7)
            ->render();

        $this->assertSame(
            '<textarea name="TextareaForm[desc]" rows="7"></textarea>',
            $result,
        );
    }

    public function testWrap(): void
    {
        $result = Textarea::widget()
            ->name('desc')
            ->hideLabel()
            ->useContainer(false)
            ->wrap('hard')
            ->render();

        $this->assertSame(
            '<textarea name="desc" wrap="hard"></textarea>',
            $result,
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Textarea::widget()->value(7);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Textarea field requires a string, a stringable object, an array of strings or null value.',
        );
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        $html = Textarea::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <textarea data-test="1"></textarea>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesEnabledWithProvidedRules(): void
    {
        $actualHtml = Textarea::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new RequiredValidationRulesEnricher())
            ->inputData(new InputData(validationRules: [['required']]))
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <textarea required></textarea>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithNullProcessResult(): void
    {
        $actualHtml = Textarea::widget()
            ->enrichFromValidationRules()
            ->validationRulesEnricher(new NullValidationRulesEnricher())
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <textarea></textarea>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesEnabledWithoutEnricher(): void
    {
        $actualHtml = Textarea::widget()
            ->enrichFromValidationRules()
            ->render();
        $expectedHtml = <<<HTML
            <div>
            <textarea></textarea>
            </div>
            HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        $html = Textarea::widget()
            ->validationRulesEnricher(
                new StubValidationRulesEnricher([
                    'inputAttributes' => ['data-test' => 1],
                ]),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <textarea></textarea>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

        $result = Textarea::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <textarea class="invalid" name="company"></textarea>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Textarea::widget();

        $this->assertNotSame($field, $field->maxlength(null));
        $this->assertNotSame($field, $field->minlength(null));
        $this->assertNotSame($field, $field->dirname(null));
        $this->assertNotSame($field, $field->readonly());
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->cols(null));
        $this->assertNotSame($field, $field->rows(null));
        $this->assertNotSame($field, $field->wrap(null));
        $this->assertNotSame($field, $field->enrichFromValidationRules());
        $this->assertNotSame($field, $field->validationRulesEnricher(null));
    }
}
