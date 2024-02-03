<?php

// Define the common base path variable
$tfcBasePath = '/home/twinflam/repositories/TwinFlamesCoach';

//---Classes

//Currency Class
require_once($tfcBasePath . '/PHP/TFC/Currency.php');


//---Short Codes

// all_course_start_dates
// upcoming_course_start_date
require_once($tfcBasePath . '/ShortCodes/CourseStartDates.php');

// Requires 
//      Class - Currency
// country_price
// country_price_discount
require_once($tfcBasePath . '/ShortCodes/CountryPriceCalculation.php');

// whatsapp_program_support
require_once($tfcBasePath . '/ShortCodes/WhatsAppButtons.php');