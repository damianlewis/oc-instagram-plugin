<?php

namespace DamianLewis\Instagram\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Instagram\Classes\InstagramException;
use DamianLewis\Instagram\Models\Settings;
use Log;
use stdClass;

class Feed extends ComponentBase
{

    /**
     * A collection of media items to display.
     *
     * @var array
     */
    public $mediaItems;

    /**
     * Message to display when there are no media items.
     *
     * @var string
     */
    public $noMediaItemsMessage;

    public function componentDetails(): array
    {
        return [
            'name'        => 'User Media Feed',
            'description' => 'Fetch recent user media items.',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'numberOfItems'       => [
                'title'             => 'Number of media items',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Invalid format for number of posts value',
                'default'           => '6',
            ],
            'noMediaItemsMessage' => [
                'title'             => 'No media items message',
                'description'       => 'Message to display when there are no media items to display.',
                'type'              => 'string',
                'default'           => 'No media items found',
                'showExternalParam' => false,
            ],
        ];
    }

    public function onRun()
    {
        $this->mediaItems          = $this->page['instagramMediaItems'] = $this->getMediaItems();
        $this->noMediaItemsMessage = $this->page['noMediaItemsMessage'] = $this->property('noMediaItemsMessage');
    }

    /**
     * Returns a collection of media items.
     *
     * @return array|null
     */
    protected function getMediaItems()
    {
        try {
            $data = $this->get('users/self/media/recent', [
                'count' => $this->getNumberOfItems(),
            ]);
        } catch (InstagramException $exception) {
            Log::error($exception);

            return null;
        }

        return $data;
    }

    /**
     * Returns the number of media items to display.
     *
     * @return int|null
     */
    protected function getNumberOfItems()
    {
        $numberOfItems = $this->property('numberOfItems');

        if (!is_numeric($numberOfItems)) {
            return null;
        }

        return $numberOfItems;
    }


    /**
     * Returns the data from the api response.
     *
     * @param string $path
     * @param array  $parameters
     *
     * @return array
     * @throws InstagramException
     */
    protected function get(string $path, array $parameters)
    {
        $url      = $this->makeApiUrl($path, $parameters);
        $response = $this->requestData($url);

        if (!$response) {
            throw new InstagramException('Invalid response from instagram feed.');
        }

        if (isset($response->meta)) {
            if (isset($response->meta->error_message)) {
                throw new InstagramException($response->meta->error_message);
            }

            if ($response->meta->code !== 200) {
                throw new InstagramException('Response status: ' . $response->meta->code);
            }
        }

        if (!isset($response->data)) {
            throw new InstagramException('No data from instagram response.');
        }

        return $response->data;
    }

    /**
     * Returns the url for the api endpoint.
     *
     * @param string $path
     * @param array  $parameters
     *
     * @return string
     */
    protected function makeApiUrl(string $path, array $parameters = []): string
    {
        $parameters = array_merge(
            ['access_token' => Settings::get('access_token')],
            $parameters
        );

        $query = http_build_query($parameters, '', '&');

        return 'https://api.instagram.com/v1/' . $path . '?' . $query;
    }

    /**
     * Sends a request to the given url.
     *
     * @param string $url
     *
     * @return null|stdClass
     */
    protected function requestData(string $url)
    {
        $handler = curl_init();

        curl_setopt($handler, CURLOPT_URL, $url);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handler, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($handler);

        curl_close($handler);

        $response = json_decode($response);

        if (!$response instanceof stdClass) {
            return null;
        }

        return $response;
    }
}
