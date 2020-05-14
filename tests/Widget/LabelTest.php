<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\Label;

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
