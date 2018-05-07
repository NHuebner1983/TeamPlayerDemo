<?php

namespace App\Debug;

use Artisan;

class ArtisanDebug extends BaseDebug {

    /**
     * Artisan: View Clear
     *
     * Runs the `artisan view:clear` command to clear views.
     * Mainly used to instantly load any changes.
     * Command will; only be run outside of console and in Debug/Development mode.
     */
    public static function clearViews()
    {
        if ( static::isConsole() || ! static::isDebug() )
        {
            return;
        }

        Artisan::call('view:clear');
    }

}
