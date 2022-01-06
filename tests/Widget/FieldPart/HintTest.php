<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\FieldPart;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeWithHintForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\FieldPart\Hint;

final class HintTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEncodeWithFalse(): void
    {
        $this->assertSame(
            '<div>Write&nbsp;your&nbsp;text.</div>',
            Hint::widget()
                ->for(new TypeWithHintForm(), 'login')
                ->encode(false)
                ->hint('Write&nbsp;your&nbsp;text.')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHint(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::widget()->for(new TypeWithHintForm(), 'login')->hint('Write your text.')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $hint = Hint::widget();
        $this->assertNotSame($hint, $hint->encode(false));
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<div>Please enter your login.</div>',
            Hint::widget()->for(new TypeWithHintForm(), 'login')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTag(): void
    {
        $this->assertSame(
            '<span>Please enter your login.</span>',
            Hint::widget()->for(new TypeWithHintForm(), 'login')->tag('span')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->for(new TypeWithHintForm(), 'login')->tag('')->render();
    }
}
