<?php

//TESIMONIALS

// register the new post type
register_post_type( 'testimonials', array( 
    'labels'                 => array(
        'name'               => __( 'Testimonials' ),
        'singular_name'      => __( 'Testimonial' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Testimonial' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Testimonial' ),
        'new_item'           => __( 'New Testimonial' ),
        'view'               => __( 'View Testimonials' ),
        'view_item'          => __( 'View Testimonial' ),
        'search_items'       => __( 'Search Testimonials' ),
        'not_found'          => __( 'No Testimonials found' ),
        'not_found_in_trash' => __( 'No Testimonials found in trash' ),
        'parent'             => __( 'Parent Testimonial' ),
    ),
    'description'           => __( 'Testimonials' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'publicly_queryable'  => false,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-awards',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    'query_var'             => true,
    'supports'              => array( 'title', 'editor', 'custom-fields', 'revisions' ),
) );

// register the new post type
register_post_type( 'partners', array( 
    'labels'                 => array(
        'name'               => __( 'Partners' ),
        'singular_name'      => __( 'Partner' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Partner' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Partner' ),
        'new_item'           => __( 'New Partner' ),
        'view'               => __( 'View Partners' ),
        'view_item'          => __( 'View Partner' ),
        'search_items'       => __( 'Search Partners' ),
        'not_found'          => __( 'No Partners found' ),
        'not_found_in_trash' => __( 'No Partners found in trash' ),
        'parent'             => __( 'Parent Partner' ),
    ),
    'description'           => __( 'Partners' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'publicly_queryable'  => false,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-admin-site',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    'query_var'             => true,
    'supports'              => array( 'title', 'custom-fields','thumbnail', 'revisions' ),
) );


//QUESTIONS

// register the new post type
register_post_type( 'questions', array( 
    'labels'                 => array(
        'name'               => __( 'Questions' ),
        'singular_name'      => __( 'Question' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Question' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Question' ),
        'new_item'           => __( 'New Question' ),
        'view'               => __( 'View Questions' ),
        'view_item'          => __( 'View Question' ),
        'search_items'       => __( 'Search Questions' ),
        'not_found'          => __( 'No Questions found' ),
        'not_found_in_trash' => __( 'No Questions found in trash' ),
        'parent'             => __( 'Parent Question' ),
    ),
    'description'           => __( 'Questions' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'publicly_queryable'  => false,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-editor-ul',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    'query_var'             => true,
    'supports'              => array( 'title', 'editor', 'custom-fields', 'revisions' ),
) );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_question_taxonomies', 0 );
//add_action('admin_init', 'flush_rewrite_rules');

//create two taxonomies, genres and writers for the post type "book"
function create_question_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Question Location', 'taxonomy general name' ),
        'singular_name'     => _x( 'Question Location', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search Question Locations' ),
        'all_items'         => __( 'All Question Locations' ),
        'parent_item'       => __( 'Parent Question Location' ),
        'parent_item_colon' => __( 'Parent Question Location:' ),
        'edit_item'         => __( 'Edit Question Location' ), 
        'update_item'       => __( 'Update Question Location' ),
        'add_new_item'      => __( 'Add New Question Location' ),
        'new_item_name'     => __( 'New Question Location Name' ),
        'menu_name'         => __( 'Question Location' ),
    );  

    register_taxonomy( 'question_location', array( 'questions' ), array(
        'hierarchical'  => true,
        'labels'        => $labels,
        'show_ui'       => true,
        'query_var'     => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
    ) );

}


//COACHES

// register the new post type
register_post_type( 'coaches', array( 
    'labels'                 => array(
        'name'               => __( 'Coaches' ),
        'singular_name'      => __( 'Coach' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Coach' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Coach' ),
        'new_item'           => __( 'New Coach' ),
        'view'               => __( 'View Coaches' ),
        'view_item'          => __( 'View Coach' ),
        'search_items'       => __( 'Search Coaches' ),
        'not_found'          => __( 'No Coaches found' ),
        'not_found_in_trash' => __( 'No Coaches found in trash' ),
        'parent'             => __( 'Parent Coach' ),
    ),
    'description'           => __( 'Coaches' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'publicly_queryable'  => false,
    'menu_position'         => 4,
    'menu_icon'             => 'dashicons-admin-users',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    'query_var'             => true,
    'supports'              => array( 'title', 'editor', 'custom-fields','thumbnail', 'revisions' ),
) );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_coach_taxonomies', 0 );
//add_action('admin_init', 'flush_rewrite_rules');

//create two taxonomies, genres and writers for the post type "book"
function create_coach_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Type', 'taxonomy general name' ),
        'singular_name'     => _x( 'Type', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search Type' ),
        'all_items'         => __( 'All Type' ),
        'parent_item'       => __( 'Parent Type' ),
        'parent_item_colon' => __( 'Parent Type:' ),
        'edit_item'         => __( 'Edit Type' ), 
        'update_item'       => __( 'Update Type' ),
        'add_new_item'      => __( 'Add New Type' ),
        'new_item_name'     => __( 'New Type Name' ),
        'menu_name'         => __( 'Type' ),
    );  

    register_taxonomy( 'coach_type', array( 'coaches' ), array(
        'hierarchical'  => true,
        'labels'        => $labels,
        'show_ui'       => true,
        'query_var'     => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
    ) );

}

///PLAYERS

// register the new post type
register_post_type( 'players', array( 
    'labels'                 => array(
        'name'               => __( 'Players' ),
        'singular_name'      => __( 'Player' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Player' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Player' ),
        'new_item'           => __( 'New Player' ),
        'view'               => __( 'View Players' ),
        'view_item'          => __( 'View Player' ),
        'search_items'       => __( 'Search Players' ),
        'not_found'          => __( 'No Players found' ),
        'not_found_in_trash' => __( 'No Players found in trash' ),
        'parent'             => __( 'Parent Player' ),
    ),
    'description'           => __( 'Players' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'publicly_queryable'  => false,
    'menu_position'         => 4,
    'menu_icon'             => 'dashicons-groups',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    'query_var'             => true,
    'supports'              => array( 'title', 'editor', 'custom-fields','thumbnail', 'revisions' ),
) );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_player_taxonomies', 0 );
//add_action('admin_init', 'flush_rewrite_rules');

//create two taxonomies, genres and writers for the post type "book"
function create_player_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Team', 'taxonomy general name' ),
        'singular_name'     => _x( 'Team', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search Teams' ),
        'all_items'         => __( 'All Teams' ),
        'parent_item'       => __( 'Parent Team' ),
        'parent_item_colon' => __( 'Parent Team:' ),
        'edit_item'         => __( 'Edit Team' ), 
        'update_item'       => __( 'Update Team' ),
        'add_new_item'      => __( 'Add New Team' ),
        'new_item_name'     => __( 'New Team Name' ),
        'menu_name'         => __( 'Team' ),
    );  

    register_taxonomy( 'team', array( 'players' ), array(
        'hierarchical'  => true,
        'labels'        => $labels,
        'show_ui'       => true,
        'query_var'     => true,
        'show_admin_column'     => true,
        'show_in_quick_edit' => false,
    ) );

    // Add new taxonomy, make it hierarchical (like categories)
    $sec_labels = array(
        'name'              => _x( 'Age Group', 'taxonomy general name' ),
        'singular_name'     => _x( 'Age Group', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search Age Groups' ),
        'all_items'         => __( 'All Age Groups' ),
        'parent_item'       => __( 'Parent Age Group' ),
        'parent_item_colon' => __( 'Parent Age Group:' ),
        'edit_item'         => __( 'Edit Age Group' ), 
        'update_item'       => __( 'Update Age Group' ),
        'add_new_item'      => __( 'Add New Age Group' ),
        'new_item_name'     => __( 'New Age Group Name' ),
        'menu_name'         => __( 'Age Group' ),
    );  

    register_taxonomy( 'age_group', array( 'players', 'teams' ), array(
        'hierarchical'  => true,
        'labels'        => $sec_labels,
        'show_ui'       => true,
        'query_var'     => true,
        'show_admin_column'     => true,
        'show_in_quick_edit' => false,
    ) );

    // Add new taxonomy, make it hierarchical (like categories)
    $third_labels = array(
        'name'              => _x( 'Alumni', 'taxonomy general name' ),
        'singular_name'     => _x( 'Alumni', 'taxonomy singular name' ),
        'search_items'      =>  __( 'Search Alumni' ),
        'all_items'         => __( 'All Alumni' ),
        'parent_item'       => __( 'Parent Alumni' ),
        'parent_item_colon' => __( 'Parent Alumni:' ),
        'edit_item'         => __( 'Edit Alumni' ), 
        'update_item'       => __( 'Update Alumni' ),
        'add_new_item'      => __( 'Add New Alumni' ),
        'new_item_name'     => __( 'New Alumni Name' ),
        'menu_name'         => __( 'Alumni' ),
    );  

    register_taxonomy( 'alumni', array( 'players' ), array(
        'hierarchical'  => true,
        'labels'        => $third_labels,
        'show_ui'       => true,
        'query_var'     => true,
        'show_admin_column'  => true,
        'show_in_quick_edit' => false,
        'show_in_menu' => false,
    ) );

}


add_action('admin_head', 'players_cpt_css');

function players_cpt_css() {
  echo '<style>
    #alumni-adder {
        display: none;
    }
    #alumni-tabs {
        display: none !important;
    }
    #alumnidiv h2::after {
        content: "*if selected, player will be removed from team";
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
  </style>';
}




/* teams */

// register the new post type
register_post_type( 'teams', array( 
    'labels'                 => array(
        'name'               => __( 'Teams' ),
        'singular_name'      => __( 'Team' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Create New Team' ),
        'edit'               => __( 'Edit' ),
        'edit_item'          => __( 'Edit Team' ),
        'new_item'           => __( 'New Team' ),
        'view'               => __( 'View Teams' ),
        'view_item'          => __( 'View Team' ),
        'search_items'       => __( 'Search Teams' ),
        'not_found'          => __( 'No Teams found' ),
        'not_found_in_trash' => __( 'No Teams found in trash' ),
        'parent'             => __( 'Parent Team' ),
    ),
    'description'           => __( 'Club One Teams' ),
    'public'                => true,
    'show_ui'               => true,
    'capability_type'       => 'post',
    'publicly_queryable'    => true,
    'exclude_from_search'   => true,
    'has_archive'           => false,
    'menu_position'         => 4,
    'menu_icon'             => 'dashicons-clipboard',
    'hierarchical'          => true,
    '_builtin'              => false, // It's a custom post type, not built in!
    //'rewrite'               => array( 'slug' => 'teams', 'with_front' => false ),
    //'rewrite'               => array( 'slug' => 'teams/%coach_type%-volleyball', 'with_front' => false ),
    'query_var'             => true,
    'supports'              => array( 'title', 'editor', 'custom-fields','thumbnail', 'revisions' ),
) );

// function team_rewrites( $post_link, $post ){
//     if ( is_object( $post ) && $post->post_type == 'teams' ){
//         $terms = wp_get_object_terms( $post->ID, 'coach_type' );
//         if( $terms ){
//             return str_replace( '%coach_type%' , $terms[0]->slug , $post_link );
//         }
//     }
//     return $post_link;
// }
// add_filter( 'post_type_link', 'team_rewrites', 1, 2 );




