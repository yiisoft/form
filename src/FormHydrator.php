<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Vjik\InputValidation\ValidatingHydrator;

use function is_array;

final class FormHydrator
{
    public function __construct(
        private ValidatingHydrator $hydrator,
    ) {
    }

    public function populate(
        FormModel $model,
        mixed $data,
        array $map = [],
        bool $strict = false,
        ?string $scope = null
    ): bool {
        if (!is_array($data)) {
            return false;
        }

        $scope = $scope ?? $model->getFormName();
        if ($scope === '') {
            $hydrateData = $data;
        } else {
            if (!isset($data[$scope])) {
                return false;
            }
            /** @var mixed $hydrateData */
            $hydrateData = $data[$scope];
        }

        if (!is_array($hydrateData)) {
            return false;
        }

        $this->hydrator->populate($model, $hydrateData, $map, $strict);

        return true;
    }
}
