<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Label;

final class LabelTest extends TestCase
{
    public function testLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<label for="personalform-name">Name</label>
HTML;
        $html = Label::widget()
            ->config($data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testLabelOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<label class="customClass" for="personalform-name">Name</label>
HTML;
        $html = Label::widget()
            ->config($data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testLabelFor(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<label for="for-id">Name</label>
HTML;
        $html = Label::widget()
            ->config($data, 'name')
            ->for('for-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testLabelCustomLabel(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<label for="personalform-name">Firts Name:</label>
HTML;
        $html = Label::widget()
            ->config($data, 'name')
            ->label('Firts Name:')
            ->run();
        $this->assertEquals($expected, $html);
    }
}
