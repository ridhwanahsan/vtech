<?php
namespace vtech_testimonial\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class vtech_testimonial extends Widget_Base {

    public function get_name() {
        return 'testimonial-widget';
    }

    public function get_title() {
        return __('Testimonial Widget', 'vtech-core');
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {
        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'vtech-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'testimonial_style',
            [
                'label' => esc_html__('Testimonial Style', 'vtech-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'vtech-core'),
                    'style2' => esc_html__('Style 2', 'vtech-core'),
                ],
            ]
        );

        $this->end_controls_section();

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'vtech-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Section Title', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'TESTIMONIALS',
            ]
        );

        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__('Heading Text', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'What Say Our Clients For Our Services',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'client_image',
            [
                'label' => esc_html__('Client Image', 'vtech-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'client_name',
            [
                'label' => esc_html__('Client Name', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Cameron Williamson',
            ]
        );

        $repeater->add_control(
            'client_position',
            [
                'label' => esc_html__('Client Position', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Product Manager',
            ]
        );

        $repeater->add_control(
            'testimonial_text',
            [
                'label' => esc_html__('Testimonial Text', 'vtech-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet consectetur. In non sodales elementum et tempus ac platea velit semper.',
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => esc_html__('Rating', 'vtech-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials', 'vtech-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'client_name' => 'Cameron Williamson',
                        'client_position' => 'Product Manager',
                        'testimonial_text' => 'Lorem ipsum dolor sit amet consectetur. In non sodales elementum et tempus ac platea velit semper.',
                        'rating' => '5'
                    ],
                ],
                'title_field' => '{{{ client_name }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section - General
        $this->start_controls_section(
            'style_general_section',
            [
                'label' => esc_html__('General Style', 'vtech-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => esc_html__('Section Background', 'vtech-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .box-testimonials, {{WRAPPER}} .box-testimonial-2',
            ]
        );

        $this->add_control(
            'section_padding',
            [
                'label' => esc_html__('Section Padding', 'vtech-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .box-testimonials, {{WRAPPER}} .box-testimonial-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'style_typography_section',
            [
                'label' => esc_html__('Typography', 'vtech-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_title_color',
            [
                'label' => esc_html__('Section Title Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-line, {{WRAPPER}} .banner-small-title-white' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Heading Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-3xl, {{WRAPPER}} .heading-ag-3xl' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'testimonial_text_color',
            [
                'label' => esc_html__('Testimonial Text Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .comment-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'label' => esc_html__('Section Title Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .title-line, {{WRAPPER}} .banner-small-title-white',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Heading Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .heading-3xl, {{WRAPPER}} .heading-ag-3xl',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'testimonial_text_typography',
                'label' => esc_html__('Testimonial Text Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .comment-text',
            ]
        );

        $this->end_controls_section();

        // Style Section - Card
        $this->start_controls_section(
            'style_card_section',
            [
                'label' => esc_html__('Card Style', 'vtech-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background_color',
            [
                'label' => esc_html__('Card Background Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-testimonials, {{WRAPPER}} .card-testimonials-2' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Card Border', 'vtech-core'),
                'selector' => '{{WRAPPER}} .card-testimonials, {{WRAPPER}} .card-testimonials-2',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => esc_html__('Card Box Shadow', 'vtech-core'),
                'selector' => '{{WRAPPER}} .card-testimonials, {{WRAPPER}} .card-testimonials-2',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if($settings['testimonial_style'] === 'style1') {
            ?>
            <section class="position-relative overflow-hidden box-testimonials">
                <div class="container swipper-root">
                    <div class="row position-relative align-items-end">
                        <div class="col-lg-9">
                            <h6 class="title-line mb-20" data-aos="fade-up"><?php echo esc_html($settings['section_title']); ?></h6>
                            <h3 class="heading-3xl" data-aos="fade-up"><?php echo esc_html($settings['heading_text']); ?></h3>
                        </div>
                        <div class="col-lg-3 text-end">
                            <div class="box-button-slider" data-aos="fade-up">
                                <div class="swiper-button-prev swiper-button-inline swiper-button-prev-style-2">
                                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 2.62268e-07C6 0.636 5.45025 1.58571 4.89375 2.38286C4.17825 3.41143 3.32325 4.30886 2.343 4.99371C1.608 5.50714 0.717 6 -2.62268e-07 6M-2.62268e-07 6C0.717 6 1.60875 6.49286 2.343 7.00629C3.32325 7.692 4.17825 8.58943 4.89375 9.61629C5.45025 10.4143 6 11.3657 6 12M-2.62268e-07 6L18 6" stroke="" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next swiper-button-inline swiper-button-next-style-2">
                                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C12 11.364 12.5498 10.4143 13.1063 9.61714C13.8218 8.58857 14.6768 7.69114 15.657 7.00629C16.392 6.49286 17.283 6 18 6M18 6C17.283 6 16.3913 5.50714 15.657 4.99371C14.6768 4.308 13.8218 3.41057 13.1063 2.38371C12.5498 1.58571 12 0.634285 12 -3.81478e-07M18 6L2.62268e-07 6" stroke="" stroke-width="1.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-slider-testimonials box-swiper-padding" data-aos="fade-up">
                    <div class="box-swiper">
                        <div class="swiper-container swiper-group-auto">
                            <div class="swiper-wrapper">
                                <?php foreach($settings['testimonials'] as $testimonial) : ?>
                                <div class="swiper-slide">
                                    <div class="card-testimonials">
                                        <div class="rating">
                                            <?php for($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                            <img src="<?php echo esc_url(plugins_url('assets/imgs/template/icons/star.svg', __FILE__)); ?>" alt="star" />
                                            <?php endfor; ?>
                                        </div>
                                        <div class="comment-text"><?php echo esc_html($testimonial['testimonial_text']); ?></div>
                                        <div class="comment-author">
                                            <div class="comment-author-image">
                                                <img src="<?php echo esc_url($testimonial['client_image']['url']); ?>" alt="<?php echo esc_attr($testimonial['client_name']); ?>" />
                                            </div>
                                            <div class="comment-author-info">
                                                <h6 class="heading-lg color-white"><?php echo esc_html($testimonial['client_name']); ?></h6>
                                                <p class="paragraph-base color-text-5"><?php echo esc_html($testimonial['client_position']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        } else {
            ?>
            <section class="position-relative overflow-hidden box-testimonial-2">
                <div class="container" data-aos="fade-up">
                    <div class="row position-relative align-items-end">
                        <div class="col-lg-9">
                            <h6 class="banner-small-title-white mb-20" data-aos="fade-up"><?php echo esc_html($settings['section_title']); ?></h6>
                            <h3 class="heading-ag-3xl color-white" data-aos="fade-up"><?php echo esc_html($settings['heading_text']); ?></h3>
                        </div>
                        <div class="col-lg-3 text-end">
                            <div class="box-button-slider" data-aos="fade-up">
                                <div class="swiper-button-prev swiper-button-inline swiper-button-prev-style-1 swiper-button-prev-style-3">
                                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 2.62268e-07C6 0.636 5.45025 1.58571 4.89375 2.38286C4.17825 3.41143 3.32325 4.30886 2.343 4.99371C1.608 5.50714 0.717 6 -2.62268e-07 6M-2.62268e-07 6C0.717 6 1.60875 6.49286 2.343 7.00629C3.32325 7.692 4.17825 8.58943 4.89375 9.61629C5.45025 10.4143 6 11.3657 6 12M-2.62268e-07 6L18 6" stroke="" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next swiper-button-inline swiper-button-next-style-1 swiper-button-next-style-3">
                                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C12 11.364 12.5498 10.4143 13.1063 9.61714C13.8218 8.58857 14.6768 7.69114 15.657 7.00629C16.392 6.49286 17.283 6 18 6M18 6C17.283 6 16.3913 5.50714 15.657 4.99371C14.6768 4.308 13.8218 3.41057 13.1063 2.38371C12.5498 1.58571 12 0.634285 12 -3.81478e-07M18 6L2.62268e-07 6" stroke="" stroke-width="1.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-testimonials-lists mt-5" data-aos="fade-up">
                        <div class="box-swiper">
                            <div class="swiper-container slider-group-3">
                                <div class="swiper-wrapper">
                                    <?php foreach($settings['testimonials'] as $testimonial) : ?>
                                    <div class="swiper-slide">
                                        <div class="card-testimonials-2">
                                            <div class="card-author">
                                                <div class="author-image">
                                                    <img src="<?php echo esc_url($testimonial['client_image']['url']); ?>" alt="<?php echo esc_attr($testimonial['client_name']); ?>" />
                                                </div>
                                                <div class="author-info">
                                                    <div class="rating">
                                                        <?php for($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                                        <img src="<?php echo esc_url(plugins_url('assets/imgs/template/icons/star.svg', __FILE__)); ?>" alt="star" />
                                                        <?php endfor; ?>
                                                    </div>
                                                    <h5 class="sub-heading-ag-xl"><?php echo esc_html($testimonial['client_name']); ?></h5>
                                                    <p class="paragraph-rubik-r"><?php echo esc_html($testimonial['client_position']); ?></p>
                                                </div>
                                            </div>
                                            <div class="comment-text"><?php echo esc_html($testimonial['testimonial_text']); ?></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
}

$widgets_manager->register(new vtech_testimonial());