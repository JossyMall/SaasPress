<?php
class SaasPress_DB {
    private $wpdb;

    public function __construct($wpdb) {
        $this->wpdb = $wpdb;
    }

    public function execute($query) {
        return $this->wpdb->query($query);
    }

    public function get_results($query) {
        return $this->wpdb->get_results($query);
    }

    public function get_var($query) {
        return $this->wpdb->get_var($query);
    }
}

