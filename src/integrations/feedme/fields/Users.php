<?php
namespace verbb\formie\integrations\feedme\fields;

use craft\feedme\fields\Users as FeedMeUsers;
use verbb\formie\fields\formfields\Users as UsersField;

class Users extends FeedMeUsers
{
    // Traits
    // =========================================================================

    use BaseFieldTrait;

    
    // Properties
    // =========================================================================

    public static $name = 'Users';
    public static $class = UsersField::class;

}
