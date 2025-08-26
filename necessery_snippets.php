<?php 

 /**
     * Get countries list, prefer WooCommerce's list, fallback to a minimal set.
     *
     * @return array
     */
    private function get_countries() {
        if (class_exists('\WC_Countries')) {
            $wc_countries = new \WC_Countries();
            return $wc_countries->get_countries();
        }

        return [
            'BD' => __('Bangladesh', 'wp-phone-validator'),
            'IN' => __('India', 'wp-phone-validator'),
            'US' => __('United States', 'wp-phone-validator'),
            'GB' => __('United Kingdom', 'wp-phone-validator'),
            'PK' => __('Pakistan', 'wp-phone-validator'),
        ];
    }
