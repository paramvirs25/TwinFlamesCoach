<?php
// Add this code to your theme's functions.php file or a custom plugin

// Define the shortcode
function inner_work_progress_gauge_shortcode() {
    // Example progress percentage (you should replace this with your actual progress calculation logic)
    $progress_percentage = 50; // Assuming 50% progress

    // Calculate the angle based on the progress percentage
    $angle = $progress_percentage * 180 / 100; // Max angle is 180 degrees

    // Output HTML and CSS
    ob_start();
    ?>
    <div class="gauge">
        <div class="arc"></div>
        <div class="pointer" style="transform: rotate(<?php echo $angle; ?>deg) translateX(0) translateY(-6px);"></div>
        <div class="mask"></div>
        <div class="label"><?php echo $progress_percentage; ?>% (<?php echo $angle; ?>°)</div>
    </div>
    <style>
    .gauge {
        height: 85px;
        position: relative;
        width: 170px;
    }
    .gauge .arc {
        background-image: radial-gradient(#fff 0, #fff 60%, transparent 60%),
                          conic-gradient(red 0, orange <?php echo $angle; ?>deg, #ccc <?php echo $angle; ?>deg, #ccc 180deg, #fff 180deg, #fff 360deg);
        background-position: center center, center center;
        background-repeat: no-repeat;
        background-size: 100% 100%, 100% 100%;
        border-radius: 50%;
        border-style: none;
        height: 170px;
        position: relative;
        transform: rotate(-90deg);
        width: 100%;
    }
    .gauge .pointer {
        background: #fff;
        border: 1px solid #000;
        border-radius: 5px;
        bottom: 0;
        content: '';
        height: 6px;
        left: 0;
        position: absolute;
        transform: rotate(<?php echo $angle; ?>deg) translateX(0) translateY(-6px);
        transform-origin: 85px 0;
        width: 20px;
        z-index: 5;
    }
    .gauge .mask::before,
    .gauge .mask::after {
        background-image: radial-gradient(transparent 0, transparent 50%, #fff 50%, #fff 100%);
        clip-path: polygon(0 50%, 100% 50%, 100% 100%, 0% 100%);
        content: '';
        height: 18px;
        position: absolute;
        width: 18px;
    }
    .gauge .mask::before {
        left: -2px;
        bottom: 0;
    }
    .gauge .mask::after {
        bottom: 0;
        right: -2px;
    }
    .gauge .label {
        bottom: 20px;
        font-size: 16px;
        font-weight: 700;
        left: 0;
        line-height: 26px;
        position: absolute;
        text-align: center;
        width: 100%;
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('inner_work_progress_gauge', 'inner_work_progress_gauge_shortcode');
