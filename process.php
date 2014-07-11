<?php

// tasks:
// 'IEGCSA Dir' => array('replacement' => 'iegcsa_dir', 'process' => null, 'private' => true ),

global $c;

if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
        	 $rand = time();
                 //Print file details
             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

             if( "text/csv" != $_FILES["file"]["type"] ){
	             echo $_FILES["file"]["name"] . " is not a valid CSV file. ";
	             die();
             }

             $pieces = explode(".", $_FILES["file"]["name"]);
             
             if( 1 < count( $pieces )){
             	$pieces = array_merge(array_slice($pieces, 0, sizeof($pieces) - 1 ), array($rand), array_slice($pieces, -1) ); 
	             $storagename = join( ".", $pieces );
             }else{
	        	$storagename = $rand . $_FILES["file"]["name"] ;     
             }

                 //if file already exists
             if (file_exists("./temp/" . $storagename)) {
            echo $_FILES["file"]["name"] . " already exists. ";
             }
             else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            
            // move_uploaded_file($_FILES["file"]["tmp_name"], "temp/" . $storagename);
            // echo "Stored in: " . "temp/" . $storagename . "<br />";
            
            process_csv($_FILES["file"]["tmp_name"], "./temp/" . $storagename );
            
            echo "Download Processed File in: <a href='./temp/" . $storagename . "'>" . "./temp/" . $storagename . "</a><br />";
            
            }
        }
     } else {
             echo "No file selected <br />";
     }
} else {
	?>
	<table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select file</td>
<td width="80%"><input type="file" name="file" id="file" /></td>
</tr>

<tr>
<td>Submit</td>
<td><input type="submit" name="submit" /></td>
</tr>

</form>
</table>
	<?php
}


global $original_data;


function process_csv( $input_file, $output_file ){
	
	global $original_data;
	
	$process_rules = array(
		'First name' => array('replacement' => 'first_name', 'process' => null ),
		'Last name' => array('replacement' => 'last_name', 'process' => null ),
		'Course Company' => array('replacement' => 'course_company', 'process' => null ),
		'Prefer address 1' => array('replacement' => 'primary_address_1', 'process' => 'clean_address' ),
		'Prefer address 2' => array('replacement' => 'primary_address_2', 'process' => null ),
		'Prefer city' => array('replacement' => 'primary_city', 'process' => null ),
		'Prefer state' => array('replacement' => 'primary_state', 'process' => null ),
		'Prefer zip' => array('replacement' => 'primary_zip', 'process' => 'clean_zip_code' ),
		'Work tele 1' => array('replacement' => 'work_tele_1', 'process' => 'clean_phone_number' ),
		'Work tele 2' => array('replacement' => 'work_tele_2', 'process' => 'clean_phone_number' ),
		'Cell phone' => array('replacement' => 'cell_phone', 'process' => 'clean_phone_number' ),
		'Fax number' => array('replacement' => 'fax_number', 'process' => 'clean_phone_number' ),
		'email address' => array('replacement' => 'user_email', 'process' => 'clean_email' ),
		'Member class' => array('replacement' => 'member_class', 'process' => 'clean_member' ),
		'Member number' => array('replacement' => 'member_number', 'process' => 'clean_number' ),
		'Position Title' => array('replacement' => 'position_title', 'process' => null ),
		'Course type' => array('replacement' => 'course_type', 'process' => null ),
		'Number of holes' => array('replacement' => 'number_of_holes', 'process' => 'clean_number' ),
		'Pesticide license' => array('replacement' => 'pesticide_license', 'process' => 'clean_pesticide' ),
		'GCSAA Member' => array('replacement' => 'gcsaa_member', 'process' => 'gcsaa_clean' ),
		'Spouse' => array('replacement' => 'spouse', 'process' => 'clean_spouse' ),
		'Services offered' => array('replacement' => 'services_offered', 'process' => 'services_offered_clean' ),
		'Membership date' => array('replacement' => 'membership_date', 'process' => null ),
		'IDGCSA Dir' => array('replacement' => 'idgcsa_dir', 'process' => null ),
		'Miscellaneous' => array('replacement' => 'miscellaneous', 'process' => null ),
		'Second address 1' => array('replacement' => 'secondary_address_1', 'process' => null ),
		'Second address 2' => array('replacement' => 'secondary_address_2', 'process' => null ),
		'Second city' => array('replacement' => 'secondary_city', 'process' => null ),
		'Second state' => array('replacement' => 'secondary_state', 'process' => null ),
		'Second zip' => array('replacement' => 'secondary_zip', 'process' => 'clean_zip_code' ),
		'Home tele' => array('replacement' => 'home_tele', 'process' => 'clean_phone_number' ),
		'Country' => array('replacement' => 'country', 'process' => null ),
		'FMI' => array('replacement' => 'fmi', 'process' => null ),
		'Dues paid' => array('replacement' => 'dues_paid', 'process' => null ),
		'Full name' => array('replacement' => 'full_name', 'process' => null ),
		'Home Work address' => array('replacement' => 'home_work_address', 'process' => null ),
		'CGCS Design' => array('replacement' => 'cgcs_design', 'process' => null ),
		'Fax GCSAA' => array('replacement' => 'fax_gcsaa', 'process' => 'clean_phone_number' ),
		'Chapter' => array('replacement' => 'chapter', 'process' => null ),
		'DOB' => array('replacement' => 'dob', 'process' => null ),
		'Voting' => array('replacement' => 'voting', 'process' => null ),
		'Middle Initial' => array('replacement' => 'middle_initial', 'process' => null ),
		'GCSAA Cell' => array('replacement' => 'gcsaa_cell', 'process' => 'clean_phone_number' ),
		// 'user email' => array('replacement' => 'user_email', 'process' => 'fake_email' ),
		'user login' => array('replacement' => 'user_login', 'process' => 'user_login' ),
		'user password' => array('replacement' => 'user_password', 'process' => 'fake_password' ),
		'user role' => array('replacement' => 'role', 'process' => 'role' ),
		'display name' => array('replacement' => 'display_name', 'process' => 'display_name' ),
		'preferred address' => array('replacement' => 'preferred_address', 'process' => 'preferred_address' ),
		'premium member' => array('replacement' => 'premium_member', 'process' => 'premium_member' ),
	);

 global $row;
	$row = 1;
if (($handle = fopen($input_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    
    	if( 1 == $row){
	    	foreach($data as &$header){
	    		if( isset($process_rules[$header] ) ){
	    			$headers[] = $header;
	    			$header = $process_rules[$header]['replacement'];
	    		}else{
		    		$headers[] = $header;	
	    		}
		    	
	    	}
	    	unset($header);
	    	
	    //	$data[] = 'user_email';
	    	$data[] = 'user_login';
	    	$data[] = 'user_password';
	    	$data[] = 'role';
	    	$data[] = 'display_name';
	    	$data[] = 'preferred_address';
	    	$data[] = 'premium_member';
	    	
	    	$list[] = $data;	
	    	
	    //	$headers[] = 'user email';
	    	$headers[] = 'user login';
	    	$headers[] = 'user password';
	    	$headers[] = 'user role';
	    	$headers[] = 'display name';
	    	$headers[] = 'preferred address';
	    	$headers[] = 'premium member';
	    	
	    	
    	}else{
    		$original_data = $data;
    		$c = 0;
    		foreach($data as &$column){
	    		if( $process_rules[$headers[$c]]['process'] ){
		    		// echo $process_rules[$headers[$c]]['process'];
		    		$func = (STRING)$process_rules[$headers[$c]]['process'];
		    		$column = $func($column);
	    		}
		    	
		    	$c++;
	    	}
    	
	    /*
		    $func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
*/
    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	
	    	$func = (STRING)$process_rules[$headers[$c]]['process'];
	    	$data[] = $func($data);
	    	$c++;
	    	    	
	    	$list[] = $data;	
    	}
        
        
        $row++; 
    }
    fclose($handle);
}

// var_dump($headers);

foreach($headers as $header){
	// echo "'".$header."' => array('replacement' => 'custom_".str_clean($header)."', 'process' => null ),"."\n";
}

$fp = fopen($output_file, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
	
}

function str_clean($string){
	$string = strtolower($string);
	$string = str_replace(" ","_",$string);
	
	
	return $string;
}


function fake_email($data){
	 global $row;
	return substr($row.md5(serialize($data)),0,8)."@idahogcsa.org";
}

function clean_number($phone){
	
	$phone = preg_replace('/\D/', '', $phone);
	
	return $phone;
}

function clean_phone_number($phone){
	
	// $phone = preg_replace('/\D/', '', $phone);
	
	$find = array('(',') ','-');
	
	$replace = "";
	
	$phone = str_replace($find, $replace, $phone);
	
	return $phone;
}

function clean_zip_code($zip_code){
	
	// $phone = preg_replace('/\D/', '', $phone);
	
	// allow for Canadian Postal Codes
	
	return trim($zip_code);
}



//       'user login' => array('replacement' => 'user_login', 'process' => 'user_login' ),

function user_login($data){
	return strtolower(trim($data[12]));
}


// 		'user password' => array('replacement' => 'user_password', 'process' => 'fake_password' ),
function fake_password($data){
	return substr(md5(microtime()),0,8);
}


//		'user role' => array('replacement' => 'role', 'process' => 'role' ),

function role($data){
	if($data[13])
	return "member";
	else
	return "non-member";
}

function display_name($data){
	return $data[0]." ".$data[1];
}


function clean_email($email){
	global $row;
	
	$email = str_replace('e','', $email);
	
	$email = trim($email);
	
	if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
		return $email;
	}else{
		return substr(md5($email.$row),0,8)."@idahogcsa.org";
	}
	
}


function preferred_address($data){
	global $original_data;
	if( '*' == substr($original_data[3], 0, 1))
	return "true";
	else
	return "false";
}

function clean_address($address){
	return trim($address,'*');
}

function premium_member($data){
	global $original_data;
	if( '.' == substr($original_data[13], 1, 1))
	return "true";
	else
	return "false";
}

function clean_member($member){
	return trim(str_replace('.','',$member));
}


function clean_spouse($spouse){
	//$spouse = str_replace('spouse: ','',$spouse);
	//$spouse = str_replace('Spouse: ','',$spouse);
	//$spouse = str_replace('spouse ','',$spouse);
	//$spouse = str_replace('Spouse ','',$spouse);
	
	$find = array('Spouse:','spouse:','Spouse','spouse');
	
	$replace = "";
	
	$spouse = str_replace($find, $replace, $spouse);
	
	return trim($spouse);
}

function clean_pesticide($pesticide){
	// $pesticide = str_replace('pesticide:','',$pesticide);
	// $pesticide = str_replace('Pesticide:','',$pesticide);
	// $pesticide = str_replace('pesticide','',$pesticide);
	// $pesticide = str_replace('Pesticide','',$pesticide);
	
	$find = array('pesticide:','Pesticide:','pesticide','Pesticide','Pesticide license:','Pesticide License:', 'Pesticide license', 'Pesticide license:', 'pesticide license:', 'pesticide license');
	
	$replace = "";
	
	$pesticide = str_replace($find,$replace, $pesticide);
	
	return trim($pesticide);
}


function gcsaa_clean($gcsaa){
	
	$find = array('GCSAA:','GCSAA Member:','GCSAA member:','member:','Member:');
	$replace = "";
	$gcsaa = str_replace($find, $replace, $gcsaa);
	
	
	return trim($gcsaa);
}

function services_offered_clean($services_offered){
	
	$find = array('(',')');
	$replace = "";
	$services_offered = str_replace($find, $replace, $services_offered);
	
	
	return trim($services_offered);
}