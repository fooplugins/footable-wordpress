<?php

if (!class_exists('FooTable_Settings')) {

    class FooTable_Settings {

        /**
         *
         * @param $footable FooTable
         * @param $settings Foo_Plugin_Settings_v1_0
         */
        static function create_settings($footable, $settings) {

			$settings->add_tab( 'general', __('General', 'footable') );

			$help_html = '</h3><div class="foo-alert foo-alert-info">';
			$help_html .= '<h3>' . __( 'What is FooTable?', 'footable' ) . '</h3>';
			$help_html .= '<p>' . __( 'FooTable\'s goal is simple : to make HTML tables look awesome on all devices!', 'footable') . '</p>';
			$help_html .= '<p>' . __( 'Have you ever wanted to show a lot of data in a table, but hate how badly it scales on smaller mobile devices? FooTable solves this problem by hiding certain columns on smaller devices, but still allowing the user to expand each row to see the columns that were hidden.', 'footable') . '</p>';
			$help_html .= '<p><a class="trigger-nav-tab" href="#demo">' . __('Check out the demo to see it in action', 'footable') . '</a></p>';
			$help_html .= '</div>';

			$settings->add_section_to_tab( 'general', 'help', $help_html );

			$links_html = '</h3><div class="foo-alert foo-alert-warning footable-links">';
			$links_html .= '<h3>' . __( 'Useful FooTable Links', 'footable' ) . '</h3>';
			$links_html .= '<a target="_blank" href="' . FooTable::URL_DOCS . '"><strong>' . __('Getting Started Guide', 'footable') . '</strong></a>';
			$links_html .= '<a target="_blank" href="' . FooTable::URL_HOMEPAGE . '">' . __('Plugin Homepage', 'footable') . '</a>';
			$links_html .= '<a target="_blank" href="' . FooTable::URL_JQUERY . '">' . __('jQuery Plugin', 'footable') . '</a>';
			$links_html .= '<a target="_blank" href="' . FooTable::URL_GITHUB . '">' . __('jQuery Plugin on GitHub', 'footable') . '</a>';
			$links_html .= '</div>';

			$settings->add_section_to_tab( 'general', 'links', $links_html );

			$settings->add_section_to_tab( 'general', 'tables', __('FooTable Setup', 'footable') );

			$settings->add_setting( array(
				'id'      => 'selector',
				'title'   => __( 'Attach to tables', 'footable' ),
				'desc'    => __( 'Attach FooTable to tables with a CSS selector. Use this to target only certain HTML tables in your site.<br />The most common scenario is using a class name e.g. <code>.footable</code>. You can also target all tables in your site by using <code>table</code>', 'footable' ),
				'default' => '.footable',
				'type'    => 'text',
				'section' => 'tables',
				'tab'     => 'general'
			) );

			if (class_exists('TablePress')) {
				$settings->add_setting( array(
					'id'      => 'tablepress',
					'title'   => __( 'Attach to TablePress tables', 'footable' ),
					'desc'    => __( 'Automatically attach FooTable to all tables you create using TablePress.', 'footable' ),
					'default' => 'on',
					'type'    => 'checkbox',
					'section' => 'tables',
					'tab'     => 'general'
				) );
			}

			$settings->add_setting( array(
				'id'      => 'enable_sorting',
				'title'   => __( 'Enable Sorting', 'footable' ),
				'desc'    => __( 'Enable column sorting on all FooTables.<br />To disable sorting on a specific table, add <code>data-sort="false"</code> to your table element.', 'footable' ),
				'default' => 'on',
				'type'    => 'checkbox',
				'section' => 'tables',
				'tab'     => 'general'
			) );

			$settings->add_setting( array(
				'id'      => 'enable_filtering',
				'title'   => __( 'Enable Filtering', 'footable' ),
				'desc'    => __( 'Enable column filtering on all FooTables.<br />To disable sorting on a specific table, add <code>data-filter="false"</code> to your table element.', 'footable' ),
				'default' => 'on',
				'type'    => 'checkbox',
				'section' => 'tables',
				'tab'     => 'general'
			) );

			$settings->add_setting( array(
				'id'      => 'enable_pagination',
				'title'   => __( 'Enable Pagination', 'footable' ),
				'desc'    => __( 'Enable pagination on all FooTables.<br />To disable sorting on a specific table, add <code>data-page="false"</code> to your table element.', 'footable' ),
				'default' => 'on',
				'type'    => 'checkbox',
				'section' => 'tables',
				'tab'     => 'general'
			) );

//			$settings->add_setting( array(
//				'id'      => 'check_parent_width',
//				'title'   => __( 'Enable Parent Checking', 'footable' ),
//				'desc'    => __( 'When the FooTable is resized, the parent element\'s width is checked to make sure the FooTable breakpoints are triggered correctly.', 'footable' ),
//				'default' => 'on',
//				'type'    => 'checkbox',
//				'section' => 'tables',
//				'tab'     => 'general'
//			) );

			$settings->add_tab( 'breakpoints', __('Breakpoints', 'footable') );

			$breakpoint_html = '</h3><div class="foo-alert foo-alert-info">';
			$breakpoint_html .= '<h3>' . __( 'Breakpoint Help', 'footable' ) . '</h3>';
			$breakpoint_html .= '<p>' . __( 'Breakpoints are the heart and soul of FooTable. Whenever your site is viewed on a mobile device, or if the browser window is resized, FooTable checks the width of the table. If that width is smaller than the width of a breakpoint, certain columns in the table will be hidden.', 'footable') . '</p>';
			$breakpoint_html .= '<p>' . __( 'FooTable has two default breakpoints : <strong>tablet</strong> and <strong>phone</strong>. You can change the default size of these breakpoints below, so that they match your site\'s theme.', 'footable') . '</p>';
			$breakpoint_html .= '<p><a target="_blank" href="' . FooTable::URL_DOCS . '">' . __('Read more at the plugin documentation', 'footable') . '</a></p>';
			$breakpoint_html .= '</div>';

			$settings->add_section_to_tab( 'breakpoints', 'breakpoints', $breakpoint_html );

			$settings->add_setting( array(
				'id'      => 'breakpoint_tablet',
				'title'   => __( 'Tablet Breakpoint', 'footable' ),
				'desc'    => __( 'The width of the tablet breakpoint', 'footable' ),
				'default' => '768',
				'type'    => 'text',
				'section' => 'breakpoints',
				'tab'     => 'breakpoints',
				'class'   => 'short_input'
			) );

			$settings->add_setting( array(
				'id'      => 'breakpoint_phone',
				'title'   => __( 'Phone Breakpoint', 'footable' ),
				'desc'    => __( 'The width of the phone breakpoint', 'footable' ),
				'default' => '320',
				'type'    => 'text',
				'section' => 'breakpoints',
				'tab'     => 'breakpoints',
				'class'   => 'short_input'
			) );

			$settings->add_section_to_tab( 'breakpoints', 'columns', __('Column Visibility', 'footable') );

			$settings->add_setting( array(
				'id'      => 'columns_tablet',
				'title'   => __( '# Columns visible on tablet', 'footable' ),
				'desc'    => __( 'Max number of columns that are visible when the <strong>tablet</strong> breakpoint is triggered', 'footable' ),
				'default' => '4',
				'type'    => 'text',
				'section' => 'columns',
				'tab'     => 'breakpoints',
				'class'   => 'short_input'
			) );

			$settings->add_setting( array(
				'id'      => 'columns_phone',
				'title'   => __( '# Columns visible on phone', 'footable' ),
				'desc'    => __( 'Max number of columns that are visible when the <strong>phone</strong> breakpoint is triggered', 'footable' ),
				'default' => '2',
				'type'    => 'text',
				'section' => 'columns',
				'tab'     => 'breakpoints',
				'class'   => 'short_input'
			) );

			$settings->add_setting( array(
				'id'      => 'manual_columns',
				'title'   => __( 'Manual Column Visibility', 'footable' ),
				'desc'    => __( 'You can manually define which table columns will be visible by adding data attributes to your table HTML.', 'footable' ) . ' <a target="_blank" href="' . FooTable::URL_DOCS . '">' .  __('Read the documentation for more details', 'footable') . '</a>.',
				'type'    => 'checkbox',
				'section' => 'columns',
				'tab'     => 'breakpoints'
			) );

//			$settings->add_setting( array(
//				'id'      => 'columns_ignore',
//				'title'   => __( 'Always show columns', 'footable' ),
//				'desc'    => __( 'The names of the columns you always want to show on all devices. Please note that this will override the max columns set above.', 'footable' ),
//				'default' => '',
//				'type'    => 'text',
//				'section' => 'breakpoints',
//				'tab'     => 'general'
//			) );

			$settings->add_tab( 'looknfeel', __('Look &amp; Feel', 'footable') );

			$theme_html = '</h3><div class="foo-alert foo-alert-info">';
			$theme_html .= '<h3>' . __( 'FooTable Theme', 'footable' ) . '</h3>';
			$theme_html .= '<p>' . __( 'FooTable is built to look great with BootStrap out of the box, and the default theme adds no table styling and rather uses the BootStrap table styles.', 'footable') . '</p>';
			$theme_html .= '<p>' . __( 'However, we do have two table themes you can use if your theme does not use BootStrap.', 'footable') . '</p>';
			$theme_html .= '<p><a target="_blank" href="' . FooTable::URL_DOCS . '">' . __('Read more at the plugin documentation', 'footable') . '</a></p>';
			$theme_html .= '</div>';

			$settings->add_section_to_tab( 'looknfeel', 'theme', $theme_html );

			$theme_choices = array(
				'bootstrap' => __('Default', 'footable'),
				'metro' => __('Metro', 'footable'),
				'original' => __('Original FooTable Theme', 'footable'),
				'none' => __('None (use custom CSS)', 'footable'),
			);

			$settings->add_setting( array(
				'id'      => 'theme',
				'title'   => __( 'FooTable Theme', 'footable' ),
				'desc'	  => __( 'If you choose to use the default theme, then we assume you already have the necessary BootStrap CSS included in your theme.', 'footable'),
				'default' => 'bootstrap',
				'type'    => 'radio',
				'choices' => $theme_choices,
				'tab'     => 'looknfeel',
				'section' => 'theme'
			) );

			$settings->add_setting( array(
				'id'      => 'custom_css',
				'title'   => __( 'Custom CSS', 'footable' ),
				'desc'    => __( 'Add your own custom CSS styles', 'footable' ),
				'default' => '',
				'type'    => 'textarea',
				'tab'     => 'looknfeel',
				'section' => 'theme',
				'class'   => 'medium_textarea'
			) );

			$settings->add_section_to_tab( 'advanced', 'advanced', __('Advanced', 'footable') );

			$settings->add_tab( 'advanced', __('Advanced', 'footable') );

			$settings->add_section_to_tab( 'advanced', 'js', __('Javascript', 'footable') );

			$settings->add_setting( array(
				'id'      => 'custom_js_before',
				'title'   => __( 'Custom Javascript (Before)', 'footable' ),
				'desc'    => __( 'Call any custom JS before FooTable is initialized. (Only to be used by developers!)', 'footable' ),
				'default' => '',
				'type'    => 'textarea',
				'tab'     => 'advanced',
				'section' => 'js',
				'class'   => 'medium_textarea'
			) );

			$settings->add_setting( array(
				'id'      => 'custom_js_after',
				'title'   => __( 'Custom Javascript (After)', 'footable' ),
				'desc'    => __( 'Alter the way FooTable works by hooking into the built-in events, using custom javascript code. (Only to be used by developers!)', 'footable' ),
				'default' => '',
				'type'    => 'textarea',
				'tab'     => 'advanced',
				'section' => 'js',
				'class'   => 'medium_textarea'
			) );

			$settings->add_setting( array(
				'id'      => 'scripts_in_footer',
				'title'   => __( 'Scripts In Footer', 'footable' ),
				'desc'    => __( 'Load the javascript files in the site footer (for better performance). This requires the theme to have the wp_footer() hook in the appropriate place', 'footable' ),
				'type'    => 'checkbox',
				'section' => 'js',
				'tab'     => 'advanced'
			) );

			$settings->add_section_to_tab( 'advanced', 'debug', __('Debug', 'footable') );

			$settings->add_setting( array(
				'id'      => 'enable_debug',
				'title'   => __( 'Enable Debug Mode', 'footable' ),
				'desc'    => __( 'When debug is enabled, FooTable will write to the console log so you can debug any problems.<br />We also show an extra debug information tab on this settings page', 'footable' ),
				'type'    => 'checkbox',
				'section' => 'debug',
				'tab'     => 'advanced'
			) );

			$settings->add_tab( 'demo', __('Demo', 'footable') );

			$device_selector = '<div class="footable-device-selector">' .
'	<a title="Phone (320px)" class="phone" data-width="300px" href="#mobile"></a>' .
'	<a title="Tablet (768px)" class="tablet" data-width="750px" href="#tablet"></a>' .
'	<a title="Desktop (1024px)" class="desktop" data-width="1024px" href="#desktop"></a>' .
'</div>';

			$settings->add_setting( array(
				'id'      => 'demo_js',
				'title'   => $device_selector,
				'type'    => 'demo',
				'tab'     => 'demo'
			) );

			if ( $footable->options()->is_checked( 'enable_debug' ) ) {
				$settings->add_tab( 'debug', __('Debug Info', 'footable') );

				$settings->add_setting( array(
					'id'      => 'debug_output',
					'title'   => __( 'Debug Information', 'footable' ),
					'default' => 'off',
					'type'    => 'debug_output',
					'tab'     => 'debug'
				) );
			}
        }
    }
}