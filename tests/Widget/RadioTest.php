<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Radio;

final class RadioTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnClosedByLabelWithFalse(): void
    {
        $expected = <<<'HTML'
        <input type="radio" id="typeform-int" name="TypeForm[int]" value="1">
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->for(new TypeForm(), 'int')->enclosedByLabel(false)->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $radio = Radio::widget();
        $this->assertNotSame($radio, $radio->enclosedByLabel(false));
        $this->assertNotSame($radio, $radio->label(''));
        $this->assertNotSame($radio, $radio->labelAttributes());
        $this->assertNotSame($radio, $radio->uncheckValue(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<'HTML'
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        HTML;
        $html = Radio::widget()
            ->for(new TypeForm(), 'int')
            ->label('Label:')
            ->labelAttributes(['class' => 'test-class'])
            ->value(1)
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for(new TypeForm(), 'int')->value(1)->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->for(new TypeForm(), 'int')->uncheckValue(0)->value(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Radio::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value bool `false`.
        $formModel->setAttribute('bool', false);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'bool')->value(false)->render());

        // Value bool `true`.
        $formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'bool')->value(true)->render());

        // Value int `0`.
        $formModel->setAttribute('int', 0);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'int')->value(0)->render());

        // Value int `1`.
        $formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'int')->value(1)->render());

        // Value string `inactive`.
        $formModel->setAttribute('string', 'inactive');
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive" checked> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'string')->value('inactive')->render());

        // Value string `active`.
        $formModel->setAttribute('string', 'active');
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'string')->value('active')->render());

        // Value `null`.
        $formModel->setAttribute('string', 'null');
        $expected = <<<'HTML'
        <label><input type="radio" id="typeform-string" name="TypeForm[string]"> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'string')->value(null)->render());
    }
}
