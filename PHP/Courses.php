<?php
namespace TFCMembers;

/*This class list all our courses and respective course details like, course completion role name, course completion discount*/
class Courses {
    const BASIC_IW_1 = "basic_iw_1";
    const TFCIW = "tfciw";
    const TFCAIW1 = "tfcaiw1";
    const ADV_TF_HEALINGS_1 = "advanced_twin_flame_healings_1";
    const CHAKRA_HEALING_BALANCING = "chakra_healing_balancing";
    const CERTIFIED_COACH = "certified_coach";
    const CERTIFIED_YOGA_TEACHER = "certified_yoga_teacher";
    const SHAKTI_KAWACH = "shakti_kawach";
    const APPRENTICE_BASIC_IW = "apprentice_basic_iw";
    const APPRENTICE_COACH = "apprentice_coach";

    private static function basic_iw_1() {
        return new Courses("Basic inner work 1", self::BASIC_IW_1, 10, "Basic IW 1"); 
    }
    
    private static function tfciw() {
        return new Courses("Basic inner work 2", self::TFCIW, 10, "Basic IW 2"); 
    }
    
    private static function tfcaiw1() {
        return new Courses("Advanced inner work 1", self::TFCAIW1, 10, "Advanced IW 1"); 
    }
    
    private static function advanced_tf_healings_1() {
        return new Courses("Advanced Twin Flame Healings 1", self::ADV_TF_HEALINGS_1, 10, "Advanced TF Healings 1"); 
    }
    
    private static function chakra_healing_balancing() {
        return new Courses("Chakra balancing program", self::CHAKRA_HEALING_BALANCING, 10, "Chakra balancing 1"); 
    }
    
    private static function certified_coach() {
        return new Courses("Twin Flames Coach program", self::CERTIFIED_COACH, 20, "Twin Flames Coach 1"); 
    }
    
    private static function certified_yoga_teacher() {
        return new Courses("Yoga Teacher Training program", self::CERTIFIED_YOGA_TEACHER, 10, "Yoga Teacher Training"); 
    }
    
    private static function shakti_kawach() {
        return new Courses("Shakti Kavach program", self::SHAKTI_KAWACH, 10, "Shakti Kavach"); 
    }
    
    private static function apprentice_basic_iw() {
        return new Courses("Apprentice - Basic IW", self::APPRENTICE_BASIC_IW, 20, "Apprenticeship Basic IW"); 
    }
    
    private static function apprentice_coach() {
        return new Courses("Apprentice - Twin Flames Coach", self::APPRENTICE_COACH, 10, "Apprenticeship TF Coach"); 
    }
    

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
            self::BASIC_IW_1 => self::basic_iw_1(),
            self::TFCIW => self::tfciw(),
            self::TFCAIW1 => self::tfcaiw1(),
            self::ADV_TF_HEALINGS_1 => self::advanced_tf_healings_1(),
            self::CHAKRA_HEALING_BALANCING => self::chakra_healing_balancing(),
            self::CERTIFIED_COACH => self::certified_coach(),
            self::CERTIFIED_YOGA_TEACHER => self::certified_yoga_teacher(),
            self::SHAKTI_KAWACH => self::shakti_kawach(),
            self::APPRENTICE_BASIC_IW => self::apprentice_basic_iw(),
            self::APPRENTICE_COACH => self::apprentice_coach(),
        );
        return $courses;
    }
    
}
>