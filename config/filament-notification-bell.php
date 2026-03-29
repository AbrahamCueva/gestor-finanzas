<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Limit
    |--------------------------------------------------------------------------
    | Maximum number of notifications to show per page in the bell panel.
    */

    'limit' => 20,

    /*
    |--------------------------------------------------------------------------
    | Real-time Driver
    |--------------------------------------------------------------------------
    | true  = Laravel Reverb (recommended)
    | false = Pusher
    */

    'reverb' => true,

    /*
    |--------------------------------------------------------------------------
    | Channel Type
    |--------------------------------------------------------------------------
    | 'private'  — authenticated private channel (default, recommended)
    | 'presence' — presence channel (includes member list)
    */

    'channel_type' => 'private',

    /*
    |--------------------------------------------------------------------------
    | Polling Fallback
    |--------------------------------------------------------------------------
    | Enable polling as a fallback when WebSocket connections are unavailable.
    */

    'polling' => false,

    /*
    |--------------------------------------------------------------------------
    | Poll Interval
    |--------------------------------------------------------------------------
    | Number of seconds between polls when polling is enabled.
    */

    'poll_interval' => 30,

    /*
    |--------------------------------------------------------------------------
    | Notification Model
    |--------------------------------------------------------------------------
    | Override the notification model class. null = use Laravel's built-in
    | Illuminate\Notifications\DatabaseNotification.
    */

    'model' => null,

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    | 'diffForHumans' — relative time (e.g. "5 minutes ago")
    | 'datetime'      — absolute date and time string
    */

    'date_format' => 'diffForHumans',

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    | null = use app()->getLocale() automatically.
    | Set to a locale string (e.g. 'fr') to force a specific locale.
    */

    'locale' => null,

    /*
    |--------------------------------------------------------------------------
    | RTL Locales
    |--------------------------------------------------------------------------
    | Locales that trigger right-to-left layout (dir="rtl", text-right).
    */

    'rtl_locales' => ['ar', 'fa', 'he', 'ur'],

    /*
    |--------------------------------------------------------------------------
    | Force RTL
    |--------------------------------------------------------------------------
    | Force RTL layout regardless of the active locale.
    */

    'force_rtl' => false,

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    | 'auto'  — follows Filament panel dark mode setting (default)
    | 'light' — always render in light mode
    | 'dark'  — always render in dark mode
    */

    'theme' => 'auto',

];
