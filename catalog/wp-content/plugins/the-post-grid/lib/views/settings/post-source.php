<?php

echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPGPostType() );
$sHtml = null;
$sHtml .= '<div class="field-holder rt-tpg-field-group">';
$sHtml .= '<div class="field-label">Common Filters</div>';
$sHtml .= '<div class="field">';
$sHtml .= rtTPG()->rtFieldGenerator( rtTPG()->rtTPGCommonFilterFields(), true );
$sHtml .= '</div>';
$sHtml .= '</div>';

echo $sHtml;

?>

<div class='rt-tpg-filter-container rt-tpg-field-group'>
	<?php echo rtTPG()->rtFieldGenerator( rtTPG()->rtTPAdvanceFilters() ); ?>
    <div class="rt-tpg-filter-holder">
		<?php
		$html       = null;
		$pt         = get_post_meta( $post->ID, 'tpg_post_type', true );
		$advFilters = rtTPG()->rtTPAdvanceFilters();
		echo $html;
		?>
    </div>
</div>

<div class="rt-tpg-field-group">
	<?php echo rtTPG()->rtFieldGenerator( rtTPG()->stickySettings(), true ); ?>
</div>