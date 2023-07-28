<?php
// Define the audio_control shortcode function
function audio_control($atts) {
    // Extract shortcode attributes
    extract(shortcode_atts(array(
        'audio_file_language' => '',
        'audio_file_id' => '',
        'audio_file_name' => '',
    ), $atts));

    // Generate the HTML output
    $output = '<div class="wp-block-group contentbox is-layout-constrained">
        <div class="wp-block-group__inner-container">
            <h5 class="wp-block-heading"><span class="ez-toc-section" id="' . esc_attr($audio_file_language) . '" ez-toc-data-id="#' . esc_attr($audio_file_language) . '"></span>' . esc_html($audio_file_language) . '<span class="ez-toc-section-end"></span></h5>

            <figure class="wp-block-audio"><audio controls="" src="https://docs.google.com/uc?export=open&amp;id=' . esc_attr($audio_file_id) . '"></audio></figure>

            <p class="has-text-align-center"><a class="dropbox-saver dropbox-dropin-btn dropbox-dropin-default" data-filename="' . esc_attr($audio_file_name) . '" href="https://docs.google.com/uc?export=download&amp;id=' . esc_attr($audio_file_id) . '"><span class="dropin-btn-status"></span>Save to Dropbox</a></p>
        </div>
    </div>';

    return $output;
}

// Register the shortcode with WordPress
add_shortcode('audio_control', 'audio_control');

?>

<!-- <div class="wp-block-group contentbox is-layout-constrained">
    <div class="wp-block-group__inner-container">
        <h5 class="wp-block-heading"><span class="ez-toc-section" id="{audio_file_language}" ez-toc-data-id="#{audio_file_language}"></span>{language}<span class="ez-toc-section-end"></span></h5>

        <figure class="wp-block-audio"><audio controls="" src="https://docs.google.com/uc?export=open&amp;id={audio_file_id}"></audio></figure>

        <p class="has-text-align-center"><a class="dropbox-saver dropbox-dropin-btn dropbox-dropin-default" data-filename="{audio_file_name}" href="https://docs.google.com/uc?export=download&amp;id={audio_file_id}"><span class="dropin-btn-status"></span>Save to Dropbox</a></p>
    </div>
</div> -->