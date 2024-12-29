<?php
namespace vtech_team\Widgets;

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

class vtech_team_member extends Widget_Base {

    public function get_name() {
        return 'team-member-widget';
    }

    public function get_title() {
        return __('Team Member Widget', 'elementor-hello-world');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {
        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'textdomain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label' => esc_html__('Card Style', 'textdomain'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1 (Consultant)', 'textdomain'),
                    'style2' => esc_html__('Style 2 (Team)', 'textdomain'),
                    'style3' => esc_html__('Style 3 (Team 2)', 'textdomain'),
                ],
            ]
        );

        $this->end_controls_section();

        // Content Section
  team_parts_code($this);
        // Style Section - Card
        $this->start_controls_section(
            'style_card_section',
            [
                'label' => esc_html__('Card Style', 'textdomain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => esc_html__('Background Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-consultant, {{WRAPPER}} .card-team' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Border', 'textdomain'),
                'selector' => '{{WRAPPER}} .card-consultant, {{WRAPPER}} .card-team',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => esc_html__('Box Shadow', 'textdomain'),
                'selector' => '{{WRAPPER}} .card-consultant, {{WRAPPER}} .card-team',
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'style_typography_section',
            [
                'label' => esc_html__('Typography', 'textdomain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .heading-ag-lg, {{WRAPPER}} .card-info h6',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => esc_html__('Position Typography', 'textdomain'),
                'selector' => '{{WRAPPER}} .paragraph-ag-base, {{WRAPPER}} .card-info p',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Name Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-ag-lg, {{WRAPPER}} .card-info h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Position Color', 'textdomain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .paragraph-ag-base, {{WRAPPER}} .card-info p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if($settings['card_style'] === 'style1') {
            ?>
            <div class="card-consultant">
                <div class="card-image">
                    <a href="#">
                        <img src="<?php echo esc_url($settings['member_image']['url']); ?>" alt="<?php echo esc_attr($settings['member_name']); ?>" />
                    </a>
                </div>
                <div class="card-info">
                    <div class="card-info-inner">
                        <a href="#">
                            <h4 class="heading-ag-lg"><?php echo esc_html($settings['member_name']); ?></h4>
                        </a>
                        <p class="paragraph-ag-base grey-100"><?php echo esc_html($settings['member_position']); ?></p>
                        <div class="consultant-social">
                            <?php foreach ($settings['social_links'] as $item) : ?>
                                <a href="<?php echo esc_url($item['social_link']['url']); ?>">
                                    <img src="<?php echo esc_url($item['social_icon_image']['url']); ?>" alt="social icon" />
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } elseif($settings['card_style'] === 'style2'){
            ?>
            <div class="card-team">
                <div class="card-social">
                    <?php foreach ($settings['social_links'] as $item) : ?>
                        <a href="<?php echo esc_url($item['social_link']['url']); ?>" class="share <?php echo esc_attr($item['social_icon']); ?>"></a>
                    <?php endforeach; ?>
                </div>
                <div class="card-image">
                    <div class="card-image-inner"></div>
                    <img src="<?php echo esc_url($settings['member_image']['url']); ?>" alt="<?php echo esc_attr($settings['member_name']); ?>" />
                </div>
                <div class="card-info">
                    <h6 class="heading-ag-lg"><?php echo esc_html($settings['member_name']); ?></h6>
                    <p class="paragraph-ag-base grey-100"><?php echo esc_html($settings['member_position']); ?></p>
                </div>
            </div>
            <?php
        } else {
            ?>
       <div class="card-dedicated">
    <div class="card-image">
        <a href="#">  <img src="<?php echo esc_url($settings['member_image']['url']); ?>" alt="<?php echo esc_attr($settings['member_name']); ?>" /></a>
        <div class="card-social">
            <?php foreach ($settings['social_links'] as $item) : ?>
                        <a href="<?php echo esc_url($item['social_link']['url']); ?>" class="share <?php echo esc_attr($item['social_icon']); ?>"></a>
                    <?php endforeach; ?>
        </div>
    </div>
    <div class="card-info">
        <div class="info-left">
            <a href="#" class="heading-ag-lg"><?php echo esc_html($settings['member_name']); ?></a>
            <p class="paragraph-ag-base grey-100"><?php echo esc_html($settings['member_position']); ?></p>
        </div>
        <div class="info-right">
            <a href="#">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.8594 12.9688C14.7015 12.9688 13.6812 13.5383 13.0404 14.4045L7.49961 11.5673C7.5916 11.2538 7.65625 10.9288 7.65625 10.5859C7.65625 10.1209 7.5609 9.67871 7.39617 9.27203L13.1948 5.78266C13.8401 6.54 14.7886 7.03125 15.8594 7.03125C17.798 7.03125 19.375 5.45426 19.375 3.51562C19.375 1.57699 17.798 0 15.8594 0C13.9207 0 12.3438 1.57699 12.3438 3.51562C12.3438 3.96238 12.4357 4.38617 12.5884 4.77961L6.77246 8.27922C6.1277 7.54437 5.19285 7.07031 4.14062 7.07031C2.20199 7.07031 0.625 8.6473 0.625 10.5859C0.625 12.5246 2.20199 14.1016 4.14062 14.1016C5.31758 14.1016 6.35512 13.5153 6.99356 12.6248L12.5161 15.4527C12.4143 15.7811 12.3438 16.123 12.3438 16.4844C12.3438 18.423 13.9207 20 15.8594 20C17.798 20 19.375 18.423 19.375 16.4844C19.375 14.5457 17.798 12.9688 15.8594 12.9688Z" fill="" />
                </svg>
            </a>
        </div>
    </div>
</div>

            <?php
        }
    }
}

$widgets_manager->register(new vtech_team_member());