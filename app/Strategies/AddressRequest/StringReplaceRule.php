<?php

namespace App\Strategies\AddressRequest;

use App\Models\AddressRequest;

class StringReplaceRule implements AddressRequestRuleInterface
{
    protected string $pattern;
    protected string $replace;

    public function __construct($pattern, $replace)
    {
        $this->pattern = $pattern;
        $this->replace = $replace;
    }

    public function apply(AddressRequest $request): AddressRequest
    {
        $replacement = new AddressRequest();
        $attributes = $request->getAttributes();

        foreach ($attributes as $key => $value) {
            $replacement->{$key} = match ($key) {
                'street' => $value != null ? str_ireplace($this->pattern, $this->replace, $value) : "",
                default => $value
            };
        }

        return $replacement;
    }
}
