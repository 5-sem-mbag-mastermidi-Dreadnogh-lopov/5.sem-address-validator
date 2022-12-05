<?php

namespace App\Integrations;

enum Confidence: string{
    case Exact = 'exact';
    case Sure = 'sure';
    case Unsure = 'unsure';
    case Unknown = 'unknown';
}
