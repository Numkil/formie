<?php
namespace verbb\formie\integrations\addressproviders;

use verbb\formie\base\AddressProvider;
use verbb\formie\events\ModifyAddressProviderHtmlEvent;

use Craft;
use craft\helpers\Json;
use craft\helpers\Template;

class Google extends AddressProvider
{
    // Constants
    // =========================================================================

    public const GOOGLE_INPUT_NAME = 'formie-google-autocomplete';
    public const EVENT_MODIFY_ADDRESS_PROVIDER_HTML = 'modifyAddressProviderHtml';


    // Properties
    // =========================================================================

    public ?string $apiKey = null;
    public array $options = [];


    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return Craft::t('formie', 'Google Places');
    }

    /**
     * @inheritDoc
     */
    public static function supportsCurrentLocation(): bool
    {
        return true;
    }

    public function getDescription(): string
    {
        return Craft::t('formie', 'Use [Google Places Autocomplete](https://developers.google.com/maps/documentation/javascript/places-autocomplete) to suggest addresses, for address fields.');
    }

    /**
     * @inheritDoc
     */
    public function defineRules(): array
    {
        $rules = parent::defineRules();

        $rules[] = [['apiKey'], 'required'];

        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function getFrontEndHtml($field, $options): string
    {
        $view = Craft::$app->getView();
        $oldTemplatesPath = $view->getTemplatesPath();

        if (!$this->hasValidSettings()) {
            return '';
        }

        $view->setTemplateMode($view::TEMPLATE_MODE_CP);

        $html = Craft::$app->getView()->renderTemplate('formie/integrations/address-providers/google-places/_input', [
            'field' => $field,
            'options' => $options,
        ]);

        $view->setTemplatesPath($oldTemplatesPath);

        // Fire a 'modifyAddressProviderHtml' event
        $event = new ModifyAddressProviderHtmlEvent([
            'html' => Template::raw($html),
        ]);
        $this->trigger(self::EVENT_MODIFY_ADDRESS_PROVIDER_HTML, $event);

        return $event->html;
    }

    /**
     * @inheritDoc
     */
    public function getFrontEndJsVariables($field = null): ?array
    {
        if (!$this->hasValidSettings()) {
            return null;
        }

        $settings = [
            'apiKey' => Craft::parseEnv($this->apiKey),
            'options' => $this->_getOptions(),
        ];

        return [
            'src' => Craft::$app->getAssetManager()->getPublishedUrl('@verbb/formie/web/assets/addressproviders/dist/js/google-address.js', true),
            'module' => 'FormieGoogleAddress',
            'settings' => $settings,
        ];
    }

    /**
     * @inheritDoc
     */
    public function hasValidSettings(): bool
    {
        if ($this->apiKey) {
            return true;
        }

        return false;
    }


    // Public Methods
    // =========================================================================

    private function _getOptions(): array
    {
        $options = [];
        $optionsRaw = $this->options;

        if (!is_array($optionsRaw)) {
            $optionsRaw = [];
        }

        foreach ($optionsRaw as $key => $value) {
            $options[$value[0]] = Json::decode($value[1]);
        }

        return $options;
    }
}