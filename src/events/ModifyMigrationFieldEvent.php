<?php
namespace verbb\formie\events;

use verbb\formie\base\FormField;
use verbb\formie\elements\Form;

use craft\events\CancelableEvent;

class ModifyMigrationFieldEvent extends CancelableEvent
{
    // Properties
    // =========================================================================

    public ?Form $form = null;
    public mixed $originForm = null;
    public mixed $field = null;
    public ?FormField $newField = null;
    
}
