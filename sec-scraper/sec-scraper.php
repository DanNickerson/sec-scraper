<?php

/*
Plugin Name: RDD SEC Scraper
Description: SEC Scraper to scrape and import exhibits.
Version: 1.0.0
Author: Sahil
Author URI: http://32bitsolutions.com
Text Domain: my-custom-admin-page
*/

include_once(__DIR__.'/parser.php');
include_once(__DIR__.'/scraped-data.php');

function my_admin_menu() {
	add_menu_page(
		__( 'SEC Scraper', 'my-textdomain' ),
		__( 'SEC Scraper', 'my-textdomain' ),
		'manage_options',
		'sec-scraper',
		'scraped_data_page_contents',
		'dashicons-schedule',
		3
	);
	add_submenu_page( 'sec-scraper', 'Scraped Data', 'Scraped Data',
	'manage_options', 'sec-scraper', 'scraped_data_page_contents');
	add_submenu_page( 'sec-scraper', 'Settings', 'Settings',
	'manage_options', 'sec-scraper-settings', 'settings_page_contents');
}
add_action( 'admin_menu', 'my_admin_menu' );

function wp_init_scraper(){
	if(isset($_GET['sec_scraper_934'])){
		delete_all_exhibits_from_db();
		$data = scrape_url(!empty($_POST['custom_url']) ? $_POST['custom_url'] : get_latest_xml_url());
		set_exhibits_to_db($data);
		wp_mail('dln@dannickerson.com', 'Cron Job Is Running Now', 'The cron job at RDD is running now.');
		die('Done');
	}
}
add_action( 'init', 'wp_init_scraper' );

function settings_page_contents(){
	
	if(isset($_POST['clear'])){
		delete_all_exhibits_from_db();
		$data = scrape_url(!empty($_POST['custom_url']) ? $_POST['custom_url'] : get_latest_xml_url());
		set_exhibits_to_db($data);
		get_exhibit_html();
	}
	
	if(isset($_POST['adhoc'])){
		$data = adhoc_scrape($_POST['custom_url']);
		if(count($data) && isset($data[0]) && isset($data[0]['cik_number'])){
			$cik_number = $data[0]['cik_number'];
		}
		set_exhibits_to_db($data);
		if(isset($cik_number)){
			get_exhibit_html($cik_number);
		}
	}
	
	if(isset($_POST['save'])){
		update_option('sec_scraper_positives', $_POST['positives']);
		update_option('sec_scraper_negatives', $_POST['negatives']);
	}
	
	/*
	$agreement_types = get_terms(array(
		'taxonomy'  => 'agreements',
		'hide_empty'=> false,
		'fields' 	=> 'id=>name'
	));
	$posts = get_posts([
	  'post_type' => 'doc',
	  'post_status' => 'publish',
	  'numberposts' => -1
	]);
	foreach ( $posts as $post ) {
		$cats = [];
		foreach($agreement_types as $id => $agreement_type){
			if (substr_count($post->post_content, $agreement_type) >= 3) {
				$cats[] = $id;
			}
		}
		
		if(count($cats) == 0){
			$cats = array_keys(array_filter($agreement_types, function($type) use($post){ return stripos($post->post_title, $type);}));
		}
		if(count($cats)){
			wp_set_post_terms($post->ID, $cats, 'agreements');
		}	
	}
	*/
	?>
		<h1>
			<?php esc_html_e( 'Welcome to SEC Scraper', 'my-plugin-textdomain' ); ?>
		</h1>
		<style>
				.yellow {background-color: #f1cd00!important;font-weight:600;}
				</style>

		<form id="frm-example" method="POST">
			<label><b>SEC XML URL:</b></label><br>
			<p>Click "Clear DB and Scrape" this grabs latest filing from <a target="blank" href="https://www.sec.gov/Archives/edgar/monthly/">https://www.sec.gov/Archives/edgar/monthly/</a> automatically.</p><p>If there's an issue or an error message like <b>"Error: object cannot be created"</b> you just need add XML link manually.<p>To add manually <a target="blank" href="https://www.sec.gov/Archives/edgar/monthly/">click here</a>, scroll to bottom to find current month's link, right click and select "copy link address". then paste below and click button.</p>
			<input type="text" name="custom_url" value="" placeholder="Leave empty to scrape latest filings." style="min-width: 500px;display:block;margin-bottom:6px;"/>
			<button name="clear" value="1" class="button yellow">Clear DB & Scrape</button>
		</form>
		<br>
		<form id="frm-example" method="POST">
			<label><b>Scrape Unique Filing URL</b></label>
			<p>Use the <a target="blank" href="https://www.sec.gov/edgar/search/">edgar search</a> to locate a filing url and enter URL below.  It will pull all exhibits from filing into Scraper results<br/>
			Example: https://www.sec.gov/Archives/edgar/data/<span style="color:red;font-weight:bold">1144546/</span>000168316822005721/0001683168-22-005721-index.html</p>
			<input type="text" name="custom_url" value="" placeholder="" style="min-width: 500px;display:block;margin-bottom:6px;" required/>
			<button name="adhoc" value="1" class="button yellow">Scrape Filing Button</button>
		</form>
		<?php if(isset($cik_number)) {?>
			<a href="<?php echo home_url('/wp-admin/admin.php?page=sec-scraper&cik_number='.$cik_number);?>">See all the scraped documents for CIK: <?php echo $cik_number;?></a>
		<?php }?>
		<!--p>Once you scrape the unique filing url these will be added to the Scraper results.  You can find them using the 7 digit CIK code identified on filing url and in filing url after /data/.  Just put that number in scraper search box to find what you just imported.</p-->
		<br><label><b>Filters Currently Hidden</b></label>
		<br/><hr>

		<form id="frm-example" method="POST">
			<label>Positive Terms: - Ask Dan before editing</label><br>
			<textarea style="min-width: 500px;min-height:200px;" name="positives"><?php echo get_option('sec_scraper_positives')?></textarea>
			<br><br>
			<label>Negative Terms: - Ask Dan before editing </label><br>
			<textarea style="min-width: 500px;min-height:200px;" name="negatives"><?php echo get_option('sec_scraper_negatives')?></textarea>
			<br><br>
			<button name="save" value="1" class="button">Save</button>
		</form>
<br><br>

	<?php
	
	if(isset($data)){
		echo count($data).' exhibits found. Use <b>CIK code</b> from filing page to locate filings in Scraped Data. Now fetching HTML for the exhibits found, should take '.(count($data)/100).' min(s)';
	}
}

function sec_scraper_plugin_deactivation() {
	wp_clear_scheduled_hook( 'sec_scraper_every_min_event' );
}

function sec_scraper_plugin_activation() {
	if (! wp_next_scheduled ( 'sec_scraper_every_min_event' )) {
    	wp_schedule_event( time(), 'per_minute', 'sec_scraper_every_min_event' );
    }
	
	global $wpdb;

	$table_name = $wpdb->prefix . 'exhibits';
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {

		$sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			company_name varchar(255) NOT NULL,
			form_type varchar(255) NOT NULL,
			filing_date varchar(255) NOT NULL,
			cik_number varchar(255) NOT NULL,
			sic_number varchar(255) NOT NULL,
			exhibit_type varchar(255) NOT NULL,
			exhibit_url varchar(255) NOT NULL,
			html_data LONGTEXT DEFAULT NULL,
			PRIMARY KEY (id),
			UNIQUE KEY exhibit_url_unique (exhibit_url)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
}

add_action( 'sec_scraper_every_min_event', 'sec_scraper_every_min' );
function sec_scraper_every_min(){
	get_exhibit_html();
}
function get_exhibit_html($cik_number = false){
	global $wpdb;
	$table_name = $wpdb->prefix . 'exhibits';
	if($cik_number){
		$exhibits = $wpdb->get_results("SELECT * FROM $table_name where cik_number='".$cik_number."'", ARRAY_A);
	}else{
		$exhibits = $wpdb->get_results("SELECT * FROM $table_name where html_data = '' or html_data IS NULL LIMIT 100", ARRAY_A);
	}
	foreach($exhibits as $key => $doc){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $doc['exhibit_url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "MRN Capital info@mrncapital.com");
		$data_string = curl_exec($ch);
		curl_close($ch);
		
		//$doc['html_data'] = str_replace("\n", " ", $data_string);
		$doc['html_data'] = $data_string;
		$start = stripos($doc['html_data'], '<body');
		$duplicate_body = strripos($doc['html_data'], '<body');
		$end = stripos($doc['html_data'], '</body>');

		if ($start !== false && $end !== false) {
			$body_content = str_ireplace('<body', '<div', substr($doc['html_data'], $start, $end - $start) ) . '</div>';

			$doc['html_data'] = $body_content;
		}elseif($start !== $duplicate_body){
			$body_content = str_ireplace('<body', '<div', substr($doc['html_data'], $start, $duplicate_body - $start) ) . '</div>';

			$doc['html_data'] = $body_content;
		}
		//$doc['html_data'] = cleanTip($data_string);
		$doc['scrapedData'] = getInfoFromExhibit($data_string);

		set_exhibits_to_db([$key => $doc]);
	}
}

function adhoc_scrape($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "MRN Capital info@mrncapital.com");
	$html = curl_exec($ch);
	curl_close($ch);
	$dom = new DOMDocument;
	libxml_use_internal_errors(true);
	$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);

	
	$positives = explode("\r\n", get_option('sec_scraper_positives'));
	$negatives = explode("\r\n", get_option('sec_scraper_negatives'));

	$positives = array_map('trim', $positives);
	$negatives = array_map('trim', $negatives);
	
	$positives = array_map('preg_quote', $positives);
	$negatives = array_map('preg_quote', $negatives);

	$positive_pattern = implode('|', $positives);
	$negative_pattern = implode('|', $negatives);
	
	
	$companySpans = $xpath->query('//span[@class="companyName"]');

	// Extract the company name and CIK
	foreach ($companySpans as $span) {
		// The company name is the node value of the span, before the first newline character
		$company_name = trim(substr($span->nodeValue, 0, strpos($span->nodeValue, "\n")));

		// The CIK is the node value of the first 'a' element within the span
		$cik_number = str_replace(' (see all company filings)', '' , trim($xpath->query('.//a', $span)->item(0)->nodeValue));
	}
	
	$identInfoParagraphs = $xpath->query('//p[@class="identInfo"]');
	// Extract the SIC
	foreach ($identInfoParagraphs as $p) {
		// The SIC is the node value of the first 'a' element within the p that contains the text "SIC"
		$sicElements = $xpath->query('//acronym[@title="Standard Industrial Code"]/following-sibling::b', $p);

		if ($sicElements->length > 0) {
			$sic_number = trim($sicElements->item(0)->nodeValue);
		}
	}
	
	$infoDivs = $xpath->query('//div[@class="info"]');
	$filing_date = trim($infoDivs->item(0)->nodeValue);
	
	$formNameDivs = $xpath->query('//div[@id="formName"]');
	// Extract the value of the strong element
	foreach ($formNameDivs as $div) {
		// The value is the node value of the first 'strong' element within the div
		$strongElements = $xpath->query('.//strong', $div);

		if ($strongElements->length > 0) {
			$form_type = str_replace('Form ', '', trim($strongElements->item(0)->nodeValue));
		}
	}
	
	
	// Query the DOM to find the table with the class "tableFile"
	$tables = $xpath->query('//table[@class="tableFile"]');
	$data = [];
	foreach ($tables as $table) {
		$rows = $table->getElementsByTagName('tr');
		$headers = [];
		foreach ($rows->item(0)->getElementsByTagName('th') as $header) {
			$headers[] = $header->nodeValue;
		}
		for ($i = 1; $i < $rows->length; $i++) {
			$row = $rows->item($i);
			$cells = $row->getElementsByTagName('td');
			$rowData = [];
			for ($j = 0; $j < $cells->length; $j++) {
				if('Document' == $headers[$j]){
					$rowData['exhibit_url'] = 'https://www.sec.gov'.$cells->item($j)->getElementsByTagName('a')->item(0)->getAttribute('href');
				}
				$rowData[$headers[$j]] = $cells->item($j)->nodeValue;
			}
			if (!preg_match('/\b('.$positive_pattern.')\b/i', $rowData['Type']) || preg_match('/\b('.$negative_pattern.')\b/i', $rowData['Type']) || $rowData['Size'] > 1200000 || $rowData['Size'] < 5000) {
				continue;
			}
			$data[] = array_merge(compact('cik_number', 'sic_number', 'company_name', 'form_type', 'filing_date'), ['exhibit_type' => $rowData['Type'], 'exhibit_url' => $rowData['exhibit_url']]);
		}
	}
	
	return $data;
}

							
add_filter( 'cron_schedules', function ( $schedules ) {
   $schedules['per_minute'] = array(
       'interval' => 60,
       'display' => __( 'One Minute' )
   );
   return $schedules;
} );
// Hook into activation to create custom table
register_activation_hook(__FILE__, 'sec_scraper_plugin_activation');
register_deactivation_hook(__FILE__, 'sec_scraper_plugin_deactivation');


function scrape_url($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "MRN Capital info@mrncapital.com");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$data_string = curl_exec($ch);
	curl_close($ch);
	
	$positives = explode("\r\n", get_option('sec_scraper_positives'));
	$negatives = explode("\r\n", get_option('sec_scraper_negatives'));

	$positives = array_map('trim', $positives);
	$negatives = array_map('trim', $negatives);
	
	$positives = array_map('preg_quote', $positives);
	$negatives = array_map('preg_quote', $negatives);

	$positive_pattern = implode('|', $positives);
	$negative_pattern = implode('|', $negatives);

	$xml = simplexml_load_string($data_string) or die("Error: Cannot create object");
	// Loop through the XML data
	$exhibit_data = [];
	foreach ($xml->channel->item as $item) {
	   
		$edgar = $item->children('edgar', true);
		$xbrlFiling = $edgar->xbrlFiling;
		$companyName = (string)$xbrlFiling->children('edgar', true)->companyName;
		$formType = (string)$xbrlFiling->children('edgar', true)->formType;
		
		$filingDate = date('Y-m-d', strtotime((string)$xbrlFiling->children('edgar', true)->filingDate));
		$cikNumber = (string)$xbrlFiling->children('edgar', true)->cikNumber;
		$assignedSic = (string)$xbrlFiling->children('edgar', true)->assignedSic;
		$exhibits = array();
		$xbrlFiles = $xbrlFiling->xbrlFiles;
		if ($xbrlFiles) {
			foreach ($xbrlFiles->xbrlFile as $xbrlFile) {
				$description = $xbrlFile->attributes('edgar', true)['description'];
				$type = $xbrlFile->attributes('edgar', true)['type'];
				//if (stripos($description, 'Exhibit') !== false || stripos($description, 'Ex-') !== false || stripos($description, 'EX-101') !== true) {
					if (preg_match('/\b('.$positive_pattern.')\b/i', $type) && !preg_match('/\b('.$negative_pattern.')\b/i', $type)) {
					// Do something if description contains "Exhibit" or "Ex-" and does not contain "EX-101", "SCH", ".jpg", ".xsd", or ".xml"


					$exhibit_url = (string)$xbrlFile->attributes('edgar', true)['url'];
					$exhibit = (string)$xbrlFile->attributes('edgar', true)['description'];
					$exhibit_type = (string)$xbrlFile->attributes('edgar', true)['type'];
					$exhibit_size = intval((string)$xbrlFile->attributes('edgar', true)['size']);
						if($exhibit_size > 300000 || $exhibit_size < 10000){
							continue;
						}
					$exhibit_data[] = array(
						'company_name' => $companyName,
						'form_type' => $formType,
						'filing_date' => $filingDate,
						'cik_number' => $cikNumber,
						'sic_number' => $assignedSic,
						'exhibit_type' => $exhibit_type,
						'exhibit_url' => $exhibit_url
					);
					if(count($exhibit_data) == 750){
						break 2;
					}
					//$sql = "INSERT INTO items (companyName, formType, filingDate, cikNumber, exhibits, exhibit_url) VALUES ('{$exhibit_data['company_name']}', '{$exhibit_data['form_type']}', '{$exhibit_data['filing_date']}', '{$exhibit_data['cik_number']}', '{$exhibit_data['exhibits']}', '{$exhibit_data['exhibit_url']}')";
					//$result = mysqli_query($conn, $sql);
				}
			}
		}
	}
	return $exhibit_data;
}

function get_latest_xml_url(){
	
	$url = 'https://www.sec.gov/Archives/edgar/monthly/';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "MRN Capital info@mrncapital.com");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$html = curl_exec($ch);
	curl_close($ch);

	$doc = new DOMDocument();
	@$doc->loadHTML($html);
	$links = $doc->getElementsByTagName('a');
	// Loop through all the links on the page
	foreach ($links as $link) {
		$href = $link->getAttribute('href');
		// Check if the link points to an XML file
		// Check if the link starts with xmlbrs- and ends with .xml
if (preg_match('/^xbrlrss-.*\.xml$/i', $href)) {
			$lastXMLLink = $href; // Store the last XML link found
		}
	}
	return $url.$lastXMLLink;
}