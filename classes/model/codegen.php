<?php

/**
 * Database interface class for the promo code generator
 */
class Model_Codegen extends Model
{

    /**
     * Get all promo codes from the system
     * @return array
     */
    public function get_existing_promo_codes_as_array() {
        return DB::select('code')->from('promo_codes')->execute()->as_array();
    }

    /**
     * Puts generated promo codes into the database
     * @param array $codes
     * @return Database result object
     */
    public function put_generated_codes_into_database(Array $codes) {
        $query = DB::insert('promo_codes', array('code'));
        foreach ($codes as $code) {
            $query->values($code);
        }
        return $query->execute();
    }

    /**
     * Get all unprinted promo codes
     * @return Database result object
     */
    public function get_unprinted_promo_codes() {
        return DB::select('code')->from('promo_codes')->where('used', '=', 0)->execute();
    }

}
