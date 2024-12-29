<?php
namespace vtech_hero\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class vtech_hero extends Widget_Base {

    public function get_name() {
        return 'hero-widget';
    }

    public function get_title() {
        return __('Hero Widget', 'elementor-hello-world');
    }

    public function get_icon() {
        return 'eicon-thumbnails-right';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {
        // Section Selection
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

        // Section 1 Content
        $this->start_controls_section(
            'section1_content',
            [
                'label' => esc_html__('Section 1 Content', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );

        $this->add_control(
            'section1_small_title',
            [
                'label' => esc_html__('Small Title', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'CONSULTING AGENCY',
            ]
        );

        $this->add_control(
            'section1_main_title',
            [
                'label' => esc_html__('Main Title', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Consulting your<br>Business Success',
            ]
        );

        $this->add_control(
            'section1_description',
            [
                'label' => esc_html__('Description', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We have been operating for over a decade, providing top-notch services.',
            ]
        );
         $this->add_control(
            'circle_text',
            [
                'label' => esc_html__('circle text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'im ridhwan',
                'label_block' => true,
            ]
        );
           $this->end_controls_section();
 $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button tab', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section1',
                ],
            ]
        );
        $this->add_control(
            'section1_button_text',
            [
                'label' => esc_html__('Button Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Discover More',
            ]
        );

       
        $this->add_control(
            'section1_button_link',
            [
                'label' => esc_html__('Button Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );
        $this->add_control(
            'section1_button2_text',
            [
                'label' => esc_html__('Button Text', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Contact Us',
            ]
        );

        $this->add_control(
            'section1_button2_link',
            [
                'label' => esc_html__('Button Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'fb.com',
                ],
            ]
        );

        $this->end_controls_section();

        // Section 2 Content
        $this->start_controls_section(
            'section2_content',
            [
                'label' => esc_html__('Section 2 Content', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'section_type' => 'section2',
                ],
            ]
        );

        $this->add_control(
            'section2_small_title',
            [
                'label' => esc_html__('Small Title', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Solutions',
            ]
        );

        $this->add_control(
            'section2_main_title',
            [
                'label' => esc_html__('Main Title', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Precision Consulting<br>Profound Results',
            ]
        );

        $this->add_control(
            'section2_description',
            [
                'label' => esc_html__('Description', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We have been operating for over a decade, providing top-notch services.',
            ]
        );

        $this->add_control(
            'section2_phone',
            [
                'label' => esc_html__('Phone Number', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => '(307) 555-0133',
            ]
        );

        $this->add_control(
            'section2_image',
            [
                'label' => esc_html__('Banner Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
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
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .title-banner, {{WRAPPER}} .title-banner-black',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .desc-banner',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-banner' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .title-banner-black' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .desc-banner' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => esc_html__('Section Background', 'textdomain'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .box-banner, {{WRAPPER}} .box-banner-2',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ($settings['section_type'] === 'section1') {
            ?>
            <section class="position-relative overflow-hidden box-banner">
                <div class="box-circle-round-banner">
                    <div class="position-relative bg-dark-950 border-linear-01 icon_220 icon-shape rounded-circle" data-aos="fade-up">
                        <svg width="62" height="61" viewBox="0 0 62 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M49.1017 38.1349C47.8531 36.7421 47.1256 33.6429 46.7116 30.8653C46.1722 27.286 46.1787 23.7353 46.8616 20.4179C47.3739 17.9306 48.2491 15.1992 49.7321 13.8697M49.7321 13.8697C48.2491 15.1992 45.4371 15.7733 42.9104 16.0103C39.5367 16.3262 36.0064 15.9462 32.5105 15.024C29.7928 14.3082 26.7878 13.244 25.5425 11.8549M49.7321 13.8697L12.5021 47.2452" stroke="#0055FF" stroke-width="3.5" />
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle w-100">
                            <h6 class="circle-text rotateme"><?php echo esc_html($settings['circle_text']); ?> </h6>
                        </div>
                    </div>
                </div>
                <div class="container" data-aos="fade-up">
                    <div class="banner img-custom-anim-left">
                        <div class="banner-small-title" data-aos="fade-up"><?php echo esc_html($settings['section1_small_title']); ?></div>
                        <h1 class="title-banner" data-aos="fade-up"><?php echo wp_kses_post($settings['section1_main_title']); ?></h1>
                        <p class="paragraph-base primary-50 desc-banner" data-aos="fade-up"><?php echo esc_html($settings['section1_description']); ?></p>
                        <a href="#" class="btn btn-primary mb-3" data-aos="fade-up">
                            <?php echo esc_html($settings['section1_button_text']); ?>
                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.3333 12C11.3333 11.364 11.8525 10.4143 12.3781 9.61714C13.0539 8.58857 13.8614 7.69114 14.7872 7.00629C15.4813 6.49286 16.3228 6 17 6M17 6C16.3228 6 15.4806 5.50714 14.7872 4.99371C13.8614 4.308 13.0539 3.41057 12.3781 2.38371C11.8525 1.58571 11.3333 0.634285 11.3333 -3.66907e-07M17 6L7.39105e-07 6" stroke="" stroke-width="1.5"/>
                            </svg>
                        </a>
                        <span class="mr-20 d-none d-sm-inline-block mb-3"></span>
                        <a href="<?php echo esc_url($settings['section1_button2_link']['url']); ?>" class="btn btn-border-white mb-3" data-aos="fade-up">
                            <?php echo esc_html($settings['section1_button2_text']); ?>
                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.3333 12C11.3333 11.364 11.8525 10.4143 12.3781 9.61714C13.0539 8.58857 13.8614 7.69114 14.7872 7.00629C15.4813 6.49286 16.3228 6 17 6M17 6C16.3228 6 15.4806 5.50714 14.7872 4.99371C13.8614 4.308 13.0539 3.41057 12.3781 2.38371C11.8525 1.58571 11.3333 0.634285 11.3333 -3.66907e-07M17 6L7.39105e-07 6" stroke="" stroke-width="1.5"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
            <?php
        } else {
            ?>
            <section class="position-relative overflow-hidden box-banner-2">
                <div class="container" data-aos="fade-up">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mt-5">
                            <div class="banner-2">
                                <div class="banner-small-title-black"><?php echo esc_html($settings['section2_small_title']); ?></div>
                                <h1 class="title-banner-black mb-20"><?php echo wp_kses_post($settings['section2_main_title']); ?></h1>
                                <p class="paragraph-rubik-r neutral-1200 desc-banner mb-40"><?php echo esc_html($settings['section2_description']); ?></p>
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="box-need-help">
                                        <p>Need help?</p>
                                        <h6 class="heading-md"><?php echo esc_html($settings['section2_phone']); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <?php if (!empty($settings['section2_image']['url'])) : ?>


                                <img src="<?php echo esc_url($settings['section2_image']['url']); ?>" alt="Banner" class="parallax-item" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
}

$widgets_manager->register(new vtech_hero());