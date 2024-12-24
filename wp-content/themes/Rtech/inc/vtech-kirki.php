<?php 
// Add the main vtech theme Panel
new \Kirki\Panel(
    'vtech_panel',
    [
        'priority'    => 10,
        'title'       => esc_html__( 'vtech theme', 'kirki' ),
        'description' => esc_html__( 'My Panel Description for vtech theme.', 'kirki' ),
    ]
);

// Add the Header 01 Panel under vtech theme panel

function vtech_header01_panel() {
   new \Kirki\Panel(
    'header01_panel',
    [
        'priority'    => 10,
        'title'       => esc_html__( 'Header 01', 'kirki' ),
        'description' => esc_html__( 'Customize Header 01 settings', 'kirki' ),
        'panel'       => 'vtech_panel', // Attach to vtech panel
    ]
);
 
new \Kirki\Section(
    'header01_top_section',
    [
        'title'       => esc_html__( 'Header01 top', 'kirki' ),
        'description' => esc_html__( 'Customize the content section of Header 01', 'kirki' ),
        'panel'       => 'header01_panel', // Attach to Header 01 panel
        'priority'    => 20,
    ]
);
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'header01_top_switch',
		'label'       => esc_html__( 'Header 01 Top Switch', 'kirki' ),
		'description' => esc_html__( 'Simple switch control', 'kirki' ),
		'section'     => 'header01_top_section',
		'default'     => 'on',
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'kirki' ),
			'off' => esc_html__( 'Disable', 'kirki' ),
		],
	]
);
new \Kirki\Field\Text(
    [
        'settings' => 'header01_location_address', 
        'label'    => esc_html__( 'Location Address', 'kirki' ),
        'section'  => 'header01_top_section',
        'default'  => esc_html__( '62, Business Str Hobert, AU', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'header01_top_mail_adress', 
        'label'    => esc_html__( 'Mail Address', 'kirki' ),
        'section'  => 'header01_top_section',
        'default'  => esc_html__( 'info@vatech.com', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Number(
    [
        'settings' => 'header01_top_phone_number', 
        'label'    => esc_html__( 'Phone Number', 'kirki' ),
        'section'  => 'header01_top_section',
        'default'  => esc_html__( '+98 90980798', 'kirki' ),
        'priority' => 10,
    ]
);
//header01 top social links
new \Kirki\Field\URL(
	[
		'settings' => 'facebook_link',
		'label'    => esc_html__( 'facebook link', 'kirki' ),
		'section'  => 'header01_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'instagram_link',
		'label'    => esc_html__( 'insta link', 'kirki' ),
		'section'  => 'header01_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'twitter_link',
		'label'    => esc_html__( 'twitter link', 'kirki' ),
		'section'  => 'header01_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);
new \Kirki\Field\URL(
	[
		'settings' => 'pinterest_link',
		'label'    => esc_html__( 'pinterest link', 'kirki' ),
		'section'  => 'header01_top_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);

// menu contents
new \Kirki\Section(
    'header01_nav_section',
    [
        'title'       => esc_html__( 'Header01 Menu', 'kirki' ),
        'description' => esc_html__( 'Customize the content section of Header 01', 'kirki' ),
        'panel'       => 'header01_panel', // Attach to Header 01 panel
        'priority'    => 30,
    ]
); 
new \Kirki\Field\Image(
	[
		'settings'    => 'header01_menu_logo',
		'label'       => esc_html__( 'Image Control (array)', 'kirki' ),
		'description' => esc_html__( 'The saved value will be an array.', 'kirki' ),
		'section'     => 'header01_nav_section',
		'default'     => '',
		
		
	]
);

new \Kirki\Field\Upload(
    [
        'settings'    => 'header01_menu_gallery_1',
        'label'       => esc_html__( 'Image Gallery (multiple images)', 'kirki' ),
        'description' => esc_html__( 'Select multiple images for the menu gallery.', 'kirki' ),
        'section'     => 'header01_nav_section',
        'default'     => '',
        'priority'    => 10,
        'multiple'    => 999, // Allow multiple file uploads
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'header01_menu_btn_txt', 
        'label'    => esc_html__( 'Menu Button Text', 'kirki' ),
        'section'  => 'header01_nav_section',
        'default'  => esc_html__( 'Get a quote', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\URL(
	[
		'settings' => 'header01_menu_btn_link',
		'label'    => esc_html__( 'Menu Button Link', 'kirki' ),
		'section'  => 'header01_nav_section',
		'default'  => 'https://yoururl.com/',
		'priority' => 10,
	]
);

 
}

vtech_header01_panel();









// Add demo section under vtech panel
new \Kirki\Section(
    'demo_section',
    [
        'title'       => esc_html__( 'demo section', 'kirki' ),
        'description' => esc_html__( 'Customize the top section of Header 01', 'kirki' ),
        'panel'       => 'vtech_panel', // Attach to Header 01 panel
        'priority'    => 10,
    ]
);// demo context 
new \Kirki\Field\Text(
    [
        'settings' => 'demo_text',
        'label'    => esc_html__( 'demo text', 'kirki' ),
        'section'  => 'demo_section',
        'default'  => esc_html__( 'Enter your address here', 'kirki' ),
        'priority' => 10,
    ]
);


//footer section
function vtech_footer_panel() {
    // Add Footer panel
    new \Kirki\Panel(
        'footer_panel',
        [
            'priority'    => 40,
            'title'       => esc_html__('Footer Settings', 'kirki'),
            'description' => esc_html__('Customize the footer section', 'kirki'),
            'panel'       => 'vtech_panel', // Attach to Header 01 panel
            'priority'    => 30,
        ]
    );

    // Add Footer General section
    new \Kirki\Section(
        'footer_general_section',
        [
            'title'       => esc_html__('Footer General', 'kirki'),
            'panel'       => 'footer_panel',
            'priority'    => 10,
        ]
    );

    // Footer Logo
    new \Kirki\Field\Image(
        [
            'settings'    => 'footer_logo',
            'label'       => esc_html__('Footer Logo', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => '',
            'priority'    => 10,
        ]
    );

    // Footer Description
    new \Kirki\Field\Textarea(
        [
            'settings'    => 'footer_description',
            'label'       => esc_html__('Footer Description', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Enter footer description here', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Phone
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_phone',
            'label'       => esc_html__('Phone Number', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('+1 234 567 890', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Hours
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_hours',
            'label'       => esc_html__('Working Hours', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Mon - Fri: 9:00 - 18:00', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Menu Title
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_menu_title',
            'label'       => esc_html__('Menu Title', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Quick Links', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Useful Links Title
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_useful_links_title',
            'label'       => esc_html__('Useful Links Title', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Useful Links', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Newsletter Title
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_newsletter_title',
            'label'       => esc_html__('Newsletter Title', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Newsletter', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Newsletter Text
    new \Kirki\Field\Textarea(
        [
            'settings'    => 'footer_newsletter_text',
            'label'       => esc_html__('Newsletter Text', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Subscribe to our newsletter', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Newsletter Placeholder
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_newsletter_placeholder',
            'label'       => esc_html__('Newsletter Placeholder', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Enter your email', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Social Title
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_social_title',
            'label'       => esc_html__('Social Title', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Follow Us', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Social Media Links
    new \Kirki\Field\URL(
        [
            'settings'    => 'footer_facebook',
            'label'       => esc_html__('Facebook URL', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => '#',
            'priority'    => 10,
        ]
    );

    new \Kirki\Field\URL(
        [
            'settings'    => 'footer_twitter',
            'label'       => esc_html__('Twitter URL', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => '#',
            'priority'    => 10,
        ]
    );

    new \Kirki\Field\URL(
        [
            'settings'    => 'footer_instagram',
            'label'       => esc_html__('Instagram URL', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => '#',
            'priority'    => 10,
        ]
    );

    new \Kirki\Field\URL(
        [
            'settings'    => 'footer_pinterest',
            'label'       => esc_html__('Pinterest URL', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => '#',
            'priority'    => 10,
        ]
    );

    // Footer Copyright
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_copyright',
            'label'       => esc_html__('Copyright Text', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('© 2023 Your Company. All rights reserved.', 'kirki'),
            'priority'    => 10,
        ]
    );

    // Footer Credits
    new \Kirki\Field\Text(
        [
            'settings'    => 'footer_credits',
            'label'       => esc_html__('Credits Text', 'kirki'),
            'section'     => 'footer_general_section',
            'default'     => esc_html__('Designed by Your Company', 'kirki'),
            'priority'    => 10,
        ]
    );
}

vtech_footer_panel();