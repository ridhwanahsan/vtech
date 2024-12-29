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
function vtech_breadcrumb_section(){
    new \Kirki\Section(
        'vtech_breadcrumb_section',
        [
            'title'       => esc_html__( 'Breadcrumb', 'vtech' ),
            'description' => esc_html__( 'My Breadcrumb Section Description.', 'vtech' ),
            'panel'       => 'vtech_panel',
            'priority'    => 10,
        ]
    );

    new \Kirki\Field\Image(
        [
            'settings'    => 'breadcrumb_bg_img',
            'label'       => esc_html__( 'Breadcrumb BG Image', 'vtech' ),
            'description' => esc_html__( 'Please set your footer breadcrunmb image', 'vtech' ),
            'section'     => 'vtech_breadcrumb_section',
        ]
    );
    new \Kirki\Field\Image(
        [
            'settings'    => 'breadcrumb_shape_img',
            'label'       => esc_html__( 'Breadcrumb shape Image', 'vtech' ),
            'description' => esc_html__( 'Please set your footer breadcrunmb image', 'vtech' ),
            'section'     => 'vtech_breadcrumb_section',
        ]
    );
    new \Kirki\Field\Color( 
        [
            'settings'    => 'breadcrumb_bg_color',
            'label'       => __('Breadcrumb BG Color', 'vtech'),
            'description' => esc_html__('This is a Breadcrumb bg color control.', 'vtech'),
            'section'     => 'vtech_breadcrumb_section',
            'default'     => '#e1e1e1',
            'priority'    => 10,
        ] 
    );
    new \Kirki\Field\Color(
        [
            'settings'    => 'breadcrumb_title_color',
            'label'       => __('Breadcrumb Title Color', 'vtech'),
            'description' => esc_html__('This is a Breadcrumb title color control.', 'vtech'),
            'section'     => 'vtech_breadcrumb_section',
            'default'     => '#ffffff',
            'priority'    => 11,
        ]
    );
    new \Kirki\Field\Color(
        [
            'settings'    => 'breadcrumb_text_color', 
            'label'       => __('Breadcrumb Text Color', 'vtech'),
            'description' => esc_html__('This is a Breadcrumb text color control.', 'vtech'),
            'section'     => 'vtech_breadcrumb_section',
            'default'     => '#ffffff',
            'priority'    => 12,
        ]
    );
    new \Kirki\Field\Text(
        [
            'settings'    => 'breadcrumb_font_size',
            'label'       => __('Breadcrumb Font Size', 'vtech'),
            'description' => esc_html__('Enter font size with unit (e.g. 16px)', 'vtech'),
            'section'     => 'vtech_breadcrumb_section',
            'default'     => '16px',
            'priority'    => 13,
        ]
    );
   
}
vtech_breadcrumb_section();
// Add the Header 01 Panel under vtech theme panel

function vtech_header01_panel() {
   get_template_part('inc/function-kirki/header1-fun');
}

vtech_header01_panel();

// header 2 content 
function vtech_header2_panel()
{
get_template_part('inc/function-kirki/header2-fun');
};
vtech_header2_panel();




// offCanvas menu
function vtech_offCanvas_menu()
{
new \Kirki\Panel(
    'offCanvas_menu_panel',
    [
        'priority'    => 10,
        'title'       => esc_html__( 'OffCanvas Menu', 'kirki' ),
        'description' => esc_html__( 'Customize OffCanvas Menu settings', 'kirki' ),
        'panel'       => 'vtech_panel', // Attach to vtech panel
    ]
);
new \Kirki\Section(
    'offCanvas_menu_section',
    [
        'title'       => esc_html__( 'OffCanvas Menu', 'kirki' ),
        'description' => esc_html__( 'Customize the content section of Header 01', 'kirki' ),
        'panel'       => 'offCanvas_menu_panel', // Attach to Header 01 panel
        'priority'    => 20,
    ]
);
new \Kirki\Field\Image(
	[
		'settings'    => 'offCanvas_menu_logo',
		'label'       => esc_html__( 'Image Control (array)', 'kirki' ),
		'description' => esc_html__( 'The saved value will be an array.', 'kirki' ),
		'section'     => 'offCanvas_menu_section',
		'default'     => '',
		
		
	]
);
new \Kirki\Field\Select(
    [
        'settings'    => 'offCanvas_menu_select',
        'label'       => esc_html__( 'Select Menu', 'kirki' ),
        'section'     => 'offCanvas_menu_section',
        'default'     => '',
        'placeholder' => esc_html__( 'Choose a menu', 'kirki' ),
        'choices'     => wp_get_nav_menus() ? array_combine(
            wp_list_pluck(wp_get_nav_menus(), 'term_id'),
            wp_list_pluck(wp_get_nav_menus(), 'name')
        ) : ['' => esc_html__('No menus found', 'kirki')],
    ]
);

new \Kirki\Field\Text(
    [
        'settings' => 'offCanvas_gallery_title', 
        'label'    => esc_html__( 'offCanvas Gallery Title', 'kirki' ),
        'section'  => 'offCanvas_menu_section',
        'default'  => esc_html__( 'Gallery', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Repeater(
    [
        'settings' => 'offCanvas_gallery',
        'label'    => esc_html__('Gallery Images', 'kirki'),
        'section'  => 'offCanvas_menu_section',
        'priority' => 10,
        'default'  => [
            [
                'image' => get_template_directory_uri() . '/assets/img/gallery-1.jpg',
            ],
        ],
        'fields'   => [
            'image' => [
                'type'        => 'image',
                'label'       => esc_html__('Image', 'kirki'),
                'description' => esc_html__('Select an image', 'kirki'),
                'default'     => [
                    'image' => get_template_directory_uri() . '/assets/img/gallery-1.jpg',
                ],
            ],
        ],
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'contact_section_title', 
        'label'    => esc_html__( 'Contact Section Title', 'kirki' ),
        'section'  => 'offCanvas_menu_section',
        'default'  => esc_html__( 'Contact Us', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'offCanvas_adress', 
        'label'    => esc_html__( 'offCanvas Adress', 'kirki' ),
        'section'  => 'offCanvas_menu_section',
        'default'  => esc_html__( '62, Business Str Hobert, AU', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'offCanvas_work_hours', 
        'label'    => esc_html__( 'offCanvas Work Hours', 'kirki' ),
        'section'  => 'offCanvas_menu_section',
        'default'  => esc_html__( 'Mon - Fri: 9:00 - 18:00', 'kirki' ),
        'priority' => 10,
    ]
);
new \Kirki\Field\Text(
    [
        'settings' => 'offCanvas_phone', 
        'label'    => esc_html__( 'offCanvas Phone', 'kirki' ),
        'section'  => 'offCanvas_menu_section',
        'default'  => esc_html__( '+98 90980798', 'kirki' ),
        'priority' => 10,
    ]
);    

}
vtech_offCanvas_menu();



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