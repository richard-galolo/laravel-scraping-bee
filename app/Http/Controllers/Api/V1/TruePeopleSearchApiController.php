<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TruePeopleSearch\ListTruePeopleSearchRequest;
use App\Services\TruePeopleSearchService;
use App\Services\ScrapingBeeService;
use Illuminate\Http\Response;

class TruePeopleSearchApiController extends Controller
{
    public function __construct(
        protected TruePeopleSearchService $truePeopleSearchService,
        protected ScrapingBeeService $scrapingBeeService
    ) {
        $this->truePeopleSearchService = $truePeopleSearchService;
        $this->scrapingBeeService = $scrapingBeeService;
    }

    public function index(ListTruePeopleSearchRequest $request)
    {
        try {
            $searchUrl = $this->truePeopleSearchService->base_url . '/results?' . http_build_query($request->validated());
            $options = [
                'stealth_proxy' => true,
                'country_code' => 'us',
                'return_page_source' => true
            ];

            $searchResults = $this->scrapingBeeService->request($searchUrl, $options);

            $data = $this->truePeopleSearchService->extractDataList($searchResults);

            return response()->json([
                'success' => true,
                'message' => __('scrapingbee.search_success'),
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $profileId)
    {
        try {
            $searchUrl = $this->truePeopleSearchService->base_url . '/find/person/' . $profileId;
            $options = [
                'stealth_proxy' => true,
                'country_code' => 'us',
                'return_page_source' => true
            ];

            $searchResults = $this->scrapingBeeService->request($searchUrl, $options);

            $data = $this->truePeopleSearchService->extractDetailData($searchResults);

            return response()->json([
                'success' => true,
                'message' => __('scrapingbee.profile_success'),
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
