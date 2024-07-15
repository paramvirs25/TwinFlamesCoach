<?php
namespace TFCMembers;

add_shortcode( 'tfc_inner_work_progress', function () {
    $current_user = wp_get_current_user(); // Get the current logged-in user object
	$user_roles = $current_user->roles; // Get an array of the user's assigned roles
	
	//return "";

	return \TFCMembers\TwinFlamesCoachInnerWorkProgress::courseCompletionStatus($user_roles);
} );

class TwinFlamesCoachInnerWorkProgress {
    
    public static function courseCompletionStatus($userRoles) {
        $courses = \TFCMembers\Courses::getCoursesListForTFCIWProgress();
        $html = '';

        $html .= "<div id='tfcIWProgress'>";
        foreach ($courses as $course) {
            
            $icon = in_array($course->courseRoleName, $userRoles) ? 
                '<span style="color:green">&#10003</span>' : '<span style="color:blue">&#10060</span>';
            
            $html .= "<p>{$icon} <span class='tfcIWProgPerc'>({$course->tfcIWProgressPercentage}%)</span> {$course->courseName}</p>";
        }
        $html .= "</div>";

        return $html;
    }
}
