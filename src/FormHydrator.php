<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Vjik\InputHydrator\Hydrator;

use function is_array;

final class FormHydrator
{
    public function __construct(
        private Hydrator $hydrator,
    ) {
    }

    public function populate(FormModelInterface $model, mixed $data, array $map = [], bool $strict = false): bool
    {
        if (!is_array($data)) {
            return false;
        }

        $scope = $model->getFormName();
        if ($scope === '') {
            $hydrateData = $data;
        } else {
            if (!isset($data[$scope]) || !is_array($data[$scope])) {
                return false;
            }
            $hydrateData = $data[$scope];
        }

        $this->hydrator->populate($model, $hydrateData, $map, $strict);

        return true;
    }
}
