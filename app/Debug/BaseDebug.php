<?php

namespace App\Debug;

class BaseDebug {

    /**
     * APP_ENV value for production.
     * Change here if you are using something different.
     */
    const APP_ENV_PRODUCTION = 'production';

    /**
     * Checks if the application is in Debug or Stage/Development mode.
     *
     * @return bool
     */
    public static function isDebug()
    {
        return env('APP_ENV') != self::APP_ENV_PRODUCTION || env('APP_DEBUG');
    }

    /**
     * Checks if the application is running in console.
     *
     * @return bool
     */
    public static function isConsole()
    {
        return app()->runningInConsole();
    }

}
