<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\Tests\Support\Form\TextareaForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\YiiValidatorRulesEnrichmenter;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TextareaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize(
            validationRulesEnrichmenter: new YiiValidatorRulesEnrichmenter()
        );
    }

    public function testTextarea(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textareaform-desc">Description</label>
            <textarea id="textareaform-desc" name="TextareaForm[desc]"></textarea>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->maxlength(100)
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" maxlength="100"></textarea>',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->minlength(7)
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" minlength="7"></textarea>',
            $result
        );
    }

    public function testDirname(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->dirname('test')
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" dirname="test"></textarea>',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->readonly()
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" readonly></textarea>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" required></textarea>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" disabled></textarea>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" aria-describedby="hint"></textarea>',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" aria-label="test"></textarea>',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" autofocus></textarea>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" tabindex="5"></textarea>',
            $result
        );
    }

    public function testCols(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->cols(12)
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" cols="12"></textarea>',
            $result
        );
    }

    public function testRows(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->rows(7)
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" rows="7"></textarea>',
            $result
        );
    }

    public function testWrap(): void
    {
        $result = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'desc'))
            ->hideLabel()
            ->useContainer(false)
            ->wrap('hard')
            ->render();

        $this->assertSame(
            '<textarea id="textareaform-desc" name="TextareaForm[desc]" wrap="hard"></textarea>',
            $result
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Textarea field requires a string or null value.');
        $widget->render();
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<textarea id="textareaform-bio" name="TextareaForm[bio]" required></textarea>',
                'bio',
            ],
            'has-length' => [
                '<textarea id="textareaform-shortdesc" name="TextareaForm[shortdesc]" maxlength="199" minlength="10"></textarea>',
                'shortdesc',
            ],
            'required-with-when' => [
                '<textarea id="textareaform-requiredwhen" name="TextareaForm[requiredWhen]"></textarea>',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Textarea::widget()
            ->inputData(new FormModelInputData(new TextareaForm(), $attribute))
            ->hideLabel()
            ->useContainer(false)
            ->enrichmentFromRules(true);

        $this->assertSame($expected, $field->render());
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
    }
}
