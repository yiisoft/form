<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;

final class FieldImageTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAlt(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" alt="Submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image(['alt()' => ['Submit']])
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->autofocus()
            ->image()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->disabled()
            ->image()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="test-id" name="w1-image">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->id('test-id')
            ->image()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHeight(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" height="20">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image(['height()' => ['20']])
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image()
            ->name('test-name')
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSrc(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" src="img_submit.gif">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image(['src()' => ['img_submit.gif']])
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image()
            ->tabindex(1)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWidth(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image" name="w1-image" width="20px">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image(['width()' => ['20px']])
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" name="w1-image">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->id(null)
            ->image()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="image" id="w1-image">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->image()
            ->name(null)
            ->render());
    }
}
