<?php

namespace TFC;

class Currency
{
    public static function determineCurrency()
    {
        $currencySymbol = 'INR ₹';
        $currencyMultiplier = 1;

        // If the geotarget API exists
        if (function_exists('geot_target')) {
            if (geot_target('IN')) {
                // India
                $currencySymbol = 'INR ₹';
                $currencyMultiplier = 1;
            } elseif (geot_target('BD')) {
                // Bangladesh
                $currencySymbol = 'BDT ৳';
                $currencyMultiplier = 0.7;
            // } elseif (geot_target('PK')) {
            //     // Pakistan
            //     $currencySymbol = 'PKR';
            //     $currencyMultiplier = 0.6;
            } else {
                // Rest of the world in USD
                $currencySymbol = 'USD $';
                $currencyMultiplier = 0.0189;
            }
        }

        return [
            'currencySymbol' => $currencySymbol,
            'currencyMultiplier' => $currencyMultiplier,
        ];
    }

    public static function convertCurrency($inrPrice, $currencyMultiplier)
    {
        return number_format($inrPrice * $currencyMultiplier, 2);
    }    

    public static function formatCurrency($inrPrice, $currencySymbol, $currencyMultiplier)
    {
        return $currencySymbol . " " . Currency::convertCurrency($inrPrice, $currencyMultiplier);
    }
}
