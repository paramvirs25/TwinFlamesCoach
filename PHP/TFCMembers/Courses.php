<?php
namespace TFCMembers;

/*This class lists all our courses and respective course details like course completion role name and course completion discount*/
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
    const KRIYA_KUNDALINI_TEACHER = "kriya_kundalini_teacher"; // this course is not conducted by us. Only use it in inner work progress meter

    private static $courses = [
        self::BASIC_IW_1 => ["Basic inner work 1", self::BASIC_IW_1, "Basic IW 1", 14],
        self::TFCIW => ["Basic inner work 2", self::TFCIW, "Basic IW 2", 24],
        self::TFCAIW1 => ["Advanced inner work 1", self::TFCAIW1, "Advanced IW 1", 0],
        self::ADV_TF_HEALINGS_1 => ["Advanced Twin Flame Healings 1", self::ADV_TF_HEALINGS_1, "Advanced TF Healings 1", 0],
        self::CHAKRA_HEALING_BALANCING => ["Chakra balancing program", self::CHAKRA_HEALING_BALANCING, "Chakra balancing 1", 0],
        self::CERTIFIED_COACH => ["Twin Flames Coach program", self::CERTIFIED_COACH, "Twin Flames Coach 1", 54],
        self::CERTIFIED_YOGA_TEACHER => ["Yoga Teacher Training program", self::CERTIFIED_YOGA_TEACHER, "Yoga Teacher Training", 0],
        self::SHAKTI_KAWACH => ["Shakti Kavach program", self::SHAKTI_KAWACH, "Shakti Kavach", 0],
        self::APPRENTICE_BASIC_IW => ["Apprentice - Basic IW", self::APPRENTICE_BASIC_IW, "Apprenticeship Basic IW", 8],
        self::APPRENTICE_COACH => ["Apprentice - Twin Flames Coach", self::APPRENTICE_COACH, "Apprenticeship TF Coach", 0],
        self::KRIYA_KUNDALINI_TEACHER => ["Kriya Kundalini Teacher", self::KRIYA_KUNDALINI_TEACHER, "Kriya Kundalini Teacher", 0],
    ];

    private static $instances = [];

    public $courseName;
    public $courseRoleName;
    public $courseCompletionCouponForDiscount; //course completion discount can be applied from a coupon mentioned here
    public $tfcIWProgressPercentage;

    private function __construct($name, $roleName, $completionCouponForDiscount, $tfcIWProgressPercentage) {
        $this->courseName = $name;
        $this->courseRoleName = $roleName;
        $this->courseCompletionCouponForDiscount = $completionCouponForDiscount;
        $this->tfcIWProgressPercentage = $tfcIWProgressPercentage;
    }

    public static function getCourse($key) {
        if (!isset(self::$courses[$key])) {
            throw new \Exception("Invalid course key: $key");
        }

        if (!isset(self::$instances[$key])) {
            [$name, $roleName, $completionCouponForDiscount, $tfcIWProgressPercentage] = self::$courses[$key];
            self::$instances[$key] = new self($name, $roleName, $completionCouponForDiscount, $tfcIWProgressPercentage);
        }

        return self::$instances[$key];
    }

    public static function getAllCourses() {
        return array_map(function($key) {
            return self::getCourse($key);
        }, array_keys(self::$courses));
    }

    public static function getCoursesListForSupportCoaches() {
        $keys = [
            self::BASIC_IW_1,
            self::TFCIW,
            self::ADV_TF_HEALINGS_1,
            self::CERTIFIED_COACH,
            self::APPRENTICE_BASIC_IW,
        ];

        return self::getCoursesByKeys($keys);
    }

    public static function getCoursesListForTFCIWProgress() {
        $keys = [
            self::BASIC_IW_1,
            self::TFCIW,
            self::CERTIFIED_COACH,
            self::APPRENTICE_BASIC_IW,
        ];

        return self::getCoursesByKeys($keys);
    }

    private static function getCoursesByKeys(array $keys) {
        return array_map(function($key) {
            return self::getCourse($key);
        }, $keys);
    }
}
