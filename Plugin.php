<?php

namespace DamianLewis\Instagram;

use DamianLewis\Instagram\Components\Feed;
use DamianLewis\Instagram\Models\Settings;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails(): array
    {
        return [
            'name' => 'Instagram',
            'description' => 'Instagram feed for October CMS',
            'author' => 'Damian Lewis',
            'icon' => 'icon-instagram'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.instagram.access_settings' => [
                'tab' => 'Instagram',
                'label' => 'Manage the Instagram settings.'
            ],
        ];
    }

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'Instagram',
                'description' => 'Configure Instagram API access.',
                'icon' => 'icon-instagram',
                'class' => Settings::class,
                'permissions' => ['damianlewis.instagram.access_settings'],
                'keywords' => 'instagram',
                'order' => 1001
            ],
        ];
    }

    public function registerComponents(): array
    {
        return [
            Feed::class => 'instagramFeed'
        ];
    }
}
