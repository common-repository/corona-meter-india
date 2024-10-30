<?php
// The widget class
class CMI_Country extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
		'corona_meter_india_country',
		__( 'Corona Meter Country', 'corona-meter-india' ),
		array(
			'customize_selective_refresh' => true,
		)
	);
	}

	// The widget form (for the backend )
	public function form( $instance ) {	
		
	// Set widget defaults
	$defaults = array(
		'title'    => '',
		
	);
	
	// Parse current settings with defaults
	extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

	<?php // Widget Title ?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'corona-meter-india' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	
<?php

	}

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
	return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) 
	{
		extract( $args );

		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';
		
		// WordPress core before_widget hook (always include )
		echo $before_widget;

		//Using HTTP Api
		$responsea = wp_remote_get( 'https://covid-19india-api.herokuapp.com/v2.0/country_data');

		?>
		<div class="widget-text wp_widget_cmi_box">
		<?php			
		// Display widget title if defined
		
		echo $before_title . $title . $after_title."<br />";
			
		if( is_wp_error( $responsea ) ) 
		{
			?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Server Issue', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php _e('Please Try Later', 'corona-meter-india'); ?></span>
			</div>
			<?php
					
			
		}//if error
		else
		{
			$responsea = json_decode( wp_remote_retrieve_body($responsea), true );
			$responsea=$responsea[1];
						
			if($responsea)
			{
				?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Country', 'corona-meter-india'); ?></span>
			<span><span class="cmi_count flagicon"><img src="<?php echo plugin_dir_url( __DIR__ ).'images/indianflag.png'; ?>"> <?php _e('India', 'corona-meter-india'); ?></span></span>
			</div>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Updated', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['last_updated']; ?></span>
			</div>
			
			<div class="cmi_blk activecases">
			<span class="cmi_title"><?php _e('Active Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['active_cases']; ?></span>
			</div>
			
			<div class="cmi_blk ">
			<span class="cmi_title"><?php _e('Active Rate', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['active_rate']; ?></span>
			</div>
			
			<div class="cmi_blk confirmedcases">
			<span class="cmi_title"><?php _e('Confirmed Cases', 'corona-meter-india'); ?> </span>
			<span class="cmi_count"><?php echo $responsea['confirmed_cases']; ?></span>
			</div>
			
			<div class="cmi_blk deathcases">
			<span class="cmi_title"><?php _e('Death Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['death_cases']; ?></span>
			</div>
			
			<div class="cmi_blk recoveredcases">
			<span class="cmi_title"><?php _e('Recovered Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['last_total_recovered_cases']; ?></span>
			</div>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Passengers Screened (Airport)', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $responsea['passengers_screened']; ?></span>
			</div>
			<?php
			}
			else
			{
				?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Server Issue', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php _e('Please Try Later', 'corona-meter-india'); ?></span>
			</div>
			<?php
			}
			
		
		}//no error
				
		
		echo '</div>';

	// WordPress core after_widget hook (always include )
	echo $after_widget;
	}

}