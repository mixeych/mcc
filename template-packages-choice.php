<?php
global $sitepress;
check_user_auth();
$current_language = $sitepress->get_current_language();
if($current_language == "en") {
?>
	<div class="container">
		<div id="choice_package_header">
			SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT 
		</div>
		<div id="choice_package_content">
			<div class="choice_package_gray">
				<div class="choice_package_gray_header"><strong>BASIC</strong><span>להופעה במאגר העסקים ומשהו</span></div>
				<div class="choice_package_gray_list">
					<ul>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li>TEXT</li>
						<li class="choice_package_gray_list_gray">TEXT</li>
					</ul>
				</div>
				<div class="choice_package_gray_price"><span>30</span>₪ + Tax per month</div>
				<div class="choice_package_gray_terms">
					<input type="checkbox" /> On select package, I agree with terms and conditions.
				</div>
				<div class="choice_package_gray_add_button">Select</div>
			</div>
		</div>
	</div>
<?php
} elseif($current_language == "he") {
?>
	<div class="container">
		<div id="choice_package_header">
			SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT SOME TEXT 
		</div>
		<div id="choice_package_content">
			<div class="choice_package_gray">
				<div class="choice_package_gray_header"><strong>הבסיסית</strong><span>להופעה במאגר העסקים ומשהו</span></div>
				<div class="choice_package_gray_list">
					<ul>
						<li>לוגו</li>
						<li>תיאור מקוצר</li>
						<li>תיאור מורחב</li>
						<li>שינוי הטבה ראשית בכל עת</li>
						<li>5 תמונות דינאמיות</li>
						<li>הופעה בתת קטגוריה אחת</li>
						<li>קישור לדף הבית</li>
						<li>קישור לפייסבוק</li>
						<li>מיקום עדיף</li>
						<li>שליחת 1,000 הודעות מבצע וקופונים בחודש</li>
						<li>פרסום 10 מבצעים והטבות נוספות</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>