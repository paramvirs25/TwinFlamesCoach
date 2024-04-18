<?php
namespace TFCMembers;

class FreeFollowUpConsultationManager {

    const CONSULTATION_COUNT = "tfc_free_followup_consultation_count";
    
    /**
     * Grant free consultations to a user.
     * 
     * @param int $user_id User ID to grant consultations.
     * @param int $count Number of consultations to grant.
     */
    public static function grantFreeConsultations( $user_id ) {
        $count = self::getRemainingConsultations( $user_id );
        $count++;
        update_user_meta( $user_id, self::CONSULTATION_COUNT, $count );

        //Retrieving Consultation Count
		$remaining_count = FreeFollowUpConsultationManager::getRemainingConsultations( $user_id );
		return $remaining_count;
    }

    /**
     * Retrieve the count of remaining free consultations for a user.
     * 
     * @param int $user_id User ID to retrieve count.
     * @return int Number of remaining free consultations.
     */
    public static function getRemainingConsultations( $user_id ) {
        return (int) get_user_meta( $user_id, self::CONSULTATION_COUNT, true );
    }

    /**
     * Use a free consultation for a user.
     * 
     * @param int $user_id User ID to use consultation.
     */
    public static function useConsultation( $user_id ) {
        $count = self::getRemainingConsultations( $user_id );
        if ( $count > 0 ) {
            $count--;
            update_user_meta( $user_id, self::CONSULTATION_COUNT, $count );
        }
    }
}