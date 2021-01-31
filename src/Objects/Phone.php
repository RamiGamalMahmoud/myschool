<?php

namespace SM\Objects;

class Phone
{
    private ?string $fixed;

    private ?string $mobile;

    public function __construct($fixed, $mobile)
    {
        $this->fixed  = $fixed;
        $this->mobile = $mobile;
    }

    public function getFixed()
    {
        return $this->fixed;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function toArray()
    {
        return [
            'fixed' => $this->getFixed(),
            'mobile' => $this->getMobile()
        ];
    }
}
