<?php 

namespace App\Helpers;

class ReusableHelpers{
    /**
     * Providing human-readable last modified time, 
     * along with the edited status if applicable.
     */
    public static function getLastModifiedTime($created_at, $updated_at)
    {
        if ($created_at == $updated_at) {
            return $created_at->diffForHumans();
        }
        return $updated_at->diffForHumans() . " (edited)";
    }
}