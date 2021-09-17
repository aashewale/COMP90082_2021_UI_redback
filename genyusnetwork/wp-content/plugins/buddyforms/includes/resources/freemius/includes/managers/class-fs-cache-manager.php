<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

 if ( ! defined( 'ABSPATH' ) ) { exit; } class FS_Cache_Manager { private $_options; private $_logger; private static $_MANAGERS = array(); private function __construct( $id ) { $this->_logger = FS_Logger::get_logger( WP_FS__SLUG . '_cach_mngr_' . $id, WP_FS__DEBUG_SDK, WP_FS__ECHO_DEBUG_SDK ); $this->_logger->entrance(); $this->_logger->log( 'id = ' . $id ); $this->_options = FS_Option_Manager::get_manager( $id, true, true, false ); } static function get_manager( $id ) { $id = strtolower( $id ); if ( ! isset( self::$_MANAGERS[ $id ] ) ) { self::$_MANAGERS[ $id ] = new FS_Cache_Manager( $id ); } return self::$_MANAGERS[ $id ]; } function is_empty() { $this->_logger->entrance(); return $this->_options->is_empty(); } function clear() { $this->_logger->entrance(); $this->_options->clear( true ); } function delete() { $this->_options->delete(); } function has( $key ) { $cache_entry = $this->_options->get_option( $key, false ); return ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) ); } function has_valid( $key, $expiration = null ) { $cache_entry = $this->_options->get_option( $key, false ); $is_valid = ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) && $cache_entry->timestamp > WP_FS__SCRIPT_START_TIME ); if ( $is_valid && is_numeric( $expiration ) && isset( $cache_entry->created ) && is_numeric( $cache_entry->created ) && $cache_entry->created + $expiration < WP_FS__SCRIPT_START_TIME ) { $is_valid = false; } return $is_valid; } function get( $key, $default = null ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = $this->_options->get_option( $key, false ); if ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) ) { return $cache_entry->result; } return is_object( $default ) ? clone $default : $default; } function get_valid( $key, $default = null ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = $this->_options->get_option( $key, false ); if ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) && $cache_entry->timestamp > WP_FS__SCRIPT_START_TIME ) { return $cache_entry->result; } return is_object( $default ) ? clone $default : $default; } function set( $key, $value, $expiration = WP_FS__TIME_24_HOURS_IN_SEC, $created = WP_FS__SCRIPT_START_TIME ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = new stdClass(); $cache_entry->result = $value; $cache_entry->created = $created; $cache_entry->timestamp = $created + $expiration; $this->_options->set_option( $key, $cache_entry, true ); } function get_record_expiration( $key ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = $this->_options->get_option( $key, false ); if ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) && $cache_entry->timestamp > WP_FS__SCRIPT_START_TIME ) { return $cache_entry->timestamp; } return false; } function purge( $key ) { $this->_logger->entrance( 'key = ' . $key ); $this->_options->unset_option( $key, true ); } function update_expiration( $key, $expiration = WP_FS__TIME_24_HOURS_IN_SEC ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = $this->_options->get_option( $key, false ); if ( ! is_object( $cache_entry ) || ! isset( $cache_entry->timestamp ) || ! is_numeric( $cache_entry->timestamp ) ) { return false; } $this->set( $key, $cache_entry->result, $expiration, $cache_entry->created ); return true; } function expire( $key ) { $this->_logger->entrance( 'key = ' . $key ); $cache_entry = $this->_options->get_option( $key, false ); if ( is_object( $cache_entry ) && isset( $cache_entry->timestamp ) && is_numeric( $cache_entry->timestamp ) ) { $cache_entry->timestamp = WP_FS__SCRIPT_START_TIME; $this->_options->set_option( $key, $cache_entry, true ); } } function migrate_to_network() { $this->_options->migrate_to_network(); } }