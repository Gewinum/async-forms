<?php

namespace gewinum\asyncforms\responses;

class ModalFormResponse implements IFormResponse
{
    public function __construct(
        private ?bool $answer = null
    )
    {}

    public function isClosed(): bool
    {
        return !isset($this->answer);
    }

    public function getAnswer(): bool
    {
        return $this->answer;
    }
}