<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Image;
use Yiisoft\Html\Html;

final class ImageTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAlt(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" alt="Submit">',
            Image::widget()
                ->alt('Submit')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" autofocus>',
            Image::widget()
                ->autofocus()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" disabled>',
            Image::widget()
                ->disabled()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="id-test" name="w1-image">',
            Image::widget()
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $image = Image::widget();
        $this->assertNotSame($image, $image->alt(''));
        $this->assertNotSame($image, $image->height(''));
        $this->assertNotSame($image, $image->src(''));
        $this->assertNotSame($image, $image->width(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHeight(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" height="20">',
            Image::widget()
                ->height('20')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="name-test">',
            Image::widget()
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame('<input type="image" id="w1-image" name="w1-image">', Image::widget()->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSrc(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" src="img_submit.gif">',
            Image::widget()
                ->src('img_submit.gif')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertEqualsWithoutLE(
            '<input type="image" id="w1-image" name="w1-image" tabindex="1">',
            Image::widget()
                ->tabIndex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWidth(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image" name="w1-image" width="20%">',
            Image::widget()
                ->width('20%')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" name="w1-image">',
            Image::widget()
                ->id(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $this->assertSame(
            '<input type="image" id="w1-image">',
            Image::widget()
                ->name(null)
                ->render(),
        );
    }
}
