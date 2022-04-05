<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form\Nested;

use Yiisoft\Form\FormModel;
use function Safe\strtotime;

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

    public function getMinPrice(): ?float
    {
        $min = $this->price[0] ?? null;

        return filter_var($min, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    public function getMaxPrice(): ?float
    {
        $max = $this->price[1] ?? null;

        return filter_var($max, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    public function getMinArea(): ?float
    {
        $min = $this->area[0] ?? null;

        return filter_var($min, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    public function getMaxArea(): ?float
    {
        $max = $this->area[1] ?? null;

        return filter_var($max, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    private function getDateTime(?string $value): ?string
    {
        if (empty($value) || ($timestamp = strtotime($value)) === false) {
            return null;
        }

        return date('Y-m-d\TH:i', $timestamp);
    }

    public function getMinAcceptingBid(): ?string
    {
        return $this->getDateTime($this->accepting_bid[0] ?? null);
    }

    public function getMaxAcceptingBid(): ?string
    {
        return $this->getDateTime($this->accepting_bid[1] ?? null);
    }


    public function getMinAuctionTime(): ?string
    {
        return $this->getDateTime($this->auction_time[0] ?? null);
    }

    public function getMaxAuctionTime(): ?string
    {
        return $this->getDateTime($this->auction_time[1] ?? null);
    }
}
