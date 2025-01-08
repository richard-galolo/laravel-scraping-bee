<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ScrapingBeeService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('scrapingbee.base_url');
        $this->apiKey = config('scrapingbee.api_key');
    }

    /**
     * Perform a GET request via ScrapingBee.
     *
     * @param string $url The target URL to scrape.
     * @param array $options Optional parameters for ScrapingBee.
     * @return string The response body from ScrapingBee.
     * @throws \Exception If the request fails.
     */
    public function request(string $url, array $options = []): string
    {
        $params = array_merge(
            [
                'api_key' => $this->apiKey,
                'url' => $url,
            ],
            $this->processOptions($options)
        );

        $response = Http::get($this->baseUrl, $params);

        if ($response->failed()) {
            throw new \Exception(__('scrapingbee.request_failed', ['url' => $url]));
        }

        return $response->body();
    }

    /**
     * Process the optional parameters for ScrapingBee.
     *
     * @param array $options The raw options passed to the request method.
     * @return array The processed query parameters for the ScrapingBee API.
     */
    protected function processOptions(array $options): array
    {
        $processedOptions = [];

        $booleanOptions = [
            'render_js',
            'premium_proxy',
            'stealth_proxy',
            'json_response',
            'return_page_source',
        ];

        foreach ($booleanOptions as $option) {
            if (isset($options[$option]) && is_bool($options[$option])) {
                $processedOptions[$option] = $options[$option] ? 'true' : 'false';
            }
        }

        if (isset($options['wait']) && is_int($options['wait'])) {
            $processedOptions['wait'] = $options['wait'];
        }

        if (!empty($options['country_code'])) {
            $processedOptions['country_code'] = $options['country_code'];
        }

        return $processedOptions;
    }
}
