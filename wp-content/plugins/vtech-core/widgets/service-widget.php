<?php
namespace vtech_service\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class vtech_service extends Widget_Base {

    public function get_name() {
        return 'service-widget';
    }

    public function get_title() {
        return __('Service Widget', 'elementor-hello-world');
    }

    public function get_icon() {
        return 'eicon-thumbnails-right';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {
        // Process Items Section
        $this->start_controls_section(
            'process_section',
            [
                'label' => esc_html__('Process Items', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'process_image',
            [
                'label' => esc_html__('Process Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'process_number',
            [
                'label' => esc_html__('Number', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => '01',
            ]
        );

        $repeater->add_control(
            'process_title',
            [
                'label' => esc_html__('Title', 'textdomain'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Researching Grow',
            ]
        );

        $repeater->add_control(
            'process_description',
            [
                'label' => esc_html__('Description', 'textdomain'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Muchas variaciones de los pasajes de Lorem se le agregó pasajes de',
            ]
        );

        $repeater->add_control(
            'process_link',
            [
                'label' => esc_html__('Link', 'textdomain'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'process_items',
            [
                'label' => esc_html__('Process Items', 'textdomain'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'process_number' => '01',
                        'process_title' => 'Researching Grow',
                        'process_description' => 'Muchas variaciones de los pasajes de Lorem se le agregó pasajes de',
                    ],
                    [
                        'process_number' => '02',
                        'process_title' => 'Strategic Plan',
                        'process_description' => 'Muchas variaciones de los pasajes de Lorem se le agregó pasajes de',
                    ],
                    [
                        'process_number' => '03',
                        'process_title' => 'Customizable Solution',
                        'process_description' => 'Muchas variaciones de los pasajes de Lorem se le agregó pasajes de',
                    ],
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
                'selector' => '{{WRAPPER}} .heading-lg',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .desc-process',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-lg' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .desc-process' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Number Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .number' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'label' => esc_html__('Card Background', 'textdomain'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-process',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <section class="position-relative overflow-hidden box-process">
            <div class="container" data-aos="fade-up">
                <div class="box-list-process">
                    <?php foreach ($settings['process_items'] as $index => $item) : 
                        $duration = ($index % 3) * 400;
                    ?>
                    <div class="item-process" data-aos="fade-up" data-aos-duration="<?php echo esc_attr($duration); ?>">
                        <div class="card-process">
                            <div class="card-icon">
                                <div class="image">
                                    <img src="<?php echo esc_url($item['process_image']['url']); ?>" alt="Vatech" />
                                </div>
                                <div class="number"><?php echo esc_html($item['process_number']); ?></div>
                            </div>
                            <div class="card-info">
                                <h5 class="heading-lg color-white"><?php echo esc_html($item['process_title']); ?></h5>
                                <p class="button-sm desc-process"><?php echo esc_html($item['process_description']); ?></p>
                                <a href="<?php echo esc_url($item['process_link']['url']); ?>" class="link-upper">Read More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }
}

$widgets_manager->register(new vtech_service());