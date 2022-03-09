<?php
namespace verbb\formie\helpers;

use craft\helpers\StringHelper as CraftStringHelper;

class StringHelper extends CraftStringHelper
{
    // Public Methods
    // =========================================================================

    public static function toId(mixed $value, bool $allowNull = true)
    {
        if ($allowNull && ($value === null || $value === '')) {
            return null;
        }

        if ($value === null || is_scalar($value)) {
            return (int)$value;
        }
    }
}