<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;

class TruePeopleSearchService
{
    public $base_url = 'https://www.truepeoplesearch.com';

    /**
     * Extract data from the provided HTML.
     *
     * @param string $html
     * @return array
     */
    public function extractDataList(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // Suppress errors from invalid HTML
        $xpath = new DOMXPath($dom);

        // Query all card elements
        $cards = $xpath->query('//div[contains(@class, "card-summary")]');

        $data = [];

        foreach ($cards as $card) {
            $name = $xpath->query('.//div[@class="h4"]', $card)->item(0)?->textContent ?? '';
            $age = trim($xpath->query('.//span[text()="Age "]/following-sibling::span', $card)->item(0)?->textContent ?? '');
            $livesIn = $xpath->query('.//span[text()="Lives in "]/following-sibling::span', $card)->item(0)?->textContent ?? '';
            $usedToLiveIn = $xpath->query('.//span[text()="Used to live in "]/following-sibling::span', $card)->item(0)?->textContent ?? '';
            $relatedTo = $xpath->query('.//span[text()="Related to "]/following-sibling::span', $card)->item(0)?->textContent ?? '';
            $detailLink = $xpath->query('.//a[contains(@class, "detail-link")]', $card)->item(0)?->getAttribute('href') ?? '';
            $profileId = basename($detailLink);

            $data[] = [
                'name' => trim($name),
                'age' => $age,
                'lives_in' => trim($livesIn),
                'used_to_live_in' => trim($usedToLiveIn),
                'related_to' => trim($relatedTo),
                'detail_link' => trim($detailLink),
                'profile_id' => $profileId
            ];
        }

        return $data;
    }

    /**
     * Extract both personal details and background report data into a single response.
     *
     * @param string $html
     * @return array
     */
    public function extractDetailData(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // Suppress warnings for malformed HTML
        $xpath = new DOMXPath($dom);

        // Extract personal details
        $name = $xpath->query('//h1[@class="oh1"]')->item(0)?->textContent ?? '';
        $age = trim($xpath->query('//span[contains(text(), "Age")]')->item(0)?->textContent ?? '');
        $livesIn = $xpath->query('//span[contains(text(), "Lives in")]')->item(0)?->textContent ?? '';
        $phone = $xpath->query('//span[@itemprop="telephone"]')->item(0)?->textContent ?? '';

        // Extract background report data
        $leftColumnItems = $xpath->query('//div[@class="col-sm-6"][1]//li');
        $rightColumnItems = $xpath->query('//div[@class="col-sm-6"][2]//li');

        $backgroundReport = [];
        foreach ($leftColumnItems as $item) {
            $backgroundReport[] = trim($item->textContent);
        }
        foreach ($rightColumnItems as $item) {
            $backgroundReport[] = trim($item->textContent);
        }

        $link = $xpath->query('//a[contains(@class, "detail-link") and contains(text(), "View Full Background Report")]')
            ->item(0)?->getAttribute('href') ?? '';

        return [
            'name' => trim($name),
            'age' => preg_replace('/\s+/', ' ', $age),
            'lives_in' => trim($livesIn),
            'phone' => trim($phone),
            'full_background_report' => [
                'details' => $backgroundReport,
                'link' => trim($link),
            ],
        ];
    }
}
