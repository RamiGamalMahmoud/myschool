<?php

namespace SM\Objects;

class SocialData
{
    private string $martialStatus;

    private ?int $childrenCount;

    public function __construct(string $martialStatus, ?int $childrenCount)
    {
        $this->martialStatus = $martialStatus;
        $this->childrenCount = $childrenCount;
    }

    public function getMartialStatus()
    {
        return $this->martialStatus;
    }

    public function getChildrenCount()
    {
        return $this->childrenCount;
    }

    public function toArray(): array
    {
        return [
            'martial-status' => $this->getMartialStatus(),
            'children-count' => $this->getChildrenCount()
        ];
    }
}
