<?php

// Define the common base path variable
$tfcBasePath = '/home/twinflam/repositories/TwinFlamesCoach';

//Config
require_once($tfcBasePath . '/PHP/Config.php');

//---Classes

//utility class
require_once($tfcBasePath . '/PHP/TFC/Utilities.php');

//---Short Codes

// all_course_start_dates
// upcoming_course_start_date
// all_ongoing_courses_classes_dates
require_once($tfcBasePath . '/ShortCodes/CourseStartDates.php');

// whatsapp_program_support
require_once($tfcBasePath . '/ShortCodes/WhatsAppButtons.php');