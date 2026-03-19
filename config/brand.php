<?php

return [
    // Use `?:` so empty values like `BRAND_INSTAGRAM_URL=` still fall back to the default.
    'instagram_url' => env('BRAND_INSTAGRAM_URL') ?: 'https://www.instagram.com/_tinyytreasures/',
    'facebook_url' => env('BRAND_FACEBOOK_URL') ?: 'https://www.facebook.com/people/Tiny-Treasures/61570203554625/',
    'inquiry_to_email' => env('INQUIRY_TO_EMAIL'),
    'logo_path' => env('BRAND_LOGO_PATH', 'images/logo.jpg'),
];
