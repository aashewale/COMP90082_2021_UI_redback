<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

 if ( ! defined( 'ABSPATH' ) ) { exit; } class FS_User_Lock { private $_wp_user_id; private $_thread_id; private static $_instance; static function instance() { if ( ! isset( self::$_instance ) ) { self::$_instance = new self(); } return self::$_instance; } private function __construct() { $this->_wp_user_id = Freemius::get_current_wp_user_id(); $this->_thread_id = mt_rand( 0, 32000 ); } function try_lock( $expiration = 0 ) { if ( $this->is_locked() ) { return false; } set_site_transient( "locked_{$this->_wp_user_id}", $this->_thread_id, $expiration ); if ( $this->has_lock() ) { set_site_transient( "locked_{$this->_wp_user_id}", true, $expiration ); return true; } return false; } function lock( $expiration = 0 ) { set_site_transient( "locked_{$this->_wp_user_id}", true, $expiration ); } function is_locked() { return ( false !== get_site_transient( "locked_{$this->_wp_user_id}" ) ); } function unlock() { delete_site_transient( "locked_{$this->_wp_user_id}" ); } private function has_lock() { return ( $this->_thread_id == get_site_transient( "locked_{$this->_wp_user_id}" ) ); } }