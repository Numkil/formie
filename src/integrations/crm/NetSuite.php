<?php
namespace verbb\formie\integrations\crm;

use verbb\formie\base\Crm;
use verbb\formie\base\Integration;
use verbb\formie\elements\Submission;

use Craft;
use GuzzleHttp\Client;
use Throwable;

class NetSuite extends Crm
{
    // Properties
    // =========================================================================

    public ?string $apiKey = null;


    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return Craft::t('formie', 'NetSuite');
    }

    public function getDescription(): string
    {
        return Craft::t('formie', 'Manage your NetSuite customers by providing important information on their conversion on your site.');
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

    public function fetchFormSettings(): array
    {
        $allLists = [];

        try {
            
        } catch (Throwable $e) {
            Integration::apiError($this, $e);
        }

        return $allLists;
    }

    public function sendPayload(Submission $submission): bool
    {
        try {
            
        } catch (Throwable $e) {
            Integration::apiError($this, $e);

            return false;
        }

        return true;
    }

    public function fetchConnection(): bool
    {
        try {
            
        } catch (Throwable $e) {
            Integration::apiError($this, $e);

            return false;
        }

        return true;
    }

    public function getClient(): Client
    {
        if ($this->_client) {
            return $this->_client;
        }

        return $this->_client = Craft::createGuzzleClient([
            'base_uri' => '',
            'headers' => ['Api-Token' => Craft::parseEnv($this->apiKey)],
        ]);
    }
}