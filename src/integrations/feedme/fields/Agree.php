<?php
namespace verbb\formie\integrations\feedme\fields;

use craft\feedme\fields\Lightswitch as FeedMeLightswitch;
use verbb\formie\fields\formfields\Agree as AgreeField;

class Agree extends FeedMeLightswitch
{
    // Traits
    // =========================================================================

    use BaseFieldTrait;

    
    // Properties
    // =========================================================================

    public static $name = 'Agree';
    public static $class = AgreeField::class;

}
