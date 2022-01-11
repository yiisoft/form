<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;

final class ButtonDefaultValueTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributesDefinitions(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['value' => 'Submit']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributesDefaultValues(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Ok">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['value' => 'Submit']]])
                ->defaultValues(['submit' => ['attributes' => ['value' => 'Ok']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributesDefinitions(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-definitions">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributesDefaultValues(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->defaultValues(['submit' => ['containerAttributes' => ['class' => 'container-class-widget']]])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClassDefinitions(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-definitions">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definitions']])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClassDefaultValues(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <div class="container-class-widget">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definitions']])
                ->defaultValues(['submit' => ['containerClass' => 'container-class-widget']])
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefinitions(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit">',
            Field::widget(['container()' => [false]])->submitButton()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefaultValues(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="submit" id="w1-submit" name="w1-submit">',
            Field::widget(['container()' => [true]])
                ->defaultValues(['submit' => ['container' => false]])
                ->submitButton()
                ->render(),
        );
    }
}
