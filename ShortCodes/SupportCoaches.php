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

            // Handle OR condition for Apprentice roles
            if ($courseRoleName === \TFCMembers\Courses::APPRENTICE_BASIC_IW) {
                $hasRole = in_array(\TFCMembers\Courses::APPRENTICE_BASIC_IW, $userRoles) 
                    || in_array(\TFCMembers\Courses::APPRENTICE_COACH, $userRoles);

                $courseName = "Apprentice Basic IW OR Apprentice Coach";
            } elseif ($courseRoleName === \TFCMembers\Courses::APPRENTICE_COACH) {
                // Skip second apprentice entry so it does not show twice
                continue;
            } else {
                $hasRole = in_array($courseRoleName, $userRoles);
            }

            //$icon = in_array($courseRoleName, $userRoles) ? '<span style="color:green">&#10004;</span>' : '<span style="color:blue">&#10006;</span>';
            $icon = $hasRole ? '<span style="color:green">&#10003</span>' : '<span style="color:blue">&#10060</span>';

            $html .= "<p>{$icon} {$courseName} </p>";
        }

        return $html;
    }
}