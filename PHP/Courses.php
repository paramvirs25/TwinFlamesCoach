<?php
namespace TFCMembers;

/*This class list all our courses and respective course details like, course completion role name, course completion discount*/
class Courses {
    public $courseName;
    public $courseRoleName;
    public $courseCompletionDiscount; //course completion discount can be directly mentioned here
    public $courseCompletionCouponForDiscount; //course completion discount can be applied from a coupon mentioned here
    
    public function __construct($name, $roleName, $completionDiscount, $completionCouponForDiscount) {
        $this->courseName = $name;
        $this->courseRoleName = $roleName;
        $this->courseCompletionDiscount = $completionDiscount;
        $this->courseCompletionCouponForDiscount = $completionCouponForDiscount;
    }
    
    public static function getAllCourses() {
        $courses = array(
            "basic_iw_1" => new Courses("Basic inner work 1", "basic_iw_1", 10, "Basic IW 1"),
            "tfciw" => new Courses("Basic inner work 2", "tfciw", 10, "Basic IW 2"),
            "tfcaiw1" => new Courses("Advanced inner work 1", "tfcaiw1", 10, "Advanced IW 1"),
            "advanced_twin_flame_healings_1" => new Courses("Advanced Twin Flame Healings 1", "advanced_twin_flame_healings_1", 10, "Advanced TF Healings 1"),
            "chakra_healing_balancing" => new Courses("Chakra balancing program", "chakra_healing_balancing", 10, "Chakra balancing 1"),
            "certified_coach" => new Courses("Twin Flames Coach program", "certified_coach", 20, "Twin Flames Coach 1"),
            "certified_yoga_teacher" => new Courses("Yoga Teacher Training program", "certified_yoga_teacher", 10, "Yoga Teacher Training"),
            "shakti_kawach" => new Courses("Shakti Kavach program", "shakti_kawach", 10, "Shakti Kavach"),
            "apprentice_basic_iw" => new Courses("Apprentice - Basic IW", "apprentice_basic_iw", 20, "Apprenticeship Basic IW"),
            "apprentice_coach" => new Courses("Apprentice - Twin Flames Coach", "apprentice_coach", 10, "Apprenticeship TF Coach")
        );
        
        return $courses;
    }
}
>