<div class="field-holder">
    <div class="field-label"><?php _e('ShortCode Heading', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCHeadingSettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label">
        <label><?php esc_html_e('Category', 'the-post-grid'); ?></label>
    </div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCCategorySettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label"><?php _e('Title', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCTitleSettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label"><?php _e('Meta', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCMetaSettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label"><?php _e('Image', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCImageSettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label"><?php _e('Excerpt', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCExcerptSettings(), true); ?>
    </div>
</div>
<div class="field-holder">
    <div class="field-label"><?php _e('Read More Button', 'the-post-grid'); ?></div>
    <div class="field">
        <?php echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGSCButtonSettings(), true); ?>
    </div>
</div>