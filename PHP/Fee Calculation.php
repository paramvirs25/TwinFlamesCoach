namespace TFCMembers;

add_shortcode( 'consultation_fee', function () {
	$current_user = wp_get_current_user(); // Get the current logged-in user object
	$user_roles = $current_user->roles; // Get an array of the user's assigned roles
	
	$consultation_fee = \TFCMembers\Fee::calculateConsultationFee($user_roles);
	return $consultation_fee;
} );

add_shortcode( 'course_completion_status', function () {
    $current_user = wp_get_current_user(); // Get the current logged-in user object
	$user_roles = $current_user->roles; // Get an array of the user's assigned roles
	
	//return "";

	return \TFCMembers\Fee::courseCompletionStatus($user_roles);
} );


class Courses {
    public $courseName;
    public $courseRoleName;
    public $courseCompletionDiscount;
    
    public function __construct($name, $roleName, $completionDiscount) {
        $this->courseName = $name;
        $this->courseRoleName = $roleName;
        $this->courseCompletionDiscount = $completionDiscount;
    }
    
    public static function getAllCourses() {
        $courses = array(
            "basic_iw_1" => new Courses("Basic inner work 1", "basic_iw_1", 10),
            "tfciw" => new Courses("Basic inner work 2", "tfciw", 10),
            "tfcaiw1" => new Courses("Advanced inner work 1", "tfcaiw1", 10),
            "advanced_twin_flame_healings_1" => new Courses("Advanced Twin Flame Healings 1", "advanced_twin_flame_healings_1", 10),
            "chakra_healing_balancing" => new Courses("Chakra balancing program", "chakra_healing_balancing", 10),
            "certified_coach" => new Courses("Life/Twin Flames Coach program", "certified_coach", 20),
            "certified_yoga_teacher" => new Courses("Yoga Teacher Training program", "certified_yoga_teacher", 10),
            "shakti_kawach" => new Courses("Shakti Kavach program", "shakti_kawach", 10),
            "apprentice_basic_iw" => new Courses("Apprentice - Basic IW", "apprentice_basic_iw", 20),
            "apprentice_coach" => new Courses("Apprentice - Life Coach", "apprentice_coach", 10)
        );
        
        return $courses;
    }
}


class Fee {
    const TFC_Const_ConsultationFee_USD = 135;

    public static function calculateConsultationFee($userRoles) {
        $discountedFeeUSD = self::TFC_Const_ConsultationFee_USD;

        $courses = Courses::getAllCourses();

        foreach ($userRoles as $role) {
            if (isset($courses[$role])) {
                $course = $courses[$role];
                $discountedFeeUSD -= ($discountedFeeUSD * ($course->courseCompletionDiscount / 100));
            }
        }

        $discountedFeeINR = $discountedFeeUSD * 50;

        return "<p>USD {$discountedFeeUSD} / INR {$discountedFeeINR}</p>";

        //return $discountedFeeUSD;
    }

    public static function courseCompletionStatus($userRoles) {
        $courses = Courses::getAllCourses();
        $html = '';

        foreach ($courses as $course) {
            $courseName = $course->courseName;
            $courseRoleName = $course->courseRoleName;
            $courseDiscount = $course->courseCompletionDiscount;

            //$icon = in_array($courseRoleName, $userRoles) ? '<span style="color:green">&#10004;</span>' : '<span style="color:blue">&#10006;</span>';
            $icon = in_array($courseRoleName, $userRoles) ? '<span style="color:green">&#10003</span>' : '<span style="color:blue">&#10060</span>';
            
            
            $html .= "<p>{$icon} {$courseName} (Discount {$courseDiscount}%)</p>";
        }

        return $html;
    }


}
