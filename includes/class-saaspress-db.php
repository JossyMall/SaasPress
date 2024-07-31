<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_DB {
    private static $connections = [];

    public static function get_connection($database) {
        if (isset(self::$connections[$database])) {
            return self::$connections[$database];
        }

        $credentials = self::get_db_credentials($database);
        if (!$credentials) {
            return false;
        }

        $db_connection = new wpdb(
            $credentials['username'],
            $credentials['password'],
            $credentials['database'],
            $credentials['host']
        );

        if ($db_connection->has_errors()) {
            return false;
        }

        self::$connections[$database] = $db_connection;
        return $db_connection;
    }

    private static function get_db_credentials($database) {
        $databases = get_option('saaspress_database_settings', []);
        foreach ($databases as $db) {
            if ($db['database'] === $database) {
                return $db;
            }
        }
        return false;
    }

    public static function switch_to_database($database) {
        global $wpdb;
        $db_connection = self::get_connection($database);
        if ($db_connection) {
            $wpdb = $db_connection;
            return true;
        }
        return false;
    }
}
