<?php
function team_parts_code($widget) {
  $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Team Member Content', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'member_image',
            [
                'label' => esc_html__('Member Image', 'textdomain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $widget->add_control(
            'member_name',
            [
                'label' => esc_html__('Name', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Kathryn Murphy',
            ]
        );

        $widget->add_control(
            'member_position',
            [
                'label' => esc_html__('Position', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Manager',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_icon_image',
            [
                'label' => esc_html__('Social Icon Image', 'textdomain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'card_style' => 'style1'
                ]
            ]
        );

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Social Icon Class', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'share',
                'options' => [
                    'share' => esc_html__('Share', 'textdomain'),
                    'fb' => esc_html__('Facebook', 'textdomain'), 
                    'tw' => esc_html__('Twitter', 'textdomain'),
                    'printest' => esc_html__('Pinterest', 'textdomain')
                ],
                'condition' => [
                    'card_style' => 'style2'
                ]
            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__('Social Link', 'textdomain'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $widget->add_control(
            'social_links',
            [
                'label' => esc_html__('Social Links', 'textdomain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon_image' => [
                            'url' => get_template_directory_uri() . '/assets/imgs/pages/home2/fb.svg',
                        ],
                    ],
                ],
            ]
        );

        $widget->end_controls_section();
        
        return $widget;
    }