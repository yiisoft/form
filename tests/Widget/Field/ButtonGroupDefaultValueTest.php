<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;

final class ButtonGroupDefaultValueTest extends TestCase
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
        <input type="button" id="w1-button" class="btn btn-primary" name="w1-button" value="Submit">
        <input type="button" id="w2-button" class="btn btn-primary" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['class' => 'btn btn-primary']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <input type="button" id="w1-button" class="btn btn-success" name="w1-button" value="Submit">
        <input type="button" id="w2-button" class="btn btn-success" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['class' => 'btn btn-primary']]])
                ->defaultValues(['buttonGroup' => ['attributes' => ['class' => 'btn btn-success']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'container-class-definitions']]])
                ->defaultValues(
                    [
                        'buttonGroup' => [
                            'containerAttributes' => ['class' => 'container-class-widget'],
                        ],
                    ],
                )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definitions']])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
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
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definitions']])
                ->defaultValues(
                    [
                        'buttonGroup' => [
                            'containerClass' => 'container-class-widget',
                        ],
                    ],
                )
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefinitions(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['container()' => [false]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefaultValues(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<HTML
        <input type="button" id="w1-button" name="w1-button" value="Submit">
        <input type="button" id="w2-button" name="w2-button" value="Reset">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['container()' => [true]])
                ->defaultValues(['buttonGroup' => ['container' => false]])
                ->buttonGroup([['label' => 'Submit'], ['label' => 'Reset']])
                ->render(),
        );
    }
}
