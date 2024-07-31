<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Utils {
    public static function validate_form($data, $rules) {
        foreach ($rules as $field => $rule) {
            if ($rule === 'required' && empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

    public static function provide_feedback($message, $type = 'success') {
        ?>
        <div class="<?php echo $type; ?>">
            <p><?php echo $message; ?></p>
        </div>
        <?php
    }
}
