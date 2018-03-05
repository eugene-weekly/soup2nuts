<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * Event Submission Form
 * The wrapper template for the event submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/submit.php
 *
 * @since    4.5
 * @version  4.5
 */
?>

<div class="tribe-section tribe-section-cost">
	<div class="tribe-section-header">
		<h3>Please Read</h3>
	</div>


	<div class="tribe-section-content">
		<p>If you’re submitting an event for the upcoming week past the Thursday of this current week, at noon, you are past our deadline for the print calendar and your event will not be in our print issue. All events must be submitted the Thursday a week before publication to make it into the paper.</p>
		<p class="event-submission-warning">Please double check all information about this event. Any incorrect data will be published as-is. The more accurate the information, the more people will attend your event.</p>
	</div>

	</div>



<?php
$events_label_singular = tribe_get_event_label_singular();

if ( isset( $post_id ) && $post_id ) {
	$button_label = sprintf( __( 'Update %s', 'tribe-events-community' ), $events_label_singular );
} else {
	$button_label = sprintf( __( 'Submit %s', 'tribe-events-community' ), $events_label_singular );
}
$button_label = apply_filters( 'tribe_community_event_edit_button_label', $button_label );
?>

<div class="tribe-events-community-footer">
	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_submit' );
	?>

	<input
		type="submit"
		id="post"
		class="tribe-button submit events-community-submit"
		value="<?php echo esc_attr( $button_label ); ?>"
		name="community-event"
	/>

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_submit' );
	?>
</div>
