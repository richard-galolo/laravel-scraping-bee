# TruePeopleSearch Laravel API

This project provides an API to interact with TruePeopleSearch using Laravel. It leverages ScrapingBee to scrape the necessary data and return it in a clean JSON format. 

## Table of Contents

- [Installation](#installation)
- [Config](#config)
- [API Endpoints](#api-endpoints)
- [Postman Collection](#postman-collection)

## Installation
1. Clone the repository:
```bash
git clone https://github.com/richard-galolo/laravel-scraping-bee.git
cd laravel-scraping-bee
```
2. Install the dependencies:
```bash
composer install
```
3. Copy the environment file:
```bash
cp .env.example .env
```
4. Run the database migrations:
```bash
php artisan migrate
```
5. Start the development server:
```bash
php artisan serve
```

## Config
To interact with ScrapingBee API, you need to set your SCRAPINGBEE_API_KEY in the .env file. This key is required to authenticate requests to ScrapingBee's service.
```bash
SCRAPINGBEE_API_KEY="${YOUR_SCRAPINGBEE_API_KEY}"
```
You can get your API key by signing up for an account at [ScrapingBee](https://www.scrapingbee.com/).

## API Endpoints

### `GET /api/v1/truepeoplesearch/results`

This endpoint allows you to search for people using specific parameters. You can provide the following parameters in the query string:

- `name` (required): Name of the person you want to search for.
- `city` (optional): The city of the person.
- `state` (optional): The state of the person.

#### Request Example:

```bash
GET {{base_url}}/api/v1/truepeoplesearch/results?name=richard garcia&city=San Diego&state=CA
```

#### Response Example:

```bash
{
    "success": true,
    "message": "Search results retrieved successfully.",
    "data": [
        {
            "name": "Richard",
            "age": "66",
            "lives_in": "Staten Island, NY",
            "used_to_live_in": "Dunedin FL, Glens Falls NY, Clearwate...",
            "related_to": "Janice A Beals, Adam M Collins, Brian...",
            "detail_link": "/find/person/px9lr9nr8nl86n0ru29nn",
            "profile_id": "px9lr9nr8nl86n0ru29nn"
        },
        {
            "name": "Richard",
            "age": "71",
            "lives_in": "Surfside, FL",
            "used_to_live_in": "North Miami Beach FL, Surfside FL, Mi...",
            "related_to": "Amber D Clarvit, Candace Lepczyk Jean...",
            "detail_link": "/find/person/px8u80rln290u04l80ur6",
            "profile_id": "px8u80rln290u04l80ur6"
        }
    ]
}
```

### `GET /api/v1/truepeoplesearch/results/{profileId}`

This endpoint allows you to fetch the detailed profile information of a person using their profile ID.

#### Request Example:

```bash
GET {{base_url}}api/v1/truepeoplesearch/results/px9lr9nr8nl86n0ru29nn
```

#### Response Example:

```bash
{
    "success": true,
    "message": "Profile details retrieved successfully.",
    "data": {
        "name": "Richard",
        "age": "Age 66, Born June 1958",
        "lives_in": "Lives in Staten Island, NY",
        "phone": "(718) 273-2709",
        "full_background_report": {
            "details": [
                "Arrest & Criminal Records",
                "Misdemeanors & Felonies",
                "Registered Sex Offender Check",
                "Warrants & Police Records",
                "Nationwide Court Records",
                "Evictions & Foreclosures",
                "Arrest Records",
                "Court Records",
                "Marriage & Divorce Records",
                "Birth & Death Records",
                "Police Records",
                "Search Warrants",
                "Criminal Records Data",
                "Property Records",
                "Arrest & Criminal Records",
                "Misdemeanors & Felonies",
                "Registered Sex Offender Check",
                "Arrest Records",
                "Court Records",
                "Marriage & Divorce Records",
                "Birth & Death Records",
                "Police Records",
                "Search Warrants",
                "Criminal Records Data",
                "Property Records"
            ],
            "link": "/send?pid=1&tc=detail-top-pf&isfinal=1&related=https%3a%2f%2fwww.peoplefinders.com%2fcheckout%2fbackground-check%3fproductMenuName%3dsearch-name-background%26productOfferId%3dPremium-Membership-3-Day-Trial%26utm_source%3dtps%26utm_campaign%3dpf_topbutton_details_bgtrialcheckout%26id%3dG-9139738718670352977%26firstName%3d%26lastName%3dRichard"
        }
    }
}
```

#### Postman Collection

You can download the Postman collection for testing the API endpoints by clicking the link below:

[Download Postman Collection](https://github.com/richard-galolo/laravel-scraping-bee/blob/main/public/scraping-bee.postman_collection.json)


