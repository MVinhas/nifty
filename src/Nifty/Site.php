<?php

namespace Nifty;

use Nifty\Controllers\SiteController;

class Site
{
    /**
     * 
     * Triggers the main events: database initialization, head,
     * header, which controller to call, and footer.
     * 
     */
    public static function start()
    {
        Db::initialize();
        SiteController::head();
        SiteController::header();
        Route::contentToRender();
        SiteController::footer();
    }
}