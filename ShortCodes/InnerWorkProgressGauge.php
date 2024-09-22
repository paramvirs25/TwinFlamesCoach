<?php
namespace TFCMembers;

add_shortcode('tfc_inner_work_progress', function () {
    $current_user = wp_get_current_user(); // Get the current logged-in user object
    $user_roles = $current_user->roles; // Get an array of the user's assigned roles
    
    //return "";

    return \TFCMembers\TwinFlamesCoachInnerWorkProgress::courseCompletionStatus($user_roles);
});

class TwinFlamesCoachInnerWorkProgress {
    
    public static function courseCompletionStatus($userRoles) {
        $totalIWProgress = 0;
        $courses = \TFCMembers\Courses::getCoursesListForTFCIWProgress();
        $html = '';

        $html .= "<div id='tfcIWProgress'>";
        foreach ($courses as $course) {
            if (in_array($course->courseRoleName, $userRoles)) {
                $icon = '<span style="color:green">&#10003</span>';
                $totalIWProgress += $course->tfcIWProgressPercentage; // Using += for readability
            } else {
                $icon = '<span style="color:blue">&#10060</span>';
            }
            
            $html .= "<p>{$icon} <span class='tfcIWProgPerc'>({$course->tfcIWProgressPercentage}%)</span> {$course->courseName}</p>";
        }
        $html .= "</div>";
        $html .= "<script>var tfcIWProgressPercentage = {$totalIWProgress};</script>"; // Use $totalIWProgress

        return $html;
    }
}
