<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\Hint;

final class HintTest extends TestCase
{
    public function testHint(): void
    {
        $data = new PersonalForm();

        $expected = '<div>Write your first name.</div>';
        $html = Hint::widget()
            ->config($data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testHintOptions(): void
    {
        $data = new PersonalForm();

        $expected = '<div class="customClass">Write your first name.</div>';
        $html = Hint::widget()
            ->config($data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testHintCustomHint(): void
    {
        $data = new PersonalForm();

        $expected = '<div>Custom hint text.</div>';
        $html = Hint::widget()
            ->config($data, 'name')
            ->hint('Custom hint text.')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testHintTag(): void
    {
        $data = new PersonalForm();

        $expected = 'Write your first name.';
        $html = Hint::widget()
            ->config($data, 'name')
            ->tag()
            ->run();
        $this->assertEquals($expected, $html);

        $expected = '<span>Write your first name.</span>';
        $html = Hint::widget()
            ->config($data, 'name')
            ->tag('span')
            ->run();
        $this->assertEquals($expected, $html);
    }
}
