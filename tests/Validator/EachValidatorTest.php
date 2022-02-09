<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Tests\TestSupport\Form\EachForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class EachValidatorTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEach(): void
    {
        $eachForm = new EachForm();
        $validator = $this->createValidatorMock();

        $eachForm->setAttribute('names', ['wilmer', 'pedrovitelek', 'samdark']);
        $result = $validator->validate($eachForm);

        $this->assertSame(
            ['names' => ['This value should contain at most {max, number} {max, plural, one{character} other{characters}}. pedrovitelek given.']],
            HtmlFormErrors::getAllErrors($eachForm),
        );
    }
}
