<?php
namespace vtech_about\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit;
}

class vtech_about extends Widget_Base {

    public function get_name() {
        return 'about-widget';
    }

    public function get_title() {
        return __('About Widget', 'elementor-hello-world');
    }

    public function get_icon() {
        return 'eicon-thumbnails-right';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_selection',
            [
                'label' => esc_html__('Section Selection', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'section_type',
            [
                'label' => esc_html__('Select Section', 'textdomain'),
                'type' => Controls_Manager::SELECT,
                'default' => 'section1',
                'options' => [
                    'section1' => esc_html__('Section 1', 'textdomain'),
                    'section2' => esc_html__('Section 2', 'textdomain'),
                ],
            ]
        );
        $this->end_controls_section();

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );

        $this->add_control(
            'about_image_1',
            [
                'label' => esc_html__('About Image 1', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'about_image_2',
            [
                'label' => esc_html__('About Image 2', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'since_text',
            [
                'label' => esc_html__('Since Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'SINCE 1980',
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Video Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://www.youtube.com/watch?v=TfU0qjuZkJ4',
                ],
            ]
        );

        $this->add_control(
            'circle_text',
            [
                'label' => esc_html__('Circle Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Best - Consulting - Agency -',
            ]
        );

        $this->add_control(
            'title_line',
            [
                'label' => esc_html__('Title Line', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'CONSULTING AGENCY',
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Successfully Provide Best <span class="primary-500">Business Consulting</span>',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió alteraciones en alguna manera, ya sea porque se le agregó humor de los pasajes de Lorem Ipsum disponibles',
            ]
        );

        $this->end_controls_section();

        // Features Section
        $this->start_controls_section(
            'features_section',
            [
                'label' => esc_html__('Features', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );

        $this->add_control(
            'feature_list',
            [
                'label' => esc_html__('Feature List', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'feature_text',
                        'label' => esc_html__('Feature Text', 'textdomain'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Feature Item', 'textdomain'),
                    ],
                ],
                'default' => [
                    ['feature_text' => 'Unlimited Consultation until getting result'],
                    ['feature_text' => 'Free demo Consultations'],
                    ['feature_text' => '100% Moneyback Guarantee'],
                    ['feature_text' => '100% Moneyback Guarantee'],
                ],
            ]
        );

        $this->end_controls_section();

        // Cards Section
        $this->start_controls_section(
            'cards_section',
            [
                'label' => esc_html__('Cards', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );

        $this->add_control(
            'card_1_image',
            [
                'label' => esc_html__('Card 1 Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'card_1_text',
            [
                'label' => esc_html__('Card 1 Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Inventory management',
            ]
        );

        $this->add_control(
            'card_2_image',
            [
                'label' => esc_html__('Card 2 Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'card_2_text',
            [
                'label' => esc_html__('Card 2 Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Experienced Team members',
            ]
        );

        $this->end_controls_section();

        // Button Section
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'About More',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );
        

        $this->end_controls_section();

        // Section 2 Content
        $this->start_controls_section(
            'section_2_content',
            [
                'label' => esc_html__('Section 2 Content', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section2',
                ],
            ]
        );

        $this->add_control(
            'section_2_image_1',
            [
                'label' => esc_html__('About Image 1', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'section_2_image_2',
            [
                'label' => esc_html__('About Image 2', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'happy_customers_count',
            [
                'label' => esc_html__('Happy Customers Count', 'textdomain'),
                'type' => Controls_Manager::NUMBER,
                'default' => '56',
            ]
        );
        $this->add_control(
            'happy_customers_count_text',
            [
                'label' => esc_html__('Happy Customers Count Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Happy Customers',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_2_title',
            [
                'label' => esc_html__('Title', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Solutions',
            ]
        );

        $this->add_control(
            'section_2_heading',
            [
                'label' => esc_html__('Heading', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Investing for your Future <span class="theme-primary underline">Business growth</span>',
            ]
        );

        $this->add_control(
            'section_2_description',
            [
                'label' => esc_html__('Description', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió alteraciones en alguna manera, ya sea porque se le agregó humor los pasajes.',
            ]
        );

        $this->add_control(
            'section_2_features',
            [
                'label' => esc_html__('Features', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'feature',
                        'label' => esc_html__('Feature', 'textdomain'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Feature Item', 'textdomain'),
                    ],
                ],
                'default' => [
                    ['feature' => 'Unlimited Consultation until getting result'],
                    ['feature' => 'Free demo Consultation'],
                    ['feature' => '100% Moneyback Guarantee'],
                ],
            ]
        );

        $this->add_control(
            'section_2_button_text',
            [
                'label' => esc_html__('Button Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'About More',
            ]
        );
    
    
        $this->add_control(
            'section_2_button_link',
            [
                'label' => esc_html__('Button Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'textdomain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'circle_text_typography',
                'label' => esc_html__('Circle Text Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .circle-text',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_line_typography',
                'label' => esc_html__('Title Line Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .title-line-2',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Heading Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .heading-3xl',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .color-text',
            ]
        );

        $this->add_control(
            'circle_text_color',
            [
                'label' => esc_html__('Circle Text Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .circle-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_line_color',
            [
                'label' => esc_html__('Title Line Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-line-2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Heading Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-3xl' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .color-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => esc_html__('Background', 'textdomain'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .box-agency',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if($settings['section_type'] === 'section1') {
        ?>

        <section class="position-relative overflow-hidden box-agency">
            <div class="container">
                <div class="row position-relative">
                    <div class="col-lg-5 mb-5">
                        <div class="box-squares">
                            <div class="item-square-1">
                                <div class="item-square-1-image wow img-custom-anim-left"><img src="<?php echo esc_url($settings['about_image_1']['url']); ?>" alt="Vatech" /></div>
                            </div>
                            <div class="item-square-2">
                                <div class="item-square-2-image wow img-custom-anim-right"><img src="<?php echo esc_url($settings['about_image_2']['url']); ?>" alt="Vatech" /></div>
                            </div>
                            <div class="text-square stroke-text"><?php echo esc_html($settings['since_text']); ?></div>
                        </div>
                    </div>
                    <div class="col-lg-7 mb-5">
                        <div class="box-title-top" data-aos="fade-up">
                            <div class="text-rotate-circle">
                                <div class="box-circle-round">
                                    <div class="position-relative bg-primary-500 icon_140  icon-shape rounded-circle">
                                        <a href="<?php echo esc_url($settings['video_link']['url']); ?>" class="popup-video no-pulse">
                                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="25" cy="25" r="24.5" stroke="white" />
                                                <path d="M33.1016 23.8984C33.6484 24.25 34 24.875 34 25.5C34 26.1641 33.6484 26.7891 33.1016 27.1016L21.8516 33.9766C21.2656 34.3281 20.5234 34.3672 19.9375 34.0156C19.3516 33.7031 19 33.0781 19 32.375V18.625C19 17.9609 19.3516 17.3359 19.9375 17.0234C20.5234 16.6719 21.2656 16.6719 21.8516 17.0625L33.1016 23.8984Z" fill="white" />
                                            </svg>
                                        </a>
                                        <div class="position-absolute top-50 start-50 translate-middle w-100">
                                            <h6 class="circle-text rotateme"><?php echo esc_html($settings['circle_text']); ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="title-section-2">
                                <p class="title-line-2"><?php echo esc_html($settings['title_line']); ?></p>
                                <h4 class="heading-3xl"><?php echo wp_kses_post($settings['heading']); ?></h4>
                            </div>
                        </div>
                        <p class="color-text paragraph-base mb-40" data-aos="fade-up"><?php echo esc_html($settings['description']); ?></p>
                        <ul class="list-tick-2-col row" data-aos="fade-up">
                            <?php foreach ($settings['feature_list'] as $item) : ?>
                            <li class="col-lg-7">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_4249_2372)">
                                        <path d="M9.99995 0C4.48601 0 0 4.36344 0 9.72695C0 15.0905 4.48601 19.454 9.99995 19.454C15.5139 19.454 19.9999 15.0905 19.9999 9.72695C19.9999 4.36344 15.514 0 9.99995 0ZM15.7421 8.08399L9.45963 14.1949C9.1925 14.4548 8.83741 14.5978 8.45967 14.5978C8.08193 14.5978 7.72684 14.4548 7.45971 14.1949L4.2578 11.0804C3.99067 10.8206 3.84354 10.4752 3.84354 10.1078C3.84354 9.74025 3.99067 9.39485 4.2578 9.13501C4.52483 8.87517 4.87992 8.73206 5.25776 8.73206C5.6355 8.73206 5.9907 8.87517 6.25773 9.13511L8.45957 11.2767L13.742 6.13856C14.0091 5.87872 14.3642 5.73571 14.7419 5.73571C15.1197 5.73571 15.4748 5.87872 15.7419 6.13856C16.2935 6.67508 16.2935 7.54767 15.7421 8.08399Z" fill="#0055FF" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4249_2372">
                                            <rect width="20" height="19.454" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <?php echo esc_html($item['feature_text']); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="row mb-30" data-aos="fade-up">
                            <div class="col-lg-6 mb-3">
                                <div class="card-image-circle-left">
                                    <div class="image">
                                        <img src="<?php echo esc_url($settings['card_1_image']['url']); ?>" alt="Vatech" />
                                    </div>
                                    <div class="info"><?php echo esc_html($settings['card_1_text']); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="card-image-circle-left">
                                    <div class="image">
                                        <img src="<?php echo esc_url($settings['card_2_image']['url']); ?>" alt="Vatech" />
                                    </div>
                                    <div class="info"><?php echo esc_html($settings['card_2_text']); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="btn btn-primary"><?php echo esc_html($settings['button_text']); ?>
                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.3333 12C11.3333 11.364 11.8525 10.4143 12.3781 9.61714C13.0539 8.58857 13.8614 7.69114 14.7872 7.00629C15.4813 6.49286 16.3228 6 17 6M17 6C16.3228 6 15.4806 5.50714 14.7872 4.99371C13.8614 4.308 13.0539 3.41057 12.3781 2.38371C11.8525 1.58571 11.3333 0.634285 11.3333 -3.66907e-07M17 6L7.39105e-07 6" stroke="" stroke-width="1.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <?php
        } else {
        ?>

        <section class="position-relative overflow-hidden box-about-us">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-6 mb-4">
                        <div class="box-happy-customers">
                            <div class="box-happy-img-1">

                                <img src="<?php echo esc_url($settings['section_2_image_1']['url']); ?>" alt="Vatech" data-aos="fade-up" data-aos-duration="200" />

                                <div class="happy-customers">
                                    <h6 class="heading-3xl theme-secondary"><span class="odometer" data-count="
                                    
                                    <?php echo esc_html($settings['happy_customers_count']); ?>">
                                
                                </span><span class="d-inline-block align-middle">k+</span></h6>

                                    <p class="sub-heading-ag-md theme-primary"><?php echo esc_html($settings['happy_customers_count_text']); ?></p>
                                </div>
                            </div>
                            <div class="box-happy-img-2">
                                <img src="<?php echo esc_url($settings['section_2_image_2']['url']); ?>" alt="Vatech" data-aos="fade-up" data-aos-duration="1000" />
                            </div>
                        </div>
                        </div>
                    <div class="col-lg-6 mb-4">
                        <div class="banner-small-title-black"><?php echo esc_html($settings['section_2_title']); ?></div>
                        <h2 class="heading-3xl mb-30"><?php echo wp_kses_post($settings['section_2_heading']); ?></h2>
                        <p class="mb-4"><?php echo esc_html($settings['section_2_description']); ?></p>
                        <ul class="list-tick-col">
                            <?php foreach ($settings['section_2_features'] as $feature) : ?>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_4249_2372)">
                                        <path d="M9.99995 0C4.48601 0 0 4.36344 0 9.72695C0 15.0905 4.48601 19.454 9.99995 19.454C15.5139 19.454 19.9999 15.0905 19.9999 9.72695C19.9999 4.36344 15.514 0 9.99995 0ZM15.7421 8.08399L9.45963 14.1949C9.1925 14.4548 8.83741 14.5978 8.45967 14.5978C8.08193 14.5978 7.72684 14.4548 7.45971 14.1949L4.2578 11.0804C3.99067 10.8206 3.84354 10.4752 3.84354 10.1078C3.84354 9.74025 3.99067 9.39485 4.2578 9.13501C4.52483 8.87517 4.87992 8.73206 5.25776 8.73206C5.6355 8.73206 5.9907 8.87517 6.25773 9.13511L8.45957 11.2767L13.742 6.13856C14.0091 5.87872 14.3642 5.73571 14.7419 5.73571C15.1197 5.73571 15.4748 5.87872 15.7419 6.13856C16.2935 6.67508 16.2935 7.54767 15.7421 8.08399Z" fill="#0055FF" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4249_2372">
                                            <rect width="20" height="19.454" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <?php echo esc_html($feature['feature']); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="mb-5"></div>
                        <a href="<?php echo esc_url($settings['section_2_button_link']['url']); ?>" class="btn btn-primary-square-2-md">
                            <?php echo esc_html($settings['section_2_button_text']); ?>
                         
                        </a>

                      
                    </div>
                </div>
            </div>
        </section>

        <?php
        }
    }
}

$widgets_manager->register(new vtech_about());