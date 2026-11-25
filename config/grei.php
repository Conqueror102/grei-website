<?php

/*
|--------------------------------------------------------------------------
| GREI brand and site settings
|--------------------------------------------------------------------------
| Contact details, currency and page imagery live here so they can be
| changed without touching templates. Image values are Unsplash photo ids
| (free to use under the Unsplash License); see App\Support\Img.
*/

return [

    'name' => 'GREI',
    'full_name' => 'GREI Group',
    'descriptor' => 'Global Real Estate & Interior Design',
    'purpose' => 'To elevate the way people discover, create and experience spaces.',

    'contact' => [
        'email' => env('GREI_EMAIL', 'hello@grei.example'),
        'phone' => env('GREI_PHONE', '+000 000 000 0000'),
        'address' => env('GREI_ADDRESS', 'Studio address to be confirmed'),
        'hours' => 'Monday to Friday, 9:00 to 18:00',
    ],

    'currency' => [
        'symbol' => env('GREI_CURRENCY_SYMBOL', '$'),
        'code' => env('GREI_CURRENCY_CODE', 'USD'),
    ],

    'socials' => [
        'instagram' => env('GREI_INSTAGRAM', '#'),
        'linkedin' => env('GREI_LINKEDIN', '#'),
    ],

    // Where enquiries are sent. Mail uses the app's MAIL_* settings (log driver by default).
    'enquiries_to' => env('GREI_ENQUIRIES_TO', env('GREI_EMAIL', 'hello@grei.example')),

    // Page-level imagery (Unsplash photo ids).
    'images' => [
        'home_hero' => 'images/photos/hero-residence.jpg',
        'pillar_real_estate' => 'images/photos/feature-villa.jpg',
        'pillar_interiors' => 'photo-1618221195710-dd6b41faaea6',
        'pillar_stays' => 'photo-1631049307264-da0ec9d70304',
        'real_estate_hero' => 'images/photos/feature-villa.jpg',
        'interiors_hero' => 'photo-1493809842364-78817add7ffb',
        'stays_hero' => 'photo-1582719478250-c89cae4dc85b',
        'about_hero' => 'photo-1524758631624-e2822e304c36',
        'about_team' => 'photo-1600880292203-757bb62b4baf',
        'contact' => 'photo-1497366811353-6870744d04b2',
        'approach' => 'photo-1586023492125-27b2c045efd7',
        // Booking page, one per booking type
        'book_call' => 'photo-1600047509807-ba8f99d2cdde',
        'book_consult' => 'photo-1566665797739-1674de7a421a',
        'book_list' => 'photo-1568605114967-8130f3a36994',
        // Page heroes and the Stays glass banner (each photo used once on the site)
        'real_estate_page' => 'photo-1580587771525-78b9dba3b914',
        'stays_page' => 'photo-1512918728675-ed5a9ecdebfd',
        // Home hero carousel slides
        'slide_real_estate' => 'photo-1600566753376-12c8ab7fb75b',
        'slide_interiors' => 'photo-1613545325278-f24b0cae1224',
        'slide_stays' => 'photo-1542314831-068cd1dbfeeb',
    ],
];
