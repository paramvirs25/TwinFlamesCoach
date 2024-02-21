<?php

namespace TFC;

class Utilities
{
    /**
     * Get  data from the JSON file.
     */
    public static function getJsonData($json_file_url)
    {
        // Use a more robust method (e.g., cURL) for HTTP requests to handle errors more effectively
        $json_content = @file_get_contents($json_file_url);

        if ($json_content === false) {
            // Handle the error (e.g., log, display an error message)
            return null;
        }

        // Decode the JSON content with error handling
        $json_data = json_decode($json_content, true);

        if ($json_data === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle the JSON decoding error (e.g., log, display an error message)
            return null;
        }

        return $json_data;
    }
}