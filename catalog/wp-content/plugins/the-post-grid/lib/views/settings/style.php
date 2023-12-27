<?php echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPGStyleFields(), true ); ?>

<div class="field-holder button-color-style-wrapper">
    <div class="field-label"><?php _e( 'Button Color', 'the-post-grid' ); ?></div>
    <div class="field">
        <div class="tpg-multiple-field-group">
			<?php echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPGStyleButtonColorFields(), true ); ?>
        </div>
    </div>
</div>

<div class="field-holder widget-heading-stle-wrapper">
    <div class="field-label"><?php _e( 'ShortCode Heading', 'the-post-grid' ); ?></div>
    <div class="field">
        <div class="tpg-multiple-field-group">
			<?php echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPGStyleHeading(), true ); ?>
        </div>
    </div>
</div>

<div class="field-holder full-area-style-wrapper">
    <div class="field-label"><?php _e( 'Full Area / Section', 'the-post-grid' ); ?></div>
    <div class="field">
        <div class="tpg-multiple-field-group">
			<?php echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPGStyleFullArea(), true ); ?>
        </div>
    </div>
</div>

<?php do_action('rt_tpg_sc_style_group_field'); ?>

<?php echo rtTPG()->rtSmartStyle( rtTPG()->extraStyle() ); ?>


