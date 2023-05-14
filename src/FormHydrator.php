<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Hydrator\HydratorInterface;

use function is_array;

/**
 * @psalm-import-type MapType from HydratorInterface
 */
final class FormHydrator
{
    public function __construct(
        private HydratorInterface $hydrator,
    ) {
    }

    /**
     * @psalm-param MapType $map
     */
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

        $scope ??= $model->getFormName();
        if ($scope === '') {
            $hydrateData = $data;
        } else {
            if (!isset($data[$scope])) {
                return false;
            }
            $hydrateData = $data[$scope];
        }

        if (!is_array($hydrateData)) {
            return false;
        }

        $this->hydrator->hydrate($model, $hydrateData, $map, $strict);

        return true;
    }
}
