<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModel;
use Yiisoft\Form\Tests\TestSupport\Form\LoadMultipleForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

require __DIR__ . '/TestSupport/Form/NonNamespacedForm.php';

final class MultipleFormModelTest extends TestCase
{
    use TestTrait;

    /*
    public function testLoadMultiple(): void
    {
        $form = new LoadMultipleForm();
        $formName = $form->getFormName();

        $data = [
            $formName => [
                [
                    'attribute1' => 'b5HhRBieacLZki2H',
                    'attribute2' => 'eu3VXDpwvvyoahwNAjPmjYV7PgCEZ9pTAWAf',
                    'attribute3' => 'ym8ES3nDhxN4',
                    'attribute4' => 'CupHZ4Ljzeym8q8Hmu8',
                ],
                [
                    'attribute1' => 's8rcuBHjZ4MXEkGU2YToFGz9XTADyg4j8ibZ',
                    'attribute2' => 'eDruLPmPkALRE7qUyhDapJZTTnE2A',
                    'attribute3' => '2f6ot3S5f8T7tNm5',
                    'attribute4' => 'rYNM4jfZ7kFCN6A4i7apSMFPxq',
                ],
                [
                    'attribute1' => '64brF469aKhY',
                    'attribute2' => 'J3BSpg4rVY6mVq5cTu',
                    'attribute3' => 'h8VpgtLbwz6WyUhCLgFgg5wkdqtmmBy5HE5U',
                    'attribute4' => '6yDHpqf357fEcKsYeJz',
                ],
                [
                    'attribute1' => 'Mqx6LL78mysscsaHLhSSM46Uht46tdAvaejs',
                    'attribute2' => '7PqV94mzGL2tP',
                    'attribute3' => 'K7ZvDNkEv4cwsPpTEpBsJEu7',
                    'attribute4' => 'CtsAPJQnUUCgKFGfvQ6C',
                ],
                [
                    'attribute1' => '49xuodLX3XPb9LueLSUq7GbhdRa3aw',
                    'attribute2' => '2MHboYwmBLXyWYPJoXeoKLjVS',
                    'attribute3' => 'p6AJiq3NQsW4dwcKAz',
                    'attribute4' => 'JetmdpKiVXMYBs3CLvQb7qEvyQDFXELDAeCb',
                ],
            ],
        ];

        $this->assertTrue($form->loadMultiple($data));

        $models = $form->getModels();

        $this->assertCount(count($data[$formName]), $models);

        foreach ($models as $i => $model) {
            $this->assertInstanceOf(LoadMultipleForm::class, $model);
            $this->assertSame($data[$formName][$i], $model->getData());
        }
    }
    */

    public function testLoadFailedForm(): void
    {
        $form = new LoadMultipleForm();
        $formName = $form->getFormName();

        $data = [
            $formName => [
                [
                    'attribute1' => 'b5HhRBieacLZki2H',
                    'attribute2' => 'eu3VXDpwvvyoahwNAjPmjYV7PgCEZ9pTAWAf',
                    'attribute3' => 'ym8ES3nDhxN4',
                    'attribute4' => 'CupHZ4Ljzeym8q8Hmu8',
                ],
                [
                    'attribute1' => 's8rcuBHjZ4MXEkGU2YToFGz9XTADyg4j8ibZ',
                    'attribute2' => 'eDruLPmPkALRE7qUyhDapJZTTnE2A',
                    'attribute3' => '2f6ot3S5f8T7tNm5',
                    'attribute4' => 'rYNM4jfZ7kFCN6A4i7apSMFPxq',
                ],
                [
                    'attribute1' => '64brF469aKhY',
                    'attribute2' => 'J3BSpg4rVY6mVq5cTu',
                    'attribute3' => 'h8VpgtLbwz6WyUhCLgFgg5wkdqtmmBy5HE5U',
                    'attribute4' => '6yDHpqf357fEcKsYeJz',
                ],
                [
                    // empty data to cause loading failure
                ],
                [
                    'attribute1' => '49xuodLX3XPb9LueLSUq7GbhdRa3aw',
                    'attribute2' => '2MHboYwmBLXyWYPJoXeoKLjVS',
                    'attribute3' => 'p6AJiq3NQsW4dwcKAz',
                    'attribute4' => 'JetmdpKiVXMYBs3CLvQb7qEvyQDFXELDAeCb',
                ],
            ],
        ];

        $this->assertFalse($form->loadMultiple($data));

        $models = $form->getModels();

        $this->assertCount(count($data[$formName]), $models);

        foreach ($models as $i => $model) {
            if (empty($data[$formName][$i])) {
                $this->assertFalse($model);
            } else {
                $this->assertInstanceOf(LoadMultipleForm::class, $model);
                $this->assertSame($data[$formName][$i], $model->getData());
            }
        }
    }
}