<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if (!class_exists('WP_List_Table')) 
{
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class softech_form_List_Table extends WP_List_Table
{
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'softech-form', //singular name of the listed records
            'plural' => 'softech-forms', //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ));
    }

    function column_default($item, $column_name)
    {
        switch($column_name)
        {
            case 'shortcode':
            case 'date':
            return $item[$column_name];
            default:
            return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_date($item)
    {
        return '<em>' . $item['date'] . '</em>'; 
    }

    function column_name($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=softech-new-form&form_id=%s">%s</a>', $item['id'], __('Edit', 'softech-form-builder')),
            'delete' => sprintf( '<a href="%s&action=%s&id=%s">%s</a>', wp_nonce_url( admin_url( 'admin.php?page=softech-form-builder-list' ), $item['id'] ), 'delete', $item['id'], __( 'Delete', 'softech-form-builder' ) ),
        );

        return sprintf('%s %s',
            $item['name'],
            $this->row_actions($actions)
        );
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Form Name', 'softech-form-builder'),
            'shortcode' => __('Shortcode', 'softech-form-builder'),
            'date' => __('Created Date', 'softech-form-builder'),
        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array('name', true),
            'shortcode' => array('shortcode', true),
            'date' => array('date', true),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'softech_forms'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'softech_forms'; // do not forget about tables prefix

        $per_page = 10; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}

function softech_forms_screen_option_list() 
{
    global $softech_screen_hook;
    $screen = get_current_screen();
 
    // get out of here if we are not on our settings page
    if(!is_object($screen) || $screen->id != $softech_screen_hook)
        return;
 
    $args = array(
        'label' => __('Softech Forms per page', 'softech-form-builder'),
        'default' => 10,
        'option' => 'softech-form-builder_per_page'
    );
    add_screen_option( 'per_page', $args );
}

function softech_forms_set_screen_option($status, $option, $value) 
{
    if ( 'softech_form_builder_per_page' == $option ) return $value;
}
add_filter('set-screen-option', 'softech_forms_set_screen_option', 10, 3);

function softech_form_builder_list()
{
    global $wpdb;

    $table = new softech_form_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'softech-form-builder'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
<div class="wrap">


    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h1><?php _e('Softech Forms', 'softech-form-builder')?> <a class="add-new-h2"
                                 href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=softech-new-form');?>"><?php _e('Add new Form', 'softech-form-builder')?></a>
    </h1>
    <?php echo $message; ?>

    <form id="softech-form-builder-table" method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $table->display() ?>
    </form>

</div>
<?php
}
?>