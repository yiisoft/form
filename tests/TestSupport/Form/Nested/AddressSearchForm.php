<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

// use Brick\Geo\Geometry;
// use Brick\Geo\IO\GeoJSONReader;


use Yiisoft\Form\FormModel;

/**
 * Форма поиска адресов
 */
final class AddressSearchForm extends FormModel
{
    protected ?int $type_id = null;
    protected ?array $fiases = null;
    protected ?string $query = null;
    protected mixed $ids = null;
    protected mixed $k_numbers = null;
    protected ?string $name = null;
    protected bool $with_data = false;
    protected mixed $regions = null;
    //  protected ?Geometry $coords = null;

    protected ObjectSearchForm $objects;
    protected PageDataSearchForm $pageData;
    protected NumberSearchForm $numbers;

    public function __construct()
    {
        parent::__construct();

        $this->objects = new ObjectSearchForm();
        $this->pageData = new PageDataSearchForm();
        $this->numbers = new NumberSearchForm();
    }

    public function getAttributeHints(): array
    {
        $hints = parent::getAttributeHints();
        $hints['type_id'] = 'ID of address type';
        $hints['query'] = 'Address name starts with...';

        return $hints;
    }

    public function getAttributeLabels(): array
    {
        $labels = parent::getAttributeLabels();
        $labels['fiases'] = 'FIAS numbers';

        return $labels;
    }

    public function getAttributePlaceholders(): array
    {
        $placeholders = parent::getAttributePlaceholders();
        $placeholders['fiases'] = 'Start typing FIAS number';

        return $placeholders;
    }

    public function setAttribute($name, $value): void
    {
        switch ($name) {
            case 'fiases':
                parent::setAttribute($name, empty($value) ? null : (array) $value);
                break;
            case 'type_id':
                $this->type_id = is_numeric($value) ? (int) $value : null;
                break;
            case 'coords':
             //   $this->setCoordinates($value);
                break;
            case 'ids':
                if (empty($value)) {
                    $value = null;
                } elseif (is_array($value)) {
                    $value = filter_var($value, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1
                        ],
                        'flags' => FILTER_FORCE_ARRAY
                    ]);
                }

                parent::setAttribute($name, $value);

                break;
            default:
                parent::setAttribute($name, $value);
        }
    }
}
