<?php

$settings = array(
    'default_school_year'    => array(
    'type'          => 'text',
    'default_value' => '',
),
    'default_category'       => array(
    'type'          => 'text',
    'default_value' => '',
),
    'calendar_display'       => array(
    'type'          => 'select',
    'default_value' => 'three-columns',
    'options'       => array_keys( wpsc_get_calendar_display_options() ),
),
    'day_format'             => array(
    'type'          => 'select',
    'default_value' => 'one-letter',
    'options'       => array_keys( wpsc_get_day_format_options() ),
),
    'weekday'                => array(
    'type'          => 'multiple',
    'default_value' => array(
    1,
    2,
    3,
    4,
    5
),
    'options'       => array(
    0,
    1,
    2,
    3,
    4,
    5,
    6
),
),
    'date_format'            => array(
    'type'          => 'select',
    'default_value' => 'medium',
    'options'       => array_keys( wpsc_get_date_format_options() ),
),
    'show_year'              => array(
    'type'          => 'text',
    'default_value' => 'Y',
),
    'important_date_heading' => array(
    'type'          => 'text',
    'default_value' => __( 'Dates to Remember', 'wp-school-calendar' ),
),
    'external_color_style'   => array(
    'type'          => 'checkbox',
    'default_value' => 'Y',
),
    'credit'                 => array(
    'type'          => 'checkbox',
    'default_value' => 'N',
),
);
return $settings;