<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;

final class DataSearchForm extends FormModel
{
    protected ?int $auction_type_id = null;
    protected ?array $source_ids = null;
    protected array $price = [];
    protected array $accepting_bid = [];
    protected array $auction_time = [];
    protected array $area = [];

    protected AddressSearchForm $address;

    public function __construct()
    {
        parent::__construct();

        $this->address = new AddressSearchForm();
    }

    public function getAttributeHints(): array
    {
        $hints = parent::getAttributeHints();
        $hints['auction_type_id'] = 'ID of auction type';
        $hints['source_ids'] = 'List IDs of sources';
        $hints['price'] = 'Price range';
        $hints['area'] = 'Area range';

        return $hints;
    }

    public function getAttributeLabels(): array
    {
        $labels = parent::getAttributeLabels();
        $labels['auction_type_id'] = 'Auction type';
        $labels['source_ids'] = 'Sources';

        return $labels;
    }

    public function setAttribute(string $name, $value): void
    {
        if ($name === 'source_ids') {
            $value = empty($value) ? null : filter_var($value, FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1
                ],
                'flags' => FILTER_FORCE_ARRAY
            ]);
        }
        //if ($name === 'address.objects.type_ids') {
        //  $this->address->setAttribute('objects.is_active', true);
        // }

        parent::setAttribute($name, $value);
    }


    public function getFormName(): string
    {
        return 'Search';
    }
}
