<?php
namespace vtech_pricing\Widgets;

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

class vtech_pricing_member extends Widget_Base {

    public function get_name() {
        return 'pricing-card-widget';
    }

    public function get_title() {
        return __('Pricing Card', 'vtech-core');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
            'pricing_style',
            [
                'label' => esc_html__('Pricing Style', 'vtech-core'),
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
                'label' => esc_html__('Pricing Content', 'vtech-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'package_name',
            [
                'label' => esc_html__('Package Name', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Basic Package',
            ]
        );

        $this->add_control(
            'package_icon',
            [
                'label' => esc_html__('Package Icon', 'vtech-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'package_description',
            [
                'label' => esc_html__('Description', 'vtech-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Pricing plan for startup company',
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label' => esc_html__('Currency Symbol', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '$',
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '129',
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => esc_html__('Period', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '/month',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'feature_text',
            [
                'label' => esc_html__('Feature Text', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Feature Item',
            ]
        );

        $repeater->add_control(
            'is_available',
            [
                'label' => esc_html__('Is Available', 'vtech-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'features_list',
            [
                'label' => esc_html__('Features List', 'vtech-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'feature_text' => '5000 User Activities',
                        'is_available' => 'yes',
                    ],
                    [
                        'feature_text' => 'Unlimited Access',
                        'is_available' => 'yes',
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'vtech-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Get Started',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'vtech-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
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
            'card_background',
            [
                'label' => esc_html__('Background Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-pricing, {{WRAPPER}} .card-pricing-2' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .card-pricing, {{WRAPPER}} .card-pricing-2',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .card-pricing, {{WRAPPER}} .card-pricing-2',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'package_name_typography',
                'label' => esc_html__('Package Name Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .pricing-name h6',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .pricing-price h2',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_typography',
                'label' => esc_html__('Features Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .list-ticked li',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if($settings['pricing_style'] === 'style1') {
            ?>
            <div class="card-pricing">
                <div class="top-pricing">
                    <div class="pricing-name">
                        <h6 class="heading-lg color-white"><?php echo esc_html($settings['package_name']); ?></h6>
                        <div class="pricing-icon">
                            <img src="<?php echo esc_url($settings['package_icon']['url']); ?>" alt="<?php echo esc_attr($settings['package_name']); ?>" />
                        </div>
                    </div>
                    <div class="paragraph-base desc-pricing grey-100"><?php echo esc_html($settings['package_description']); ?></div>
                    <div class="pricing-price">
                        <span class="currency"><?php echo esc_html($settings['currency_symbol']); ?></span>
                        <h2><?php echo esc_html($settings['price']); ?></h2>
                        <span class="package-name"><?php echo esc_html($settings['period']); ?></span>
                    </div>
                </div>
                <div class="bottom-pricing">
                    <ul class="list-ticked mb-40">
                        <?php foreach($settings['features_list'] as $item) : ?>
                            <li class="<?php echo $item['is_available'] ? '' : 'unavailable'; ?>"><?php echo esc_html($item['feature_text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-button text-center">
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="btn btn-border-primary-500">
                            <?php echo esc_html($settings['button_text']); ?>
                            <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.3333 12C11.3333 11.364 11.8525 10.4143 12.3781 9.61714C13.0539 8.58857 13.8614 7.69114 14.7872 7.00629C15.4813 6.49286 16.3228 6 17 6M17 6C16.3228 6 15.4806 5.50714 14.7872 4.99371C13.8614 4.308 13.0539 3.41057 12.3781 2.38371C11.8525 1.58571 11.3333 0.634285 11.3333 -3.66907e-07M17 6L7.39105e-07 6" stroke="" stroke-width="1.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="card-pricing-2">
                <div class="top-pricing">
                    <div class="pricing-name">
                        <h6 class="heading-ag-lg dark-950"><?php echo esc_html($settings['package_name']); ?></h6>
                        <div class="pricing-icon">
                            <img src="<?php echo esc_url($settings['package_icon']['url']); ?>" alt="<?php echo esc_attr($settings['package_name']); ?>" />
                        </div>
                    </div>
                    <div class="paragraph-rubik-m desc-pricing dark-950"><?php echo esc_html($settings['package_description']); ?></div>
                    <div class="pricing-price">
                        <h2 class="heading-ag-xl"><?php echo esc_html($settings['currency_symbol'] . $settings['price']); ?></h2>
                    </div>
                </div>
                <div class="bottom-pricing">
                    <ul class="list-ticked mb-40">
                        <?php foreach($settings['features_list'] as $item) : ?>
                            <li class="<?php echo $item['is_available'] ? '' : 'unavailable'; ?>"><?php echo esc_html($item['feature_text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-button text-center">
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="btn btn-border-950">
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

$widgets_manager->register(new vtech_pricing_member());