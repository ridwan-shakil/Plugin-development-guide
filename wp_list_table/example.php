<?php

/**
 * Plugin Name: RS Students Table
 * Description: A complete WP_List_Table example with pagination, search, and bulk actions using the students database table.
 * Version: 1.0
 * Author: MD. Ridwan
 * License: GPLv2 or later
 * Text Domain: rs-students-table
 */

if (!defined('ABSPATH')) exit;

// Load WP_List_Table class if not already loaded
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

// Extend wp_list_table class to create your own data table 
class RS_Students_List_Table extends WP_List_Table {

    private $students_data = [];
    private $total_items = 0;

    public function __construct() {
        parent::__construct([
            'singular' => 'Student',
            'plural'   => 'Students',
            'ajax'     => false
        ]);
    }

    // Define columns
    public function get_columns() {
        return [
            'cb'         => '<input type="checkbox" />',
            'id'         => __('ID', 'rs-students-table'),
            'name'       => __('Name', 'rs-students-table'),
            'email'      => __('Email', 'rs-students-table'),
            'created_at' => __('Created At', 'rs-students-table')
        ];
    }

    // Make sortable columns
    public function get_sortable_columns() {
        return [
            'id'         => ['id', false],
            'name'       => ['name', false],
            'email'      => ['email', false],
            'created_at' => ['created_at', false],
        ];
    }

    // Bulk action checkbox per row
    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="student_ids[]" value="%s" />', esc_attr($item['id']));
    }

    // Render other columns
    public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? esc_html($item[$column_name]) : '';
    }

    // Render ID column with Delete action link
    public function column_id($item) {
        $delete_url = add_query_arg([
            'action' => 'rs_delete',
            'id' => absint($item['id']),
            '_wpnonce' => wp_create_nonce('rs_delete_' . $item['id'])
        ]);

        $actions = [
            'delete' => sprintf('<a href="%s" onclick="return confirm(\'Are you sure you want to delete this student?\');" style="color:red">%s</a>', esc_url($delete_url), __('Delete', 'rs-students-table')),
        ];

        return sprintf('<strong>#%d</strong> %s', $item['id'], $this->row_actions($actions));
    }

    // Define bulk actions
    public function get_bulk_actions() {
        return [
            'delete' => __('Delete', 'rs-students-table'),
        ];
    }

    // Process bulk actions
    public function process_bulk_action() {
        global $wpdb;
        $table = $wpdb->prefix . 'students';

        if ($this->current_action() === 'delete' && !empty($_POST['student_ids'])) {
            $ids = array_map('absint', $_POST['student_ids']);
            $placeholders = implode(',', array_fill(0, count($ids), '%d'));
            $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id IN ($placeholders)", ...$ids));

            wp_redirect(remove_query_arg(['action', 'action2', 'student_ids']));
            exit;
        }
    }

    // Prepare table items
    public function prepare_items() {
        global $wpdb;
        $table = $wpdb->prefix . 'students';

        // Handle bulk delete
        $this->process_bulk_action();

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $search = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        $orderby = isset($_REQUEST['orderby']) ? sanitize_sql_orderby($_REQUEST['orderby']) : 'id';
        $order = isset($_REQUEST['order']) && strtolower($_REQUEST['order']) === 'asc' ? 'ASC' : 'DESC';

        if (!empty($search)) {
            // Count matching records
            $this->total_items = $wpdb->get_var(
                $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE name LIKE %s OR email LIKE %s", "%$search%", "%$search%")
            );

            // Fetch filtered data
            $this->students_data = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM $table WHERE name LIKE %s OR email LIKE %s ORDER BY $orderby $order LIMIT %d OFFSET %d",
                    "%$search%",
                    "%$search%",
                    $per_page,
                    $offset
                ),
                ARRAY_A
            );
        } else {
            // Count all records
            $this->total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table");

            // Fetch all data paginated
            $this->students_data = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM $table ORDER BY $orderby $order LIMIT %d OFFSET %d",
                    $per_page,
                    $offset
                ),
                ARRAY_A
            );
        }

        // Handle row actions
        $this->maybe_handle_row_actions();

        // Set pagination
        $this->set_pagination_args([
            'total_items' => $this->total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($this->total_items / $per_page),
        ]);

        $this->items = $this->students_data;
        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
    }

    // Handle row delete link
    protected function maybe_handle_row_actions() {
        global $wpdb;
        $table = $wpdb->prefix . 'students';

        if (!isset($_GET['action'], $_GET['id'], $_GET['_wpnonce']) || !is_admin() || !current_user_can('manage_options')) {
            return;
        }

        $id = absint($_GET['id']);
        $action = sanitize_key($_GET['action']);
        $nonce = $_GET['_wpnonce'];

        if ($action === 'rs_delete' && wp_verify_nonce($nonce, 'rs_delete_' . $id)) {
            $wpdb->delete($table, ['id' => $id]);
            wp_redirect(remove_query_arg(['action', 'id', '_wpnonce']));
            exit;
        }
    }
}

// On plugin activation, create students table if not exists
register_activation_hook(__FILE__, 'create_students_table');
function create_students_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'students';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Add menu to admin dashboard
function rs_register_students_menu() {
    add_menu_page(
        __('Students Table', 'rs-students-table'),
        __('Students Table', 'rs-students-table'),
        'manage_options',
        'rs-students-table',
        'rs_render_students_table_page',
        'dashicons-welcome-learn-more',
        26
    );
}
add_action('admin_menu', 'rs_register_students_menu');

// Render admin page with add form and students table
function rs_render_students_table_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'students';

    // Handle new student submission
    if (isset($_POST['rs_add_student'])) {
        if (!isset($_POST['rs_student_nonce']) || !wp_verify_nonce($_POST['rs_student_nonce'], 'rs_add_student_action')) {
            echo '<div class="notice notice-error"><p>Nonce verification failed.</p></div>';
        } else {
            $name = sanitize_text_field($_POST['student_name']);
            $email = sanitize_email($_POST['student_email']);

            if (empty($name) || empty($email)) {
                echo '<div class="notice notice-error"><p>Name and Email are required.</p></div>';
            } elseif (!is_email($email)) {
                echo '<div class="notice notice-error"><p>Invalid email address.</p></div>';
            } else {
                $inserted = $wpdb->insert($table, [
                    'name' => $name,
                    'email' => $email,
                ]);

                if ($inserted) {
                    echo '<div class="notice notice-success"><p>Student added successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Failed to insert student.</p></div>';
                }
            }
        }
    }

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Students List', 'rs-students-table') . '</h1>';
    ?>
    <h2><?php _e('Add New Student', 'rs-students-table'); ?></h2>
    <form method="post">
        <?php wp_nonce_field('rs_add_student_action', 'rs_student_nonce'); ?>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="student_name">Name</label></th>
                    <td><input name="student_name" type="text" id="student_name" value="" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="student_email">Email</label></th>
                    <td><input name="student_email" type="email" id="student_email" value="" class="regular-text" required></td>
                </tr>
            </tbody>
        </table>
        <p><input type="submit" name="rs_add_student" class="button button-primary" value="<?php esc_attr_e('Add Student', 'rs-students-table'); ?>"></p>
    </form>
    <hr style="margin-top: 40px;">
    <?php
    // Display student list table
    $table = new RS_Students_List_Table();
    $table->prepare_items();

    echo '<form method="post">';
    $table->search_box(__('Search Students', 'rs-students-table'), 'student-search');
    $table->display();
    echo '</form>';
    echo '</div>';
}
