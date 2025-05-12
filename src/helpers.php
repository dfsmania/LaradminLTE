<?php

use DFSmania\LaradminLte\LaradminLte;

if (! function_exists('ladmin')) {
    function ladmin(): LaradminLte
    {
        return app(LaradminLte::class);
    }
}
