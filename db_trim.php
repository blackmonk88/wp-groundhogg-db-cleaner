<?php
/*
 * DB cleaner for very big Groundhogg AWS SES logs
 * Author : Fany Siswanto <blackmonk88@gmail.com>
 */

// config defined here
$trim_interval = '1 month';

// Load WordPress
define('WP_USE_THEMES', false);

require_once('wp-load.php');
global $wpdb;

$query_trim_aws_email_queue = "DELETE FROM `{$wpdb->prefix}gh_aws_email_queue` WHERE `status` = 'failed' AND `time` <= NOW() - INTERVAL {$trim_interval};";

// Execute trim
$trim_aws_email_queue_rows = $wpdb->query($query_trim_aws_email_queue);

if ($trim_aws_email_queue_rows === false) {
    echo "An error occurred while deleting AWS Email Queues.<br />";
} else {
    echo "AWS Email Queue: $trim_aws_email_queue_rows rows deleted successfully.<br />";
}

// Execute optimize table
$query_optimize_aws_email_queue = "OPTIMIZE TABLE `{$wpdb->prefix}gh_aws_email_queue`;";
$optimize_aws_email_queue       = $wpdb->query($query_optimize_aws_email_queue);
