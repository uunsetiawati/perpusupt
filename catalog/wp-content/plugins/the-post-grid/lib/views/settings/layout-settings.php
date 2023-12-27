<?php
echo rtTPG()->rtFieldGenerator(rtTPG()->rtTPGLayoutSettingFields(), true);
echo '<div class="rd-responsive-column">';
echo rtTPG()->rtFieldGenerator(rtTPG()->responsiveSettingsColumn(), true);
echo '</div>';
echo rtTPG()->rtFieldGenerator(rtTPG()->layoutMiscSettings(), true);
