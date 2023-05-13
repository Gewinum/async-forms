<?php

namespace gewinum\asyncforms\responses;

use gewinum\asyncforms\components\FormComponent;

class CustomFormResponse implements IFormResponse
{
    public function __construct(
        private ?array $responses = []
    )
    {}

    public function isClosed(): bool
    {
        return !isset($this->responses);
    }

    public function getAnswerFor(string $componentName): mixed
    {
        if ($this->isClosed()) {
            throw new \Exception("Can't get response of closed custom form");
        }

        return $this->responses[$componentName];
    }
}