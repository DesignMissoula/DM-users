<?php

/*
Plugin Name: DM User Custom Profiles
Plugin URI: http://www.designmissoula.com/
Description: Add additional fields to user profiles for viewing and editing on backend.
Author: Bradford Knowlton
Version: 1.6.6
Author URI: http://bradknowlton.com/
*/

$custom_profile_fields = array(
	// 'First name' => array('replacement' => 'first_name', 'process' => null ),
	// 'Last name' => array('replacement' => 'last_name', 'process' => null ),
	'Course Company' => array('replacement' => 'course_company', 'process' => null ),
	'Prefer address 1' => array('replacement' => 'primary_address_1', 'process' => null ),
	'Prefer address 2' => array('replacement' => 'primary_address_2', 'process' => null ),
	'Prefer city' => array('replacement' => 'primary_city', 'process' => null ),
	'Prefer state' => array('replacement' => 'primary_state', 'process' => null ),
	'Prefer zip' => array('replacement' => 'primary_zip', 'process' => 'clean_number' ),
	'Work tele 1' => array('replacement' => 'work_tele_1', 'process' => 'clean_number' ),
	'Work tele 2' => array('replacement' => 'work_tele_2', 'process' => 'clean_number' ),
	'Cell phone' => array('replacement' => 'cell_phone', 'process' => 'clean_number' ),
	'Fax number' => array('replacement' => 'fax_number', 'process' => 'clean_number' ),
	// 'email address' => array('replacement' => 'user_email', 'process' => 'fake_email' ),
	'Member class' => array('replacement' => 'member_class', 'process' => null, 'private' => true ),
	'Member number' => array('replacement' => 'member_number', 'process' => 'clean_number', 'private' => true ),
	'Position Title' => array('replacement' => 'position_title', 'process' => null ),
	'Course type' => array('replacement' => 'course_type', 'process' => null ),
	'Number of holes' => array('replacement' => 'number_of_holes', 'process' => 'clean_number' ),
	'Pesticide license' => array('replacement' => 'pesticide_license', 'process' => null ),
	'GCSAA Member' => array('replacement' => 'gcsaa_member', 'process' => null ),
	'Spouse' => array('replacement' => 'spouse', 'process' => null ),
	'Services offered' => array('replacement' => 'services_offered', 'process' => null ),
	'Membership date' => array('replacement' => 'membership_date', 'process' => null, 'private' => true ),
	'IDGCSA Dir' => array('replacement' => 'idgcsa_dir', 'process' => null, 'private' => true ),
	'IEGCSA Dir' => array('replacement' => 'iegcsa_dir', 'process' => null, 'private' => true ),
	'PPGCSA Dir' => array('replacement' => 'ppgcsa_dir', 'process' => null, 'private' => true ),
	'Miscellaneous' => array('replacement' => 'miscellaneous', 'process' => null, 'private' => true ),
	'Second address 1' => array('replacement' => 'secondary_address_1', 'process' => null, 'private' => true ),
	'Second address 2' => array('replacement' => 'secondary_address_2', 'process' => null, 'private' => true ),
	'Second city' => array('replacement' => 'secondary_city', 'process' => null, 'private' => true ),
	'Second state' => array('replacement' => 'secondary_state', 'process' => null, 'private' => true ),
	'Second zip' => array('replacement' => 'secondary_zip', 'process' => 'clean_number', 'private' => true ),
	'Home tele' => array('replacement' => 'home_tele', 'process' => 'clean_number', 'private' => true ),
	'Country' => array('replacement' => 'country', 'process' => null, 'private' => true ),
	'FMI' => array('replacement' => 'fmi', 'process' => null, 'private' => true ), // VERY PRIVATE
	'Dues paid' => array('replacement' => 'dues_paid', 'process' => null, 'private' => true ),
	'Full name' => array('replacement' => 'full_name', 'process' => null, 'private' => true ),
	'Home Work address' => array('replacement' => 'home_work_address', 'process' => null, 'private' => true ),
	'CGCS Design' => array('replacement' => 'cgcs_design', 'process' => null, 'private' => true ),
	'Fax GCSAA' => array('replacement' => 'fax_gcsaa', 'process' => 'clean_number', 'private' => true ),
	'Chapter' => array('replacement' => 'chapter', 'process' => null, 'private' => true ),
	'DOB' => array('replacement' => 'dob', 'process' => null, 'private' => true ),
	'Voting' => array('replacement' => 'voting', 'process' => null, 'private' => true ),
	'Middle Initial' => array('replacement' => 'middle_initial', 'process' => null, 'private' => true ),
	'GCSAA Cell' => array('replacement' => 'gcsaa_cell', 'process' => 'clean_number', 'private' => true ),
	// 'user email' => array('replacement' => 'user_email', 'process' => 'fake_email' ),
	// 'user login' => array('replacement' => 'user_login', 'process' => 'user_login' ),
	// 'user password' => array('replacement' => 'user_password', 'process' => 'fake_password' ),
	// 'user role' => array('replacement' => 'role', 'process' => 'role' ),
	// 'display name' => array('replacement' => 'display_name', 'process' => 'display_name' ),
	'Preferred Address' => array('replacement' => 'preferred_address', 'process' => 'preferred_address', 'private' => true ),
	'Premium Member' => array('replacement' => 'premium_member', 'process' => 'premium_member', 'private' => true ),
);



add_action( 'show_user_profile', 'dm_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'dm_show_extra_profile_fields' );

function dm_show_extra_profile_fields( $user ) {

	global $custom_profile_fields;

	if ( current_user_can( 'manage_options' ) ) {
		/* A user with admin privileges */

?>

	<h3>Extra profile information</h3>

	<table class="form-table">
		<?php foreach($custom_profile_fields as $key => $field){ ?>
			<?php // if(  'true' != $field['private'] ){  // current_user_can( 'manage_options' ) ||  ?>
			<tr>
				<th><label for="<?php echo $field['replacement']; ?>"><?php echo $key; ?></label></th>

				<td>
					<input type="text" name="<?php echo $field['replacement']; ?>" id="<?php echo $field['replacement']; ?>" value="<?php echo esc_attr( get_the_author_meta( $field['replacement'], $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Please enter your <?php echo $key; ?>.</span>
				</td>
			</tr>
			<?php // } // end if ?>
		<?php } // end foreach ?>
	</table>
<?php

	} else {
		/* A user without admin privileges */
	}



}

add_action( 'personal_options_update', 'dm_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'dm_save_extra_profile_fields' );

function dm_save_extra_profile_fields( $user_id ) {

	global $custom_profile_fields;

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	// update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
}

if ( !function_exists('wp_new_user_notification') ) {
	function wp_new_user_notification( ) {}
}

if( $_GET['update_plugins'] == "github" ){
	define( 'WP_GITHUB_FORCE_UPDATE', true );
}else{
	define( 'WP_GITHUB_FORCE_UPDATE', false );
}

add_action( 'init', 'dm_github_plugin_updater_test_init' );
function dm_github_plugin_updater_test_init() {

	include_once plugin_dir_path( __FILE__ ) . 'includes/github-updater.php';

	if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'DM-users',
			'api_url' => 'https://api.github.com/repos/DesignMissoula/DM-users/contents/',
			'github_url' => 'https://github.com/DesignMissoula/DM-users',
			'zip_url' => 'https://api.github.com/repos/DesignMissoula/DM-users/zipball/gcsaa-groups',
			'sslverify' => true,
			'requires' => '3.8',
			'tested' => '3.9.1',
			'readme' => 'README.md',
			'access_token' => '',
		);

		new WP_GitHub_Updater( $config );

	}

}