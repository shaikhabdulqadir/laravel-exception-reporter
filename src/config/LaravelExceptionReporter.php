<?php

return [
	/**
     * Configure the ErrorEmail service
     *
     * - email (bool) - Enable or disable emailing of errors/exceptions
     *
     * - api_key (string) - // get your API key from exceptionreporter.com
     *   even if they are thrown Ex: ['']
     *
     * - throttle (bool) - Enable or disable throttling of errors/exceptions
     *
     * - throttleCacheDriver (string) - The cache driver to use for throttling emails,
     *   uses cache driver from your env file labeled 'CACHE_DRIVER' by default
     *
     * - throttleDurationMinutes (int) - The duration of the throttle in minutes
     *   ex if you want to be emailed only once every 5 minutes about each unique
     *   exception type enter 5
     *
     * - dontThrottle (array) - An array of classes that should never be throttled
     *   even if they are thrown more than once within the normal throttling window
     *
     * - globalThrottle (bool) - whether you want to globally throttle the number of emails
     *   you can receive of all exception types by this application
     *
     * - emailSubject (string) - The subject of email, leave NULL to use default
     *   Default Subject: An Exception has been thrown on APP_URL APP_ENV
     *
     */
    'ExceptionReporter' => [
    	'report_exception' => true,
        'api_key' => 'YOUR_API_KEY_HERE', // get your API key from exceptionreporter.com
        'email' => true,
        'dontEmail' => [],
        'emailSubject' => null
    ]
];
