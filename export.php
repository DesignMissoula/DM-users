<?php

include '../../../wp-load.php';

header("Content-Type:text/plain");

global $wpdb;

// var_dump($wpdb);

$blogusers = get_users(
						array('orderby' => 'meta_value', 'meta_key' => 'last_name', 'role' => 'member', 'number' => 999, 'fields' => 'all_with_meta',
		)
	);

foreach($blogusers as $user){
	
	//$html .= '<div class="entry clearfix">';
    	$html .= ''.$user->last_name.', '.$user->first_name."\t".str_replace('.','',$user->member_class).''.$user->member_number."\n";
    	$html .= ($user->course_company)?''.$user->course_company."\n":'';
    	$html .= ($user->position_title)?''.$user->position_title."\n":'';
    	$html .= ''.trim(str_replace('*','',$user->primary_address_1))."\n";
    	$html .= (($user->primary_address_2)?''.$user->primary_address_2."\n":'');
    	$html .= ''.$user->primary_city.', '.$user->primary_state.' '.$user->primary_zip."\n";
    	$html .= ($user->work_tele_1)?''.format_phone($user->work_tele_1).(($user->work_tele_2)?' Alt: '.format_phone($user->work_tele_2):'')."\n":'';
    	$html .= 'Cell: '.(($user->cell_phone)?''.format_phone($user->cell_phone)."\t":'Not Provided'."\t").((trim($user->fax_number))?'Fax: '.format_phone($user->fax_number):'')."\n";
    	
    	// setup base email
    	$domain = str_ireplace('www.', '', parse_url(get_site_url(), PHP_URL_HOST));
    	
    	$html .= (!stristr($user->user_email, '@'.$domain))?''.$user->user_email."\n":'';
    	// $html .= ''.$user->user_email."\n";
    	
    	$find = array('Pesticide License:', 'Pesticide:', 'Pesticide:', 'Pesticide', 'Pesticide License', 'pesticide license:', 'pesticide:', 'pesticide license', 'License', 'license', ':');
    	$replace = '';
    	
    	$html .= 'GCSAA Member: '.(("" != $user->gcsaa_member)?'Yes':'No')."\t".'Pesticide License: '.(($user->pesticide_license && trim(str_replace($find,$replace,$user->pesticide_license)))?ucwords(strtolower((trim(str_replace($find,$replace,$user->pesticide_license))))):'No')."\n";
    	
    	$find = array('Spouse:', 'spouse:', 'Spouse', 'spouse', ':');
    	$replace = '';
    	
    	$html .= (($user->number_of_holes)?'Course: '.$user->number_of_holes.' holes'."\t":'');
    	$html .= ($user->spouse)?'Spouse: '.trim(str_replace($find,$replace,$user->spouse))."\n":'';
    	
    	$html .= ($user->number_of_holes && ! $user->spouse )?"\n":'';
    	
    	$find = array('(',')');
    	$replace = '';
    	
    	$html .= ''.(($user->services_offered)?'('.str_replace($find,$replace,$user->services_offered).')'."\n":'').'';
    	
    	$html .= "\n";
    	
    	// get_avatar( $id_or_email, $size, $default, $alt );
    	// $html .= '<div class="gravatar alignleft">' . get_avatar( $user->ID, 128, null, $user->display_name ) . "\n";
        // $html .= '<div class="entry-details">';
       //  $html .= '' . $user->last_name . '<br/>';
       // $html .= '' . $user->user_email . "\n";
  
     //  $html .= '<span>Member Class:</span> '.str_replace('.','',$user->member_class).'<br/>';
       
      
       // $html .= '<span>Preferred work number #1 and #2:</span> <a href="tel:'.$user->work_tele_1.'">'.format_phone($user->work_tele_1).' </a> <a href="tel:'.$user->work_tele_2.'">'.format_phone($user->work_tele_2).'</a><br/>';
       //$html .= '<span>Cell Phone:</span> <a href="tel:'.$user->cell_phone.'">'.format_phone($user->cell_phone).'</a><br/>';
      // $html .= '<span>Fax Number:</span> <a href="tel:'.$user->fax_number.'">'.format_phone($user->fax_number).'</a><br/>';
      // $html .= '<span>Email Address:</span> <a href="mailto:'.$user->user_email.'">'.$user->user_email.'</a><br/>';
      // $html .= '<span>GCSAA Member:</span> '.(("" != $user->gcsaa_member)?'yes':'no').'<br/>';
       //
       
       
  
      // $html .= '</div><!-- end details -->';
       // $html .= '</div><!-- end entry -->';
        // $html .= '<br/><!-- end entry -->'; 
     //   $html .= '<br/><!-- end entry -->'; 
     
    // $html .= "\n";
	
}

echo $html;