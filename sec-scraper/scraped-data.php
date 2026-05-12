<?php
function set_exhibits_to_db($data) {
	global $wpdb;
    $table_name = $wpdb->prefix . 'exhibits';
	foreach($data as $doc){
		$wpdb->query(
			$wpdb->prepare(
				"
				INSERT INTO $table_name
				(company_name, form_type, filing_date, cik_number, sic_number, exhibit_type, exhibit_url, html_data)
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
				ON DUPLICATE KEY UPDATE
				company_name = (%s),
				form_type = (%s),
				filing_date = (%s),
				cik_number = (%s),
				sic_number = (%s),
				exhibit_type = (%s),
				html_data = (%s)
				",
				$doc['company_name'],
				$doc['form_type'],
				$doc['filing_date'],
				$doc['cik_number'],
				$doc['sic_number'],
				$doc['exhibit_type'],
				$doc['exhibit_url'],
				$doc['html_data'] ?? '',
				$doc['company_name'],
				$doc['form_type'],
				$doc['filing_date'],
				$doc['cik_number'],
				$doc['sic_number'],
				$doc['exhibit_type'],
				$doc['html_data'] ?? ''
			)
		);
	}
}
function delete_all_exhibits_from_db() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'exhibits';
	$wpdb->get_results("DELETE FROM $table_name", ARRAY_A);
}
function get_exhibits_from_db() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'exhibits';
	return $exhibits = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
}


function scraped_data_page_contents() {
	?>
	
	
		<style>
.dataTables_wrapper .dataTables_length select {width: 50px;}
.dataTables_wrapper .dataTables_filter input {width: 500px; margin-bottom: 20px;}
</style>
		<h2>
			<?php esc_html_e( 'SEC Scraped Data', 'my-plugin-textdomain' ); ?>  - Rescrape Twice A Week
		</h2>
		<p><a href="https://realdealdocs.com/wp-admin/admin.php?page=sec-scraper-settings">Rescrape Filings or Enter Unique Filing URL Here</a><br/>
		<a href="#tips">Tips & Tricks</a><br/>
		<a target="blank" href="https://www.sec.gov/edgar/search/">Full Edgar Text Search</a> to find filing urls<br/>
		<a target="blank" href="https://realdealdocs.com/wp-admin/edit-tags.php?taxonomy=agreements&post_type=doc&orderby=count&order=asc">Empty Categories That Need Docs</a></p>
	<?php
	//delete_transient('sec-data');
	$data = get_exhibits_from_db();
	
	if(isset($_POST['import'])){
		
		$agreement_types = get_terms(array(
			'taxonomy'  => 'agreements',
			'hide_empty'=> false,
			'fields' 	=> 'id=>name'
		));
		foreach($data as $key => $doc){
			$doc['scrapedData'] = getInfoFromExhibit($doc['html_data']);
			if(in_array($doc['exhibit_url'], $_POST['id'])){
				$post_id = 0; // Initialize post ID variable

				// Check if post with meta value exists
				$existing_post = get_posts(array(
					'meta_key' => 'exhibit_url',
					'meta_value' => $doc['exhibit_url'],
					'post_type' => 'doc',
					'post_status' => 'any',
					'numberposts' => 1
				));

				$post_data = array(
					'post_title' => $doc['scrapedData']['info_captured_title'],
					'post_content' => str_replace("\n", " ", $doc['html_data']),
					'post_date' => $doc['filing_date'],
					'post_type' => 'doc',
					'post_status' => 'publish'
				);
				
				if (!empty($existing_post)) {
					// If post exists, update it
					$post_id = $existing_post[0]->ID;
					$post_data['ID'] = $post_id;
					$post_data['post_name'] = sanitize_title($post_data['post_title']).'-'.$post_id;
					wp_update_post($post_data);
				} else {
					$post_data['post_status'] = 'private';
					$post_id = wp_insert_post($post_data);
					wp_update_post(['ID' => $post_id, 'post_name' => sanitize_title($post_data['post_title']).'-'.$post_id]);
				}
				
				if ($post_id) {
					// Add meta value to the new post
					add_post_meta($post_id, 'exhibit_url', $doc['exhibit_url'], true);
					
					$parties = explode(',', $doc['scrapedData']['deal_parties']);
					$terms = [];
					foreach($parties as $party){
						$term_data = array(
							'name' => $party,
							'slug' => sanitize_title($party),
							'description' => '',
							'taxonomy' => 'parties'
						);
						
						$term = get_term_by('name', $term_data['name'], $term_data['taxonomy']);
						if($term){
							$terms[] = $term->term_id;
							continue;
						}
							
						$term = wp_insert_term($term_data['name'], $term_data['taxonomy'], $term_data);
						if (!is_wp_error($term)) {
							$terms[] = $term['term_id'];
						}
					}
					if(count($terms)){
						wp_set_post_terms($post_id, $terms, 'parties');
					}
					
					if($doc['scrapedData']['law_firm_attorney']){
						$attornies = explode(',', $doc['scrapedData']['law_firm_attorney']);
						$terms = [];
						foreach($attornies as $attorney){
							$term_data = array(
								'name' => $attorney,
								'slug' => sanitize_title($attorney),
								'description' => '',
								'taxonomy' => 'firm'
							);
							$term = get_term_by('name', $term_data['name'], $term_data['taxonomy']);
							if($term){
								$terms[] = $term->term_id;
								continue;
							}
							
							$term = wp_insert_term($term_data['name'], $term_data['taxonomy'], $term_data);
							if (!is_wp_error($term)) {
								$terms[] = $term['term_id'];
							}
						}
						if(count($terms)){
							wp_set_post_terms($post_id, $terms, 'firm');
						}
					}
					
					if($doc['sic_number']){
						$states = explode(',', $doc['sic_number']);
						$terms = [];
						foreach($states as $state){
							$term_data = array(
								'name' => $state,
								'slug' => sanitize_title($state),
								'description' => '',
								'taxonomy' => 'sic'
							);
							$term = get_term_by('name', $term_data['name'], $term_data['taxonomy']);
							if($term){
								$terms[] = $term->term_id;
								continue;
							}
							
							$term = wp_insert_term($term_data['name'], $term_data['taxonomy'], $term_data);
							if (!is_wp_error($term)) {
								$terms[] = $term['term_id'];
							}
						}
						if(count($terms)){
							wp_set_post_terms($post_id, $terms, 'sic');
						}
					}
					
					if($doc['cik_number']){
						$states = explode(',', $doc['cik_number']);
						$terms = [];
						foreach($states as $state){
							$term_data = array(
								'name' => $state,
								'slug' => sanitize_title($state),
								'description' => '',
								'taxonomy' => 'cik'
							);
							$term = get_term_by('name', $term_data['name'], $term_data['taxonomy']);
							if($term){
								$terms[] = $term->term_id;
								continue;
							}
							
							$term = wp_insert_term($term_data['name'], $term_data['taxonomy'], $term_data);
							if (!is_wp_error($term)) {
								$terms[] = $term['term_id'];
							}
						}
						if(count($terms)){
							wp_set_post_terms($post_id, $terms, 'cik');
						}
					}
					
					if($doc['scrapedData']['governing_law']){
						$states = explode(',', $doc['scrapedData']['governing_law']);
						$terms = [];
						foreach($states as $state){
							$term_data = array(
								'name' => $state,
								'slug' => sanitize_title($state),
								'description' => '',
								'taxonomy' => 'state'
							);
							$term = get_term_by('name', $term_data['name'], $term_data['taxonomy']);
							if($term){
								$terms[] = $term->term_id;
								continue;
							}
							
							$term = wp_insert_term($term_data['name'], $term_data['taxonomy'], $term_data);
							if (!is_wp_error($term)) {
								$terms[] = $term['term_id'];
							}
						}
						if(count($terms)){
							wp_set_post_terms($post_id, $terms, 'state');
						}
					}
					
					$cats = [];
					foreach($agreement_types as $id => $agreement_type){
						if (substr_count($doc['html_data'], $agreement_type) >= 3) {
							 $cats[] = $id;
						}
					}
					
					if(count($cats) == 0){
						$cats = array_keys(array_filter($agreement_types, function($type) use($doc){return stripos($doc['scrapedData']['info_captured_title'], $type);}));
					}
					if(count($cats)){
						wp_set_post_terms($post_id, $cats, 'agreements');
					}
				}
			}
		}
		die('Import Completed');
	}
	if($data){
		echo '<style>span.warning {display: inline-block;font-size: 10px;background: #a73535;color: white;padding: 5px;margin-top: 10px;border-radius: 3px;}</style>';
		echo '<table id="myTable" class="wp-list-table widefat striped table-view-list pages"><thead>';
		echo '<tr>';
			echo '<th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>';
			echo '<th>Company Name</th>';
			echo '<th>Form Type</th>';
			echo '<th>Filing Date</th>';
			echo '<th>CIK Number</th>';
			echo '<th>SIC Number</th>';
			echo '<th>Exhibits Type</th>';
			echo '<th>Exhibit URL</th>';
			echo '<th>Governing Law</th>';
			echo '<th>Law Firm(s)</th>';
			echo '<th>Parties</th>';
			echo '<th>Captured Title</th>';
			echo '<th>Category</th>';
		echo '</tr></thead>';
		
		$agreement_types = get_terms(array(
			'taxonomy'  => 'agreements',
			'hide_empty'=> false,
			'fields' 	=> 'id=>name'
		));
		$data = !is_array($data) ? json_decode($data , TRUE) : $data;
		foreach($data as $key => $doc){
			if(!$doc['html_data']){
			//if(true){
			}else{
				//echo $doc['exhibit_url'];
				$doc['scrapedData'] = getInfoFromExhibit($doc['html_data']);
				$doc['scrapedData']['category'] = '';
			}
			$doc['maybe_images_only'] = false;
			if(strpos($doc['html_data'], 'title="slide1"') !== FALSE){
				$doc['maybe_images_only'] = true;
			}
			$doc['scrapedData']['category'] = '-';
			$cats = [];
			foreach($agreement_types as $id => $agreement_type){
				if (substr_count($doc['html_data'], $agreement_type) >= 3) {
					 $cats[] = $agreement_type;
				}
			}
			if(count($cats) == 0){
				//$cats = array_filter($agreement_types, function($type) use($doc){return stripos($doc['scrapedData']['info_captured_title'], $type);});
				//dan change to fix  Undefined index: info_captured_title
				$cats = array_filter($agreement_types, function($type) use($doc){return stripos($doc['scrapedData']['info_captured_title'] ?? '', $type);
            });
			}
			$doc['scrapedData']['category'] = implode(", ", $cats);
			
			
			echo '<tr>';
				echo '<td>'.$doc['exhibit_url'].'</td>';
				echo '<td>'.$doc['company_name'].($doc['maybe_images_only'] ? ' <span class="warning">Check For Photos</span>' : '').'</td>';
				echo '<td>'.$doc['form_type'].'</td>';
				echo '<td>'.$doc['filing_date'].'</td>';
				echo '<td>'.$doc['cik_number'].'</td>';
				echo '<td>'.$doc['sic_number'].'</td>';
				echo '<td>'.$doc['exhibit_type'].'</td>';
				echo '<td>'.$doc['exhibit_url'].'</td>';
				//echo '<td>'.$doc['scrapedData']['governing_law'].'</td>';
				//echo '<td>'.$doc['scrapedData']['law_firm_attorney'].'</td>';
				//echo '<td>'.$doc['scrapedData']['deal_parties'].'</td>';
				//echo '<td>'.$doc['scrapedData']['info_captured_title'].'</td>';
				//echo '<td>'.$doc['scrapedData']['category'].'</td>';
				//dan change to fix  Undefined index: 
					   
					   echo '<td>'.($doc['scrapedData']['governing_law'] ?? '').'</td>';
                echo '<td>'.($doc['scrapedData']['law_firm_attorney'] ?? '').'</td>';
                echo '<td>'.($doc['scrapedData']['deal_parties'] ?? '').'</td>';
                echo '<td>'.($doc['scrapedData']['info_captured_title'] ?? '').'</td>';
                echo '<td>'.($doc['scrapedData']['category'] ?? '-').'</td>';

				//echo '<td><pre>'. print_r(array_intersect_key( $doc['scrapedData'], array_flip(['governing_law', 'law_firm_attorney', 'deal_parties', 'info_captured_title',  'category'])), true).'</pre></td>';
				//echo '<td><pre>'. print_r(array_filter($doc['scrapedData'], function($item) use ($lookfor){return in_array($item, $lookfor);}), true).'</pre></td>';
			echo '</tr>';
		}
		echo "</table>";
		?>
		<form id="frm-example" method="POST">
			<button name="import" value="1" class="button">Import</button>
		</form>
		<br><br>
		<div id="tips">
		
		<h3>Scraper Tips</h3>
		
		<p>Use upper right Search Box to quickly find specific types of Agreements<br>
		Make sure you OPEN each SEC url to look at document before importing.  Make note if title doesn't match and needs to be edited<br>
		Checked Documents do not carry over to "next page".  You must import from one page at a time.<br>
		Look for unique agreement types that don't have many results in <a href="https://realdealdocs.com/wp-admin/edit-tags.php?taxonomy=agreements&post_type=doc&orderby=count&order=asc">Agreements category</a><br>
		Titles are often not complete and need to be edited.<br/>
		Categories don't always match up.<br/>
		Use <a target="blank" href="https://www.sec.gov/edgar/search/">Full Text Edgar search</a> to find specific documents<br/>
		We'll continue to improve this system, so make note of any ideas for improvement/filters</p>
		
		<h4>Example Types</h4>
		<ul>
		<li>EX-10.1: Material contracts, such as license agreements, employment agreements, or significant contractual arrangements.</li>
<li>EX-4.1: Indentures or other types of debt instruments.</li>
<li>EX-8.1: Opinions of counsel or legal memoranda.</li>
<li>EX-21.1: Subsidiaries' lists or subsidiary information.</li>
<li>EX-23.1: Consent of experts or auditors.</li>
<li>EX-2.1: Plan of acquisition, reorganization, arrangement, merger, or similar document.</li>
<li>EX-3.1: Articles of incorporation or articles of association.</li>
<li>EX-5.1: Opinion regarding legality and validity of securities being registered.</li>
<li>EX-6.1: Articles of incorporation, bylaws, or other corporate governance documents.</li>
<li>EX-7.1: Consent of experts, such as accountants or appraisers.</li>
<li>EX-9.1: Voting trust agreements or powers of attorney.</li>
<li>EX-11.1: Statements regarding computation of per share earnings or ratios.</li>
<li>EX-13.1: Annual or quarterly reports to security holders.</li>
<li>EX-99.1: Miscellaneous exhibit filings, including press releases, investor presentations, or other supplemental information.</li>
<li>EX-12.1: Statement of computation of ratios or other financial data.</li>
<li>EX-15.1: Letter regarding unaudited interim financial information.</li>
<li>EX-18.1: Description of securities to be registered.</li>
<li>EX-24.1: Power of attorney.</li>
<li>EX-25.1: Statement of eligibility under the Trust Indenture Act.</li>
<li>EX-30.1: Foreign private issuer annual report.</li>
<li>EX-31.1: Certification of principal executive officer and principal financial officer.</li>
<li>EX-32.1: Certification of principal executive officer and principal financial officer (Section 1350).</li>
<li>EX-40.1: Financial data schedule.</li>
<li>EX-45.1: Rule 12b-25 notice of late filing.</li>
<li>EX-99.2: Additional miscellaneous exhibit filings, such as material contracts, agreements, or other important documents.</li>
</ul>



		
		</div>
		<script>
			jQuery(document).ready( function () {
				var table = jQuery('#myTable').DataTable({
				select: true,
        lengthMenu: [10, 20, 30, 40, 50, 100], // Custom dropdown options
	 		pageLength: 30, // Set the default page length to 30
		pagingType: 'full_numbers', // Set the paging_type to "full_numbers"
					select: true,
					  'columnDefs': [{
						 'targets': 0,
						 'searchable': false,
						 'orderable': false,
						 'className': 'dt-body-center',
						 'render': function (data, type, full, meta){
							 return '<input type="checkbox" name="id[]" value="' + jQuery('<div/>').text(data).html() + '">';
						 }
					  },{
						 'targets': 7,
						 'searchable': false,
						 'orderable': false,
						 'className': 'dt-body-center',
						 'render': function (data, type, full, meta){
							 return '<a href="'+ jQuery('<div/>').text(data).html() + '" target="_blank">Open</a>';
						 }
					  }]
				});
				<?php if(isset($_GET['cik_number'])) {?>
				table.search('<?php echo $_GET['cik_number'];?>').draw();
				<?php } ?>
			
			   // Handle click on "Select all" control
			   jQuery('#example-select-all').on('click', function(){
				  // Get all rows with search applied
				  var rows = table.rows({ 'search': 'applied' }).nodes();
				  // Check/uncheck checkboxes for all rows in the table
				  jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
			   });

			   // Handle click on checkbox to set state of "Select all" control
			   jQuery('#example tbody').on('change', 'input[type="checkbox"]', function(){
				  // If checkbox is not checked
				  if(!this.checked){
					 var el = jQuery('#example-select-all').get(0);
					 // If "Select all" control is checked and has 'indeterminate' property
					 if(el && el.checked && ('indeterminate' in el)){
						// Set visual state of "Select all" control
						// as 'indeterminate'
						el.indeterminate = true;
					 }
				  }
			   });

			   // Handle form submission event
			   jQuery('#frm-example').on('submit', function(e){
				  var form = this;

				  // Iterate over all checkboxes in the table
				  jQuery('#myTable input[type="checkbox"]').each(function(){
					// If checkbox is checked
					if(this.checked){
					   // Create a hidden element
					   jQuery(form).append(
						  jQuery('<input>')
							 .attr('type', 'hidden')
							 .attr('name', this.name)
							 .val(this.value)
					   );
					 }
				  });
			   });
			});

		</script>
		<script>
    jQuery(document).ready(function() {
      // Initialize DataTable with your options
      jQuery('#myDataTable').DataTable({
        // Add the lengthMenu option to customize dropdown values
        lengthMenu: [10, 20, 30, 40, 50, 100],
      });
    });
  </script>
<?php
}
}
function register_my_plugin_scripts() {
	wp_register_style( 'my-plugin', 'https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css' );
	wp_register_script( 'my-plugin', 'https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js' );
	wp_register_script( 'my-plugin-buttons', 'https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.js' );
}
add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );

function load_my_plugin_scripts( $hook ) {
	// Load only on ?page=sample-page
	//if(isset($_GET['test'])){die($hook);}
	if( $hook != 'toplevel_page_sec-scraper' ) {
		return;
	}

	// Load style & scripts.
	wp_enqueue_style( 'my-plugin' );
	wp_enqueue_script( 'my-plugin' );
}
add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts' );