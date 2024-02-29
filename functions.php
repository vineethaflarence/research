<?php
/**
 * Theme Functions.
 */

/* Theme Setup */
// Enqueue your stylesheet
// Example: Registering a navigation menu
function mytheme_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mytheme'),
        'footer'  => __('Footer Menu', 'mytheme'),
    ));
}
add_action('init', 'mytheme_register_menus');
function mytheme_enqueue_styles() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');
function enqueue_custom_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    // Additional styles can be enqueued here
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
function remove_edit_link($link) {
    return '';
}
add_filter('edit_post_link', 'remove_edit_link');

add_theme_support( 'post-thumbnails' );

function custom_register_post_type() {
    $labels = array(
        'name'               => _x( 'Events', 'post type general name', 'your-text-domain' ),
        'singular_name'      => _x( 'Event', 'post type singular name', 'your-text-domain' ),
        'menu_name'          => _x( 'Events', 'admin menu', 'your-text-domain' ),
        'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'your-text-domain' ),
        'add_new'            => _x( 'Add New', 'event', 'your-text-domain' ),
        'add_new_item'       => __( 'Add New Event', 'your-text-domain' ),
        'new_item'           => __( 'New Event', 'your-text-domain' ),
        'edit_item'          => __( 'Edit Event', 'your-text-domain' ),
        'view_item'          => __( 'View Event', 'your-text-domain' ),
        'all_items'          => __( 'All Events', 'your-text-domain' ),
        'search_items'       => __( 'Search Events', 'your-text-domain' ),
        'parent_item_colon'  => __( 'Parent Events:', 'your-text-domain' ),
        'not_found'          => __( 'No events found.', 'your-text-domain' ),
        'not_found_in_trash' => __( 'No events found in Trash.', 'your-text-domain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'event' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    );

    register_post_type( 'event', $args );
}

add_action( 'init', 'custom_register_post_type' );

function api_data_table_shortcode($atts) {
    ob_start(); // Start output buffering

    ?>
    <div id="api-data-table"></div>

    <script>
        // Function to fetch data from the API and render the table
        function fetchAndRenderTable() {
            // API endpoint
            var apiEndpoint = 'https://ims-dev.iiit.ac.in/research_apis.php?typ=getPublications&yy=2022';

            // Fetch data from the API
            fetch(apiEndpoint)
                .then(response => response.json())
                .then(data => {
                    // Generate HTML for the table
                    var tableHtml = '<table border="1">';
                    tableHtml += '<thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>';
                    tableHtml += '<tbody>';

                    // Loop through the data and add rows to the table
                    data.forEach(item => {
                        tableHtml += '<tr>';
                        tableHtml += '<td>' + item.year + '</td>';
                        tableHtml += '<td>' + item.Title + '</td>';
                        tableHtml += '<td>' + item.Type + '</td>';
						tableHtml += '<td>' + item.Core + '</td>';
						tableHtml += '<td>' + item.Authors + '</td>';
                        tableHtml += '</tr>';
                    });

                    tableHtml += '</tbody>';
                    tableHtml += '</table>';

                    // Display the table in the designated div
                    document.getElementById('api-data-table').innerHTML = tableHtml;
                })
                .catch(error => {
                    console.error('Error fetching data from the API:', error);
                });
        }

        // Call the function to fetch and render the table when the page loads
        document.addEventListener('DOMContentLoaded', fetchAndRenderTable);
    </script>
    <?php

    return ob_get_clean(); // Return the buffered content
}

// Add a shortcode to use on a page or post
add_shortcode('api_data_table', 'api_data_table_shortcode');

function api_data_shortcode() {
    $apiUrl = 'https://ims-dev.iiit.ac.in/research_apis.php?typ=getEvents';
    $response = wp_remote_get($apiUrl);

    // Check if the request was successful
    if (is_array($response) && !is_wp_error($response)) {
        $api_data = json_decode(wp_remote_retrieve_body($response), true);

        // Display the data
        ob_start();
        if (!empty($api_data)) {
            echo '<div class="container"><div class="row">';

            foreach ($api_data as $event) {
                echo '<div class="card col-lg-3 col-md-3 col-sm-12"> 
                        <img src="' . $event['photo'] . '" style="width:100%;height:200px;" class="img-fluid" alt="Event Image">
                        <div class="date-content btn btn-primary " style="width:50px;height:50px;text-align:center;font-size: 12px;font-weight:bold;margin-bottom:-30px;">
                            <p>' . $event['startdate'] . '</p>
                            <p>' . $event['enddate'] . '</p>
                        </div>
                        <div class="info-content">
                            <p style="font-size:20px;font-weight:bold">' . $event['title'] . '</p>
                            <p>' . $event['description'] . '</p>
                        </div>
                      </div>';
            }

            echo '</div></div>';
        } else {
            echo 'No events found.';
        }

        return ob_get_clean();
    } else {
        return 'Error fetching API data.';
    }
}

add_shortcode('api_data', 'api_data_shortcode');

flush_rewrite_rules();
function custom_enqueue_styles() {
    if (function_exists('wp_pagenavi')) {
        wp_enqueue_style('wp-pagenavi');
    }
}
add_action('wp_enqueue_scripts', 'custom_enqueue_styles');

function fetch_and_display_events() {
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // Your API code to fetch data
    $apiUrl = 'https://ims.iiit.ac.in/research_apis.php?typ=getTalks';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $json_string = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        exit; // Terminate the script if cURL error occurs
    }

    curl_close($ch);

    $data = json_decode($json_string, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo 'Error decoding JSON: ' . json_last_error_msg();
        exit; // Terminate the script if JSON decoding error occurs
    }

    $currentDate = date('Y-m-d');
    $currentYear = date('Y');
    $upcomingEvents = [];
    $previousEvents = [];

    foreach ($data as $event) {
        $eventStartDate = $event['startdate'];
        $eventEndDate = $event['enddate'];

        if ($eventEndDate >= $currentDate) {
            if ($eventStartDate >= $currentDate && date('Y', strtotime($eventStartDate)) == $currentYear) {
                $upcomingEvents[] = $event;
            } else {
                $previousEvents[] = $event;
            }
        } else {
            $previousEvents[] = $event;
        }
    }

    $args = array(
        'post_type' => 'your_custom_post_type',
        'posts_per_page' => 4,
        'paged' => $paged,
        // Add other query parameters as needed
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="row">';
        while ($query->have_posts()) : $query->the_post();
            // Your event card and modal code here
            include 'event-card-template.php'; // Create a separate file for your event card template
        endwhile;
        echo '</div>';

        // Pagination
        echo '<div class="pagination">';
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
        ));
        echo '</div>';

        wp_reset_postdata();
    }
}

add_action('init', 'fetch_and_display_events'); // You can adjust the hook as needed

function custom_search_redirect() {
    // Check if the search query exists and the current page is the search results page
    if (is_search() && !empty($_GET['search'])) {
        // Redirect to the publications page with the search query
        wp_redirect(home_url('/publications/?search=' . urlencode(get_query_var('s'))));
        exit();
    }
}
add_action('template_redirect', 'custom_search_redirect');

?>