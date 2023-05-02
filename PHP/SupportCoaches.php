<?php
namespace TFCMembers;

add_shortcode( 'course_completion_status', function () {
    $current_user = wp_get_current_user(); // Get the current logged-in user object
	$user_roles = $current_user->roles; // Get an array of the user's assigned roles
	
	//return "";

	return \TFCMembers\SupportCoaches::courseCompletionStatus($user_roles);
} );

class SupportCoaches {
    
    public static function courseCompletionStatus($userRoles) {
        $courses = \TFCMembers\Courses::getCoursesListForSupportCoaches();
        $html = '';

        foreach ($courses as $course) {
            $courseName = $course->courseName;
            $courseRoleName = $course->courseRoleName;
            
            //$icon = in_array($courseRoleName, $userRoles) ? '<span style="color:green">&#10004;</span>' : '<span style="color:blue">&#10006;</span>';
            $icon = in_array($courseRoleName, $userRoles) ? '<span style="color:green">&#10003</span>' : '<span style="color:blue">&#10060</span>';
            
            
            $html .= "<p>{$icon} {$courseName} </p>";
        }

        return $html;
    }


}
>