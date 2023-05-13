<?php

namespace gewinum\asyncforms\responses;

class SimpleFormResponse implements IFormResponse
{
    public function __construct(
        private ?string $selectedButtonIdentifier
    )
    {}

    public function isClosed(): bool
    {
        return !isset($this->selectedButtonIdentifier);
    }

    public function getSelectedButton(): string
    {
        if ($this->isClosed()) {
            throw new \Exception("Can't get response of closed form");
        }

        return $this->selectedButtonIdentifier;
    }
}