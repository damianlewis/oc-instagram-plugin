<?php

namespace DamianLewis\Instagram\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use System\Behaviors\SettingsModel;

class Settings extends Model
{

    use Validation;

    /**
     * Implemented behaviours.
     *
     * @var array
     */
    public $implement = [
        SettingsModel::class,
    ];

    /**
     * Unique key.
     *
     * @var array
     */
    public $settingsCode = 'instagram_settings';

    /**
     * Field definitions.
     *
     * @var array
     */
    public $settingsFields = 'fields.yaml';


    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public $rules = [
        'access_token' => [
            'required',
        ],
    ];

    /**
     * The messages used when validation fails.
     *
     * @var array
     */
    public $customMessages = [
        'access_token.required' => 'An access token is required.',
    ];
}
