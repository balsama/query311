<?php

namespace Balsama\Query311;

use mysql_xdevapi\Exception;

class QueryParameters
{
    public int $year;
    public \DateTimeImmutable $after;
    public \DateTimeImmutable $before;
    public ?string $zip = null;
    public ?string $titleSearchString = null;
    public ?string $address = null;

    public ?string $formFlavor = null;
    public bool $searchAddressByContains = false;

    public function __construct(array $formData)
    {
        $this->year = $formData['table'];
        $this->after = new \DateTimeImmutable($formData['date-after']);
        $this->before = new \DateTimeImmutable($formData['date-before']);

        $this->setFormFlavor($formData);

        switch ($this->formFlavor) {
            case 'ZIP_PLUS_CATEGORY':
                $this->zip = $formData['zip-code'];
                if (array_key_exists('case-title-contains', $formData)) {
                    if ($formData['case-title-contains']) {
                        $this->titleSearchString = $formData['case-title-contains'];
                    }
                }
                break;
            case 'ADDRESS':
                $this->address = $formData['address-contains'];
                if (array_key_exists('address-search-type', $formData)) {
                    $this->searchAddressByContains = true;
                }
                break;
            default:
                throw new \Exception('No form type');
        }
    }

    private function setFormFlavor(array $formData): void
    {
        if (array_key_exists('zip-code', $formData)) {
            if (strlen($formData['zip-code']) === 5) {
                $this->formFlavor = 'ZIP_PLUS_CATEGORY';
                return;
            }
        }
        if (array_key_exists('address-contains', $formData)) {
            $this->formFlavor = 'ADDRESS';
            return;
        }
        throw new \Exception('Unknown form type');
    }
}