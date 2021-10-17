<?php

defined( 'ABSPATH' ) || exit;
function wnbell_trigger_sort( $triggers, $trigger_array_element )
{
    $result = [];
    $i = 0;
    foreach ( $triggers as $key => $value ) {
        $new_date = ( array_key_exists( 'time', $trigger_array_element ) ? $trigger_array_element[$i]['time'] : strtotime( str_replace( "at", "", $trigger_array_element[$i]['date'] ) ) );
        $sorted_date = ( array_key_exists( 'time', $value ) ? $value['time'] : strtotime( str_replace( "at", "", $value['date'] ) ) );
        while ( $trigger_array_element[$i] && $new_date > $sorted_date ) {
            $result[] = $trigger_array_element[$i++];
        }
        $result[] = $value;
    }
    $result = array_merge( $result, array_slice( $trigger_array_element, $i ) );
    return $result;
}

function wnbell_seen_notification_ajax()
{
    check_ajax_referer( 'wnbell_ajax' );
    if ( isset( $_POST['notificationID'] ) ) {
        
        if ( sanitize_text_field( $_POST["notificationID"] ) != '' ) {
            $notification_id = sanitize_text_field( $_POST["notificationID"] );
            
            if ( !isset( $_POST['notification_type'] ) || sanitize_text_field( $_POST["notification_type"] ) === '' ) {
                // $wnbell_view_count = get_post_meta($notification_id, "wnbell_view_count", true);
                // if ($wnbell_view_count) {
                //     update_post_meta($notification_id, "wnbell_view_count", $wnbell_view_count + 1);
                // }
                $current_user_id = get_current_user_id();
                $seen_posts = get_user_meta( $current_user_id, 'wnbell_seen_notification_post', true );
                if ( !$seen_posts ) {
                    $seen_posts = array();
                }
                if ( in_array( $notification_id, $seen_posts ) ) {
                    die;
                }
                array_unshift( $seen_posts, $notification_id );
                if ( sizeof( $seen_posts ) > 20 ) {
                    $removed = array_pop( $seen_posts );
                }
                update_user_meta( $current_user_id, 'wnbell_seen_notification_post', $seen_posts );
            } else {
                // if (sanitize_text_field($_POST["notificationID"]) != '') {
                // $notification_id = sanitize_text_field($_POST["notificationID"]);
                // $wnbell_view_count = get_post_meta($notification_id, "wnbell_view_count", true);
                // if ($wnbell_view_count) {
                //     update_post_meta($notification_id, "wnbell_view_count", $wnbell_view_count + 1);
                // }
                $notification_type = sanitize_text_field( $_POST["notification_type"] );
                
                if ( $notification_type === 'comment' ) {
                    $current_user_id = get_current_user_id();
                    $seen_comments = get_user_meta( $current_user_id, 'wnbell_seen_comments_ids', true );
                    if ( !$seen_comments ) {
                        $seen_comments = array();
                    }
                    if ( in_array( $notification_id, $seen_comments ) ) {
                        die;
                    }
                    array_unshift( $seen_comments, $notification_id );
                    if ( sizeof( $seen_comments ) > 20 ) {
                        $removed = array_pop( $seen_comments );
                    }
                    update_user_meta( $current_user_id, 'wnbell_seen_comments_ids', $seen_comments );
                } elseif ( $notification_type === 'bbp' ) {
                    $current_user_id = get_current_user_id();
                    $seen_bbp = get_user_meta( $current_user_id, 'wnbell_seen_bbp_ids', true );
                    if ( !$seen_bbp ) {
                        $seen_bbp = array();
                    }
                    if ( in_array( $notification_id, $seen_bbp ) ) {
                        die;
                    }
                    array_unshift( $seen_bbp, $notification_id );
                    if ( sizeof( $seen_bbp ) > 20 ) {
                        $removed = array_pop( $seen_bbp );
                    }
                    update_user_meta( $current_user_id, 'wnbell_seen_bbp_ids', $seen_bbp );
                } elseif ( $notification_type === 'woocommerce' ) {
                    $current_user_id = get_current_user_id();
                    $seen_woocommerce = get_user_meta( $current_user_id, 'wnbell_seen_woocommerce_ids', true );
                    if ( !$seen_woocommerce ) {
                        $seen_woocommerce = array();
                    }
                    if ( in_array( $notification_id, $seen_woocommerce ) ) {
                        die;
                    }
                    array_unshift( $seen_woocommerce, $notification_id );
                    if ( sizeof( $seen_woocommerce ) > 20 ) {
                        $removed = array_pop( $seen_woocommerce );
                    }
                    update_user_meta( $current_user_id, 'wnbell_seen_woocommerce_ids', $seen_woocommerce );
                }
                
                do_action( 'wnbell_add_unseen', $notification_id, $notification_type );
            }
        
        }
    
    }
    die;
}

function wnbell_replace_placeholders( $content, $post_id )
{
    $new_post = get_post_meta( $post_id, "post_id", true );
    $to_replace = array(
        '{{date}}'       => get_the_date( 'l j M Y', $post_id ),
        '{{human_date}}' => sprintf( _x( '%1$s ago', '%2$s = human-readable time difference', 'wp-notification-bell' ), human_time_diff( get_post_time( 'U', false, $post_id ), current_time( 'timestamp' ) ) ),
        '{{time}}'       => get_the_date( 'H:i', $post_id ),
        '{{post_title}}' => ( $new_post ? get_the_title( $new_post ) : '' ),
    );
    $to_replace = apply_filters( 'wnbell_content_placeholders', $to_replace, $post_id );
    foreach ( $to_replace as $placeholder => $value ) {
        $content = str_replace( $placeholder, $value, $content );
    }
    return $content;
}

function wnbell_escape_array( $arr )
{
    global  $wpdb ;
    $escaped = array();
    foreach ( $arr as $k => $v ) {
        
        if ( is_numeric( $v ) ) {
            $escaped[] = $wpdb->prepare( '%d', $v );
        } else {
            $escaped[] = $wpdb->prepare( '%s', $v );
        }
    
    }
    return implode( ',', $escaped );
}

function wnbell_update_user_count( $user = "" )
{
    $value_total = get_user_meta( $user, 'wnbell_unseen', true );
    if ( !$value_total ) {
        $value_total = 0;
    }
    update_user_meta( $user, 'wnbell_unseen', $value_total + 1 );
}

// $type user notification type, 1 for comment replies, 2 for post authors comments
function wnbell_update_user_notification( $user_id = "", $type = 0, $new_user_meta = array() )
{
    
    if ( $type == 1 || $type == 2 ) {
        $user_meta = get_user_meta( $user_id, 'wnbell_unseen_comments', true );
        if ( !$user_meta ) {
            $user_meta = array();
        }
        
        if ( $type == 1 ) {
            $new_user_meta['type'] = 'cfc';
        } elseif ( $type == 2 ) {
            $new_user_meta['type'] = 'cfa';
        }
        
        array_unshift( $user_meta, $new_user_meta );
        if ( sizeof( $user_meta ) > 20 ) {
            $removed = array_pop( $user_meta );
        }
        update_user_meta( $user_id, 'wnbell_unseen_comments', $user_meta );
    }

}
