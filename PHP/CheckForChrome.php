<?php
// Shortcode function to detect if the browser is Chrome
function detect_chrome_browser() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    try {
        // Check if the User-Agent string contains "Chrome" or "Chromium"
        $isChrome = (strpos($userAgent, 'Chrome') !== false || strpos($userAgent, 'Chromium') !== false);
    } catch (Exception $e) {
        // Exception occurred, assume browser is not Chrome
        $isChrome = false;
    }

    // Return appropriate message based on browser detection
    if (!$isChrome) {
        return "<div class='promobox-container'>Attention: This Site works best with 'Google Chrome' browser</div>";
    }
}

add_shortcode('chrome_browser', 'detect_chrome_browser');
?>