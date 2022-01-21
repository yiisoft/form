<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Widget\Attribute\ChoiceAttributes;

final class ChoiceAttributeTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $choiceAttributes = $this->createWidget();
        $this->assertNotSame($choiceAttributes, $choiceAttributes->required(''));
    }

    private function createWidget(): ChoiceAttributes
    {
        return new class () extends ChoiceAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
