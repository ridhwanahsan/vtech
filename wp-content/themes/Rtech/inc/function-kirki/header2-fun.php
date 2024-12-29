<?php 

   new \Kirki\Panel(
    'header02_panel',
    [
        'priority'    => 10,
        'title'       => esc_html__( 'Header 02', 'kirki' ),
        'description' => esc_html__( 'Customize Header 02 settings', 'kirki' ),
        'panel'       => 'vtech_panel', // Attach to vtech panel
    ]
);
 
new \Kirki\Section(
    'header02_top_section',
    [
        'title'       => esc_html__( 'header02 top', 'kirki' ),
        'description' => esc_html__( 'Customize the content section of Header 01', 'kirki' ),
        'panel'       => 'header02_panel', // Attach to Header 01 panel
        'priority'    => 20,
    ]
);
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'header02_top_switch',
		'label'       => esc_html__( 'Header 01 Top Switch', 'kirki' ),
		'description' => esc_html__( 'Simple switch control', 'kirki' ),
		'section'     => 'header02_top_section',
		'default'     => 'on',
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'kirki' ),
			'off' => esc_html__( 'Disable', 'kirki' ),
		],
	]
);
new \Kirki\Field\Text(
    [
        'settings' => 'header02_location_address', 
        'label'    => esc_html__( 'Location Address', 'kirki' ),
        'section'  => 'header02_top_section',
        'default'  => esc_html__( '62, Business Str Hobert, AU', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'header02_top_mail_adress', 
        'label'    => esc_html__( 'Mail Address', 'kirki' ),
        'section'  => 'header02_top_section',
        'default'  => esc_html__( 'info@vatech.com', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Number(
    [
        'settings' => 'header02_top_phone_number', 
        'label'    => esc_html__( 'Phone Number', 'kirki' ),
        'section'  => 'header02_top_section',
        'default'  => esc_html__( '+98 90980798', 'kirki' ),
        'priority' => 10,
    ]
);
//header02 top social links
new \Kirki\Field\URL(
	[
		'settings' => 'facebook_link',
		'label'    => esc_html__( 'facebook link', 'kirki' ),
		'section'  => 'header02_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'instagram_link',
		'label'    => esc_html__( 'insta link', 'kirki' ),
		'section'  => 'header02_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'twitter_link',
		'label'    => esc_html__( 'twitter link', 'kirki' ),
		'section'  => 'header02_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'pinterest_link',
		'label'    => esc_html__( 'pinterest link', 'kirki' ),
		'section'  => 'header02_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);

// menu contents
new \Kirki\Section(
    'header02_nav_section',
    [
        'title'       => esc_html__( 'header02 Menu', 'kirki' ),
        'description' => esc_html__( 'Customize the content section of Header 01', 'kirki' ),
        'panel'       => 'header02_panel', // Attach to Header 01 panel
        'priority'    => 30,
    ]
); 
new \Kirki\Field\Image(
	[
		'settings'    => 'header02_menu_logo',
		'label'       => esc_html__( 'Image Control (array)', 'kirki' ),
		'description' => esc_html__( 'The saved value will be an array.', 'kirki' ),
		'section'     => 'header02_nav_section',
		'default'     => '',
		
		
	]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header02_menu_btn_txt', 
        'label'    => esc_html__( 'Menu Button Text', 'kirki' ),
        'section'  => 'header02_nav_section',
        'default'  => esc_html__( 'Get a quote', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\URL(
	[
		'settings' => 'header02_menu_btn_link',
		'label'    => esc_html__( 'Menu Button Link', 'kirki' ),
		'section'  => 'header02_nav_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);

 




