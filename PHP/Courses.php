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

    private static $basic_iw_1 = null;
    public static function getBasicIw1()
    {
        return self::$basic_iw_1 ?? self::$basic_iw_1 = new Courses("Basic inner work 1", self::BASIC_IW_1, "Basic IW 1");
    }

    private static $tfciw = null;
    public static function getTfciw()
    {
        return self::$tfciw ?? self::$tfciw = new Courses("Basic inner work 2", self::TFCIW, "Basic IW 2");
    }

    private static $tfcaiw1 = null;
    public static function getTfcaiw1()
    {
        return self::$tfcaiw1 ?? self::$tfcaiw1 = new Courses("Advanced inner work 1", self::TFCAIW1, "Advanced IW 1");
    }

    private static $advanced_tf_healings_1 = null;
    public static function getAdvancedTfHealings1()
    {
        return self::$advanced_tf_healings_1 ?? self::$advanced_tf_healings_1 = new Courses("Advanced Twin Flame Healings 1", self::ADV_TF_HEALINGS_1, "Advanced TF Healings 1");
    }

    private static $chakra_healing_balancing = null;
    public static function getChakraHealingBalancing()
    {
        return self::$chakra_healing_balancing ?? self::$chakra_healing_balancing = new Courses("Chakra balancing program", self::CHAKRA_HEALING_BALANCING, "Chakra balancing 1");
    }

    private static $certified_coach = null;
    public static function getCertifiedCoach()
    {
        return self::$certified_coach ?? self::$certified_coach = new Courses("Twin Flames Coach program", self::CERTIFIED_COACH, "Twin Flames Coach 1");
    }

    private static $certified_yoga_teacher = null;
    public static function getCertifiedYogaTeacher()
    {
        return self::$certified_yoga_teacher ?? self::$certified_yoga_teacher = new Courses("Yoga Teacher Training program", self::CERTIFIED_YOGA_TEACHER, "Yoga Teacher Training");
    }

    private static $shakti_kawach = null;
    public static function getShaktiKawach()
    {
        return self::$shakti_kawach ?? self::$shakti_kawach = new Courses("Shakti Kavach program", self::SHAKTI_KAWACH, "Shakti Kavach");
    }

    private static $apprentice_basic_iw = null;
    public static function getApprenticeBasicIw()
    {
        return self::$apprentice_basic_iw ?? self::$apprentice_basic_iw = new Courses("Apprentice - Basic IW", self::APPRENTICE_BASIC_IW, "Apprenticeship Basic IW");
    }
    
    public $courseName;
    public $courseRoleName;
    public $courseCompletionCouponForDiscount; //course completion discount can be applied from a coupon mentioned here
    
    public function __construct($name, $roleName, $completionCouponForDiscount) {
        $this->courseName = $name;
        $this->courseRoleName = $roleName;
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