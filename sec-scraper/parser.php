<?php


$aRegexSearchTerms = array('full' => array(), 'flexible_capture' => array());
$aInCaseSensitiveWords = array('Of', 'To');

/*	REQUIREMENTS TO WRITE FULL SEARCH TERMS ($aSearchTerms['full'])
	- Any first char of a word MUST BE uppercase!
	- Conjunctive first char must be uppercase, ie: And, Of, To
	- Space as separation must be once only (in the final form it will be replaced by "\h+"), ie:
		Advertising Agency Agreement ==> CORRECT
		Advertising Agency            Agreement ==> [INCORRECT]
	- Enclose s character in the end of a word with a question mark (?) if the s existence is not obligated, ie:
		Agreements? ==> both "Agreement" & "Agreements" is accepted.
		Agreement ==> only "Agreement" is accepted.
		Agreements ==> only "Agreements" is accepted.
	- If all chars from a word are UPPERCASE then it means that it's only accept uppercase, ie :
		BYLAWS ==> Only "BYLAWS" is accepted, "Bylaws" and "ByLaws" are not.
	- If - present within a word (without space separation), then, if a char after - is UPPERCASE then it means that it's only accept uppercase, ie :
		By-Laws ==> Anything is accepted as long B and L is in uppercase (so, these case are accepted: By-LaWS, BY-LAwS)
		By-laws ==> Anything is accepted as long B is in uppercase.
		BY-Laws ==> Anything is accepted as long B and L are in uppercase.
		BY-LawS ==> Anything is accepted as long B and L are in uppercase.
	*/
$aSearchTerms['full'] = array('401K Plan'
	, '403b Plan'
	, 'Account Control Agreement'
	, 'Acknowledgment'
	, 'Addendum'
	, 'Advertising Agency Agreement'
	, 'Advertising Agreement'
	, 'Advisory Board Agreement'
	, 'Affiliate Agreement'
	, 'Affirmative Action'
	, 'Agency Agreement'
	, 'Agreement Of Sale'
	, 'Agreements'
	, 'Aircraft Lease Agreement'
	, 'Allonge'
	, 'Amendment'
	, 'Annuity Agreement'
	, 'Appearance Release'
	, 'Arbitration Agreement'
	, 'Articles Of Amendment'
	, 'Articles Of Incorporation'
	, 'Articles Of Merger'
	, 'Articles Of Organization'
	, 'Asset Exchange Agreement'
	, 'Asset Purchase Agreement'
	, 'Assignment Agreement'
	, 'Assignment And Assumption Agreement'
	, 'Assumption Agreement'
	, 'Attornment Agreement'
	, 'Audit Committee Charter'
	, 'Bill Of Sale'
	, 'Billing Services Agreement'
	, 'Blue Sky Memorandum'
	, 'Board Minutes'
	, 'Board Resolutions'
	, 'Board Written Consent'
	, 'Bonds'
	, 'Bonus Plan'
	, 'Bridge Loan Agreement'
	, 'Broker Agreement'
	, 'Bulk Sales Notice'
	, 'Bylaws'
	, 'Cable TV License Agreement'
	, 'Cash Collateral Agreement'
	, 'Cash Management Agreement'
	, 'Certificate'
	, 'Certificate Of Elimination'
	, 'Certificate Of Formation'
	, 'Certificate Of Incorporation'
	, 'Certificate Of Limited Partnership'
	, 'Certificate Of LLC Formation'
	, 'Certificate Of LLP'
	, 'Certificate Of Merger'
	, 'Certificate Of Ownership'
	, 'Certificate Of Stock Designation'
	, 'Certification Of Bylaws'
	, 'Change Of Control Agreement'
	, 'Clinical Trial Agreement'
	, 'Closing Agreement'
	, 'Co-Branding Agreement'
	, 'Co-Sale Agreement'
	, 'Co-Tenancy Agreement'
	, 'Code Of Business Integrity'
	, 'Code Of Ethics'
	, 'Collaboration Agreement'
	, 'Collateral Agency Agreement'
	, 'Collective Bargaining Agreement'
	, 'Collective Bargaining Proposal'
	, 'Commercial Loans'
	, 'Completion Guarantee'
	, 'Concert Release'
	, 'Concession Agreement'
	, 'Condominiums'
	, 'Confidentiality Agreement'
	, 'Consent'
	, 'Consent To Collateral Assignment'
	, 'Consolidated Balance Sheet'
	, 'Construction Agency Agreement'
	, 'Construction Agreement'
	, 'Construction Loan Agreement'
	, 'Consulting Agreement'
	, 'Content License Agreement'
	, 'Contribution Agreement'
	, 'Convertible Promissory Note'
	, 'Cooperation Agreement'
	, 'Copyright License Agreement'
	, 'Corporate - Corporations'
	, 'Crude Purchase Agreement'
	, 'Crude Transportation Agreement'
	, 'Dealer Manager Agreement'
	, 'Debenture'
	, 'Declaration Of Trust'
	, 'Deed'
	, 'Deed Of Trust'
	, 'Deferred Unit Award Agreement'
	, 'Design Contract'
	, 'Development Agreement'
	, 'Disability'
	, 'Disbursement Agreement'
	, 'Disclosure Statement'
	, 'Dissolution Issues'
	, 'Distribution Agreement'
	, 'Domain Name Transfer Agreement'
	, 'Domestic Partners'
	, 'Due Diligence'
	, 'Easement Agreement'
	, 'Election Form'
	, 'Employee Benefits Agreement'
	, 'Employee Benefits Plan'
	, 'Employee Immigration'
	, 'Employee Offer Letter'
	, 'Employee Privacy'
	, 'Employee Retention Agreement'
	, 'Employee Secondment Agreement'
	, 'Employment Agreement'
	, 'Employment Agreement Amendment'
	, 'Employment Application'
	, 'End User License Agreement'
	, 'Endorsement Agreement'
	, 'Engagement Agreement'
	, 'Engineering, Procurement And Construction Agreement'
	, 'Engineering, Procurement And Construction Contract'
	, 'Environmental Indemnity Agreement'
	, 'Equipment Lease Agreement'
	, 'Equity Contribution Agreement'
	, 'Equity Incentive Agreement'
	, 'Equity Incentive Plan'
	, 'Escrow Agreements'
	, 'Exclusivity Agreement'
	, 'Executive Compensation Agreement'
	, 'Executive Compensation Plan'
	, 'Executive Employment Agreement'
	, 'Executive Management Agreement'
	, 'Executive Severance'
	, 'Extension Agreement'
	, 'Facility Services Agreement'
	, 'Fee Agreement'
	, 'Feed Stock Agreement'
	, 'Financial Services Agreement'
	, 'Fixture Filing'
	, 'Forbearance Agreement'
	, 'Form S-1'
	, 'Form S-3'
	, 'Form S-4'
	, 'Franchise Agreement'
	, 'Fuel Supply Agreement'
	, 'Fund Manager Agreement'
	, 'Gas Marketing Agreement'
	, 'Gas Processing Agreement'
	, 'Gas Purchase Agreement'
	, 'Gas Storage Agreement'
	, 'Gas Supply Agreement'
	, 'Gas Transportation Agreement'
	, 'General Partnership Agreement'
	, 'Grant Deed'
	, 'Grant Notice'
	, 'Ground Lease Agreement'
	, 'Guarantee'
	, 'Guaranty Of Lease'
	, 'Health Care'
	, 'Hedge Agreement'
	, 'Holdback Agreement'
	, 'Host Government Agreement'
	, 'Hosting Agreement'
	, 'House Lease Agreement'
	, 'Important Notice'
	, 'Indemnification Agreement'
	, 'Indenture'
	, 'Independent Accountants\' Report'
	, 'Independent Contractor Agreement'
	, 'Information Statement'
	, 'Initial Public Offering'
	, 'Insurance'
	, 'Insurance Agreement'
	, 'Insurance Underwriting Agreement'
	, 'Intellectual Property'
	, 'Intellectual Property Agreement'
	, 'Intellectual Property License Agreement'
	, 'Intellectual Property Security Agreement'
	, 'Interconnection Agreement'
	, 'Intercreditor Agreement'
	, 'Invention Assignment Agreement'
	, 'Investment Management Trust Agreement'
	, 'Investor Questionaire'
	, 'Investor Representations'
	, 'Investor Rights Agreement'
	, 'Investor Suitability Questionnaire'
	, 'Investors Rights Agreement'
	, 'IP License/Assignment Agreement'
	, 'Irrevocable Trust Agreement'
	, 'Joint Bid Agreement'
	, 'Joint Defense Agmt'
	, 'Joint Venture Agreement'
	, 'Lease Addendum'
	, 'Lease Agreement'
	, 'Lease Agreement Exhibit'
	, 'Lease Amendment'
	, 'Lease Assignment'
	, 'Lease Assumption Agreement'
	, 'Lease Guaranty'
	, 'Lease Subordination Agreement'
	, 'Lease Termination Agmt'
	, 'Lease/Sublease Consent'
	, 'Leaseback'
	, 'Leaseback Agreement'
	, 'Leave Of Absence'
	, 'Legal Opinions'
	, 'Letter Agreement'
	, 'Letter Of Credit'
	, 'Letter Of Intent'
	, 'Letter Of Transmittal'
	, 'License Agreement'
	, 'Life Insurance'
	, 'Limited Liability Company Agreement'
	, 'Limited Liability Partnership Agreement'
	, 'Limited Partnership Agreement'
	, 'Liquidation Agreement'
	, 'Listing Agreement'
	, 'Litigation Cooperation Agreement'
	, 'Loan Agreement'
	, 'Loan Agreement Amendment'
	, 'Location Agreement'
	, 'Location Release And Consent'
	, 'Lockbox Agreement'
	, 'Management Rights Agreement'
	, 'Management Services Agreement'
	, 'Management Shareholder Agreement'
	, 'Manufacturing Agreement'
	, 'Marketing Agreement'
	, 'Master Use Agreement'
	, 'Material Agreement'
	, 'Mediation Agreement'
	, 'Membership Agreement'
	, 'Membership Interest Pledge Agreement'
	, 'Mezzanine Loan Agreement'
	, 'Modifications'
	, 'Mortgage'
	, 'Mortgage Loan Purchase Agreement'
	, 'Mortgage Note'
	, 'Movie Production Agreement'
	, 'Music License Agreement'
	, 'Music Publishing Agreement'
	, 'Net Profits Interest Agreement'
	, 'Non-Competition Agreement'
	, 'Non-Disclosure Agreement'
	, 'Non-Discrimination'
	, 'Non-Disparagement Agreement'
	, 'Non-Disturbance Agreement'
	, 'Non-Solicitation Agreement'
	, 'Notary Acknowledgment'
	, 'Note Purchase Agreement'
	, 'Notice'
	, 'Notice Of Annual Meeting'
	, 'Notice Of Annual Shareholder Meeting'
	, 'Notification And Release Agreement'
	, 'Novation Agreement'
	, 'Officers\' Certificate'
	, 'Oil Marketing Agreement'
	, 'Oil Processing Agreement'
	, 'Oil Purchase/Sale Agreement'
	, 'Oil Storage Agreement'
	, 'Oil Supply Agreement'
	, 'Oil Transportation Agreement'
	, 'Omnibus Agreement'
	, 'Operating Agreement'
	, 'Operational Balancing Agreement'
	, 'Operations And Maintenance Agreement'
	, 'Option Agreement'
	, 'Option Purchase Agreement'
	, 'Outsourcing Agreement'
	, 'Participation Agreement'
	, 'Partnership Dissolution Agreement'
	, 'Partnership Interest Pledge Agreement'
	, 'Partnership Subscription Agreement'
	, 'Patent Application'
	, 'Patent Assignment Agreement'
	, 'Patent License Agreement'
	, 'Peaceful Possession Agreement'
	, 'Performance Unit Award Agreement'
	, 'Personal Guarantee'
	, 'Petrochem Processing Agreement'
	, 'Physician Services Agreement'
	, 'Placement Agent Agreement'
	, 'Plan Of Liquidation'
	, 'Plan Of Merger'
	, 'Plan Termination'
	, 'Plan Trust Agreement'
	, 'Pooling Agreement'
	, 'Pooling And Servicing Agreement'
	, 'Power Agreement'
	, 'Power Of Attorney'
	, 'Power Purchase Agreement'
	, 'Preemptive Rights Agreement'
	, 'Press Release'
	, 'Pricing Agreement'
	, 'Private Shelf Agreement'
	, 'Product Placement Agreement'
	, 'Production Agreement'
	, 'Production Sharing Agreement'
	, 'Profit Sharing Plan'
	, 'Project Labor Agreement'
	, 'Promissory Note'
	, 'Promotion Agreement'
	, 'Proprietorship Agreement'
	, 'Provisional Patent Application'
	, 'Proxy Agreement'
	, 'Proxy Statement'
	, 'Purchase And Distribution Agreement'
	, 'Purchase And Sale Agreement'
	, 'Put Option Agreement'
	, 'Questionnaire'
	, 'Quit Claim Deed'
	, 'Recapitalization Agreement'
	, 'Receivables Purchase Agreement'
	, 'Receivables Sale Agreement'
	, 'Redemption Agreement'
	, 'Registration Rights Agreement'
	, 'Reimbursement Agreement'
	, 'Reinsurance Agreement'
	, 'Release Agreement'
	, 'Research Agreement'
	, 'Research And Development Agreement'
	, 'Restated Certificate Of Incorporation'
	, 'Restated Articles Of Incorporation'
	, 'Restricted Share Agreement'
	, 'Restricted Stock Units Agreement'
	, 'Retailer Agreement'
	, 'Retirement Agreement'
	, 'Retirement Plan'
	, 'Retirement Savings Plan'
	, 'Revocable Trust Agmt'
	, 'Revolving Credit Agreement'
	, 'Right Of First Refusal'
	, 'Royalty Agreement'
	, 'Sale And Servicing Agreement'
	, 'Sales Agency Agreement'
	, 'Sales Agreement'
	, 'Sales Contract'
	, 'Sarbanes-Oxley'
	, 'Second Lien Security'
	, 'Services Agreement'
	, 'Severance Agreement'
	, 'Share Exchange Agreement'
	, 'Shopping Center Lease'
	, 'Software Agreement'
	, 'Software License'
	, 'Software Maintenance Agreement'
	, 'Standstill Agreement'
	, 'Stock Conversion Agreement'
	, 'Stock Exchange Agreement'
	, 'Stock Option Certificate'
	, 'Stock Purchase Agreement'
	, 'Sublease Agreement'
	, 'Sublease Contract'
	, 'Subscription Agreement'
	, 'Supply Agreement'
	, 'Technical Services Agreement'
	, 'Toling And Standstill Agreement'
	, 'Tolling Agreement'
	, 'Trademark License Agreement'
	, 'Triple Net Lease Agreement'
	, 'Voting Agreement'
	, 'Warehouse Lease Agreement'
	, 'Warrant Certificate'
);


/*	REQUIREMENTS TO WRITE FLEXIBLE SEARCH TERMS ($aSearchTerms['flexible_capture_regex'])
	- Any regex pattern can be applied!!! Make sure to slash certain meta characters.
	- Try to separate the OR (|) if contain more than one word, ie:
		Subsidiar(?: y | ies ) ==> Such this is fine, since the alternative chars are part on the word.

		(?: FACILITY | PROMISSORY) NOTES? ==> Should NOT apply this! Separate it instead, as below :
		FACILITY NOTES?
		PROMISSORY NOTES?
	- Note: Case sensitive is applied except any chars between (?i) and (?-i).
	- Space as separation must be once only (in the final form it will be replaced by "\h+"), ie:
		Advertising Agency Agreement ==> CORRECT
		Advertising Agency            Agreement ==> [INCORRECT]
	*/
$aSearchTerms['flexible_capture_regex'] = array('A(?i)FFIRMATIVE(?-i) A(?i)CTIONS?(?-i)'
	,  'A(?i)CKNOWLEDGMENTS?(?-i)'
			, 'A(?i)CTIONS? OF THE(?-i) A(?i)UTHORIZED(?-i)'
	,  'A(?i)DDENDUMS?(?-i)'
			,  'A(?i)DVISORY(?-i) B(?i)OARDS?(?-i)'
	,  'A(?i)LLONGES?(?-i)'
			,  'A(?i)MENDED AND(?-i) R(?i)ESTATED(?-i)'
	,  'A(?i)MENDMENTS?(?-i)'
			,  'A(?i)NNOUNCEMENTS?(?-i)'
	,  'A(?i)PPLICATIONS?(?-i)'
	,  'A(?i)RTICLES? OF(?-i)'
	,  'A(?i)TTORNEYS?(?-i)'
	,  'A(?i)UDIT(?-i) C(?i)OMMITTEE(?-i) C(?i)HARTER(?-i)'


	,  'B(?i)ILL OF(?-i)'
	,  'B(?i)LUE(?-i) S(?i)KY(?-i) M(?i)EMORANDUM(?-i)'
			,  'B(?i)OARDS?(?-i) C(?i)HARTER(?-i)'
	,  'B(?i)OARDS?(?-i) M(?i)INUTES?(?-i)'
	,  'B(?i)OARDS?(?-i) R(?i)ESOLUTIONS?(?-i)'
	,  'B(?i)OARDS?(?-i) W(?i)RITTEN(?-i)'
	,  'B(?i)ONDS?(?-i)'
	,  'B(?i)Y-?LAWS?(?-i)'


	,  'C(?i)ERTIFICATES?(?-i)'
	,  'C(?i)ERTIFICATIONS?(?-i)'
			,  'C(?i)ERTIFIED(?-i) C(?i)OPY(?-i)'
			, 'C(?i)HARTER OF(?-i)'
	,  'C(?i)ODES?(?-i)'
			, 'C(?i)OMMITTEE(?-i) B(?i)OARDS?(?-i)'
			, 'C(?i)OMPAN(?:Y|IES)(?-i) S(?i)UBSIDIAR(?:Y|IES)(?-i)'
			, 'C(?i)OMPLETE(?-i) C(?i)OMPLIANCE(?-i)'
			, 'C(?i)OMPUTATIONS? OF(?-i) R(?i)ATIOS?(?-i)'
	,  'C(?i)ONDOMINIUMS?(?-i)'
	,  'C(?i)ONSENTS?(?-i)'
			, 'C(?i)ONSOLIDATED(?-i) S(?i)UBSIDIAR(?:Y|IES)(?-i)'
	,  'C(?i)ONTRACTS?(?-i)'
	,  'C(?i)ORPORATES?(?-i)\h*-\h*C(?i)ORPORATIONS?(?-i)'


	,  'D(?i)EBENTURES?(?-i)'
	,  'D(?i)ECLARATIONS?(?-i)'
	,  'D(?i)EED(?-i)'
	,  'D(?i)ISABILITY(?-i)'
	,  'D(?i)ISCRIMINATIONS?(?-i)'
	,  'D(?i)UE(?-i) D(?i)ILIGENCE(?-i)'


			,  'E(?i)ARNINGS? OF(?-i) S(?i)UBSIDIAR(?:Y|IES)(?-i)'
	,  'eC(?i)REDITS?(?-i)'
	,  'E(?i)MPLOYEES?(?-i)'
			, 'E(?i)XECUTION(?-i) C(?i)OPY(?-i)'


			, 'F(?i)ACILITY(?-i) N(?i)OTES?(?-i)'
			,  'F(?i)INANCIAL(?-i) P(?i)LANNINGS?(?-i)'
	,  'F(?i)IXTURES?(?-i)'
	,  'F(?i)ORM(?-i)'


			, 'G(?i)ENERAL(?-i) P(?i)ROVISIONS?(?-i)'
	,  'G(?i)UARANTEES?(?-i)'


	,  'H(?i)EALTH(?-i) C(?i)ARES?(?-i)'


	,  'I(?i)NDENTURES?(?-i)'
	,  'I(?i)NSURANCES?(?-i)'
	,  'I(?i)NTELLECTUALS?(?-i)'
	,  'I(?i)NVESTORS?(?-i) P(?i)RESENTATIONS?(?-i)'
	,  'I(?i)NVESTORS?(?-i) Q(?i)UESTIONAIRE(?-i)'
	,  'I(?i)NVESTORS?(?-i) R(?i)EPRESENTATIONS?(?-i)'
	,  'I(?i)NVESTORS?(?-i) S(?i)UITABILITY(?-i)'
	,  'I(?i)SSUES?(?-i)'


	,  'L(?i)EASE(?-i)'
	,  'L(?i)EASEBACKS?(?-i)'
	,  'L(?i)EAVE(?-i)'
	,  'L(?i)EGALS?(?-i)'
	,  'L(?i)ETTERS? OF(?-i)'
	,  'L(?i)ETTERS? TO(?-i)'
	,  'L(?i)ICENSES?(?-i)'
	,  'L(?i)IENS?(?-i) S(?i)ECURIT(?:Y|IES)(?-i)'
			,  'L(?i)IST OF(?-i) S(?i)UBSIDIAR(?:Y|IES)(?-i)'
	,  'L(?i)OANS?(?-i)'


	,  'M(?i)ODIFICATIONS?(?-i)'
	,  'M(?i)ORTGAGES?(?-i)'


			,  'N(?i)EWS(?-i) R(?i)ELEASE(?-i)'
	,  'N(?i)OTICES?(?-i)'


			,  '(?i)OF(?-i) T(?i)RUST(?-i)'
			,  'O(?i)PINIONS? OF(?-i)'
			,  'O(?i)PTION(?-i) P(?i)LAN(?-i)'


	,  'P(?i)ARTNERS?(?-i)'
			//,  'P(?i)ERSONAL(?-i) F(?i)INANCIAL(?-i) P(?i)LANNINGS?(?-i)'
	,  'P(?i)LAN(?-i)'
	,  'P(?i)RESS(?-i) R(?i)ELEASE(?-i)'
			, 'P(?i)ROMISSORY(?-i) N(?i)OTES?(?-i)'
	,  'P(?i)ROPOSALS?(?-i)'
	,  'P(?i)UBLIC(?-i) O(?i)FFERINGS?(?-i)'


	,  'Q(?i)UESTIONNAIRES?(?-i)'


			, 'R(?i)EGISTRANT(?:\WS)?(?-i) S(?i)UBSIDIARIES(?-i)'
			, 'R(?i)EPORT(?-i) O(?i)f(?-i)'
			, 'R(?i)ETIREMENT(?-i) A(?i)LLOWANCE(?-i)'
			, 'R(?i)EVOLVING(?-i) C(?i)REDIT(?-i) N(?i)OTES?(?-i)'
	,  'R(?i)IGHTS? OF(?-i)'


	,  'S(?i)ARBANES(?-i)-?O(?i)XLEY(?-i)'
	,  'S(?i)ECURIT(?:Y|IES)(?-i) A(?i)GREEMENTS?(?-i)'
	,  'S(?i)ECURIT(Y|IES)(?-i) H(?i)OLDERS?(?-i)'
	,  'S(?i)ECURIT(Y|IES)(?-i) Q(?i)UALIFICATIONS?(?-i)'
			,  'S(?i)ELLER(?-i) N(?i)OTE(?-i)'
			,  'S(?i)ERVICING(?-i) R(?i)EPORT(?-i)'
	,  'S(?i)EVERANCES?(?-i)'
			, 'S(?i)PECIAL(?-i) S(?i)HAREHOLDERS?(?-i) M(?i)EETINGS?(?-i)'
	,  'S(?i)TATEMENTS?(?-i)'
			,  'S(?i)UBSIDIAR(?:Y|IES) OF(?-i)'
);


if (!empty($aSearchTerms['full']))
{
	// Sort by highest word count & alphabet while removing excessive space (if any).
	foreach ($aSearchTerms['full'] as $sVal)
	{
		$sVal = preg_replace('/\s\s+/', ' ', $sVal);	// Prevent double space

		$aWordCounts[] = substr_count($sVal, ' ');

		$sFirstWord = strstr($sVal, ' ', true);
		$aFirstChars[] = ($sFirstWord === false) ? $sVal : $sFirstWord;
	}
	array_multisort($aWordCounts, SORT_DESC, $aFirstChars, SORT_DESC, $aSearchTerms['full']);
	unset($aWordCounts);
	unset($aFirstChars);


	// Convert each search term into regex form.
	foreach ($aSearchTerms['full'] as $sVal)
	{
		$aVal = explode(' ', $sVal);	// Separate each word

		foreach ($aVal as $sVal)	// Process each word
		{
			$sVal = str_replace('/', '\/', quotemeta($sVal));

			if ($sVal == 'And') $aRegex[] = '(?: & | A(?i)nd(?-i) )';	// May contain ampersand symbol (&) intead of "and"
			elseif (in_array($sVal, $aInCaseSensitiveWords)) $aRegex[] = substr($sVal, 0, 1) . '(?i)' . substr($sVal, 1) . '(?-i)';	// Incase sensitive
			elseif ($sVal == '-') $aRegex[] = '\h*-\h*';	// - can be accompanied with horizontal whitespace or none at all
			elseif (false === strpos($sVal, '-'))
			{
				if (strlen($sVal) > 1 && preg_match('/[a-z]/', substr($sVal, 1))) $aRegex[] = substr($sVal, 0, 1) . '(?i)' . substr($sVal, 1) . '(?-i)';
				else $aRegex[] = $sVal;
			}
			else	// - found within a word
			{
				foreach (explode('-', $sVal) as $i => $sChars)
				{
					// Lowercase is present.
					if (preg_match('/[a-z]/', $sChars))
					{
						if ($i)
						{
							// What is the first char?
							$sChars = (preg_match('/^[A-Z]/', $sChars)) ? substr($sChars, 0, 1) . '(?i)' . substr($sChars, 1) . '(?-i)' : '(?i)' . $sChars . '(?-i)';	// Uppercase : NOT uppercase
						}
						elseif (strlen($sChars) > 1) $sChars = substr($sChars, 0, 1) . '(?i)' . substr($sChars, 1) . '(?-i)';
					}

					$aCharRegex[] = $sChars;
				}

				$aRegex[] = implode('-', $aCharRegex);

				unset($aCharRegex);
			}
		}

		$aFullSearchTerms[] = preg_replace(array('/\\\h\+\\\h\*/', '/\\\h\*\\\h\+/'), '\h*', implode('\h+', $aRegex));
		unset($aRegex);
	}

	if (isset($aFullSearchTerms))
	{
		$aRegexSearchTerms['full'] = '\b' . implode('\b|\b', $aFullSearchTerms) . '\b';	// Add word boundary
		unset($aFullSearchTerms);
	}
}


if (!empty($aSearchTerms['flexible_capture_regex']))
{
	// Sort by highest word count & alphabet while removing excessive space (if any).
	foreach ($aSearchTerms['flexible_capture_regex'] as $sVal)
	{
		$sVal = preg_replace('/\s\s+/', ' ', $sVal);	// Prevent double space

		$sVal = str_replace(array('(?i)', '(?-i)', '(?:'), '', $sVal);

		$sVal = str_replace('\h*', ' ', $sVal);

		$aWordCounts[] = substr_count($sVal, ' ') + substr_count($sVal, '\h*');

		$sFirstWord = strstr($sVal, ' ', true);

		$aFirstChars[] = ($sFirstWord === false) ? $sVal : $sFirstWord;
	}
	array_multisort($aWordCounts, SORT_DESC, $aFirstChars, SORT_DESC, $aSearchTerms['flexible_capture_regex']);
	unset($aWordCounts);
	unset($aFirstChars);


	$aRegexSearchTerms['flexible_capture'] = str_replace(' ', '\h+', '\b' . implode('\b|\b', $aSearchTerms['flexible_capture_regex']) . '\b');
}



function getInfoFromExhibit($sCleanExhibitContent, $sDescription = null)
{
	global $aRegexSearchTerms;	// ['full'] & ['flexible_capture']

	$aInfo['category'] = $aInfo['info_captured_title'] = $aInfo['deal_parties'] = $aInfo['law_firm_attorney'] = $aInfo['governing_law'] =  $aInfo['header'] = $aInfo['info_description_tag'] = $aInfo['info_search_term'] = false;

	$aRegexAdjectiveWords = array('and'
		, 'as'
		, 'at'
		, 'of'
		, 'on'
		, 'the'
		, 'to'
	);

	// Get first $iLineLimit rows content & search from this upper part, search from a whole may turn to irrelevan result.
	$iLineLimitForFullSearch = 10;
	$sCleanContent = cleanContent($sCleanExhibitContent);
	foreach (explode("\n", $sCleanContent) as $sLine)
	{
		$aCleanContent[] = $sLine;

		if (strlen(trim($sLine)))
		{
			--$iLineLimitForFullSearch;
			if (!$iLineLimitForFullSearch) break;
		}
	}

	// Prioritize FULL SEARCH first.
	if (defined('FULL_TERM_PATTERN') || !empty($aRegexSearchTerms['full']))
	{
		if (!defined('FULL_TERM_PATTERN'))
		{
			define('FULL_TERM_PATTERN', '/(?: ^ | \n )		# Must be in the beginning or new line
				(?: \h+ )?													# May contain horizontal whitespace

				(?: 															# May be started with Exhibit or its variance
					(?: E(?i)xhibit(?-i)
						| EX
					) \b
					[^\n]+ 													# After exhibit there must be any chars
					(?: \. (?: html? | txt ) )?						# May contain file name
					(?: [^A-Za-z0-9\v]+ )?								# Must not contain any letter nor V whitespace
				)?

				(' . $aRegexSearchTerms['full'] . ')

				(?: [^A-Za-z0-9\v]+ )? [\n$]
			/x');

			$aRegexSearchTerms['full'] = array();	// Empty its value to free up some memory
		}

		if (preg_match(FULL_TERM_PATTERN, implode("\n", $aCleanContent), $aMatch))
		{
			$aInfo['category'] = $aInfo['info_captured_title'] = stripExcessiveSpaces($aMatch[1]);

			$aInfo['info_search_term'] = '[FULL] ' . $aInfo['category'];
		}

		unset($aMatch);
		unset($aCleanContent);
	}


	// Set clean header content for flexible search.
	$iLineLimit = 30;
	foreach (explode("\n", $sCleanContent) as $sLine)
	{
		$aCleanContent[] = $sLine;

		if (strlen(trim($sLine)))
		{
			--$iLineLimit;
			if (!$iLineLimit) break;
		}
	}
	$sCleanHeaderContent = implode("\n", $aCleanContent);
	unset($aCleanContent);


	if (!defined('CAPTURE_PATTERN') && !empty($aRegexSearchTerms['flexible_capture']))
	{
		/*
		$sCapturePatternPrototype = '/(?: ^ | \n )			# Must be in the beginning or new line
			(?: \h+ )?													# May contain horizontal whitespace

			(?: 															# May be started with Exhibit or its variance
				(?: E(?i)xhibit(?-i)
					| EX
				) \b
				[^\n]+ 													# After exhibit there must be any chars
				(?: \. (?: html? | txt ) )?						# May contain file name
				\h+ 														# Must contain H whitespace
			)?

			(
				(?:														# May contain any chars without new line
					(?:
						(?:
							[^a-z\s] (?: [^\s]+ )?
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
						)
						\h+
					)+
				)?

				({CAPTURE_PATTERN})

				(?:														# May contain any chars as long the words first char is not lowercase OR an adjective word
					(?: \h+ | \n{1,2} (?:\h+)? )
					(?:
						(?:
							[^a-z\s]  (?:[^A-Za-z0-9\s]+)?   [A-Za-z0-9]   (?:[^\s]+)?
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
							| \h+
						)+
						(?: \n | $ )
					)+													# May more than one line
				)?

				(?: \h+ )?

				(?:														# CLOSING which must be EXCLUDED
					\n
					| (?: - (?:\h+)? )?  E(i)xhibit(?-i)  [\W\h]+  \d (?:[^\n]+)?
					| (?i)DATED(?-i)
					| (?i)PURSUANT\h+TO(?-i)
				)?
			)
		/x';
		*/
		$sCapturePatternPrototype = '/(?: ^ | \n )			# Must be in the beginning or new line
			(?: \h+ )?													# May contain horizontal whitespace

			(?: 															# May be started with Exhibit or its variance
				(?: E(?i)xhibit(?-i)
					| EX
				) \b
				[^\n]+ 													# After exhibit there must be any chars
				(?: \. (?: html? | txt ) )?						# May contain file name
				\h+ 														# Must contain H whitespace
			)?

			(
				(?:														# May contain any chars without new line
					(?:
						(?:
							[^a-z\s] (?: [^\s]+ )?
							| (?i) \b (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
						)
						\h+
					){1,8}
				)?

				({CAPTURE_PATTERN})

				(?:														# May contain any chars as long the words first char is not lowercase OR an adjective word
					(?: \h+ | (?:\h+)? \n{1,2} (?:\h+)? )
					(?:
						(?:
							[A-Z0-9] (?:[^\s]+)? (?= \s | $ )
							| [^a-z\s] (?= \s | $)
							| [^a-z\s] (?:[^A-Za-z0-9\s]+)? [A-Za-z0-9] (?:[^\s]+)? (?= \s | $ )
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i) (?= \h | $ )
							| \h+ (?= \S | \n | $ )
						){1,8}
						(?: \n | $ )
					)+													# May more than one line
				)?
			)

			(?: \h+ )?

			(?:														# CLOSING which must be EXCLUDED
				\n
				| (?: - (?:\h+)? )?  E(i)xhibit(?-i)  [\W\h]+  \d (?:[^\n]+)?
				| (?i)DATED(?-i)
			)?
		/x';


		define('CAPTURE_PATTERN', str_replace('{CAPTURE_PATTERN}', $aRegexSearchTerms['flexible_capture'], $sCapturePatternPrototype));

		$aRegexSearchTerms['flexible_capture'] = array();

		/*
		define('AGMT_CAPTURE_PATTERN', '/(?: ^ | \n )			# Must be in the beginning or new line
			(?: \h+ )?													# May contain horizontal whitespace

			(?: 															# May be started with Exhibit or its variance
				(?: E(?i)xhibit(?-i)
					| EX
				) \b
				[^\n]+ 													# After exhibit there must be any chars
				(?: \. (?: html? | txt ) )?						# May contain file name
				\h+ 														# Must contain H whitespace
			)?

			(
				(?:														# May contain any chars without new line
					(?:
						(?:
							[^a-z\s] (?: [^\s]+ )?
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
						)
						\h+
					)+
				)?

				(\bA(?i)G(?:M|REEMEN)TS?(?-i))

				(?:														# May contain any chars as long the words first char is not lowercase OR an adjective word
					\h+
					(?:
						(?:
							[^a-z\s]  (?:[^A-Za-z0-9\s]+)?   [A-Za-z0-9]   (?:[^\s]+)?
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
							| \h+
						)+
						(?: \n | $ )
					)+														# May more than one line
				)?

				(?: \h+ )?

				(?:														# CLOSING which must be EXCLUDED
					\n
					| (?: - (?:\h+)? )?  E(i)xhibit(?-i)  [\W\h]+  \d (?:[^\n]+)?
					| (?i)DATED(?-i)
					| (?i)PURSUANT\h+TO(?-i)
				)
			)
		/x');
		$sAgmtPattern = '/(?: ^ | \n )			# Must be in the beginning or new line
			(?: \h+ )?													# May contain horizontal whitespace

			(?: 															# May be started with Exhibit or its variance
				(?: E(?i)xhibit(?-i)
					| EX
				) \b
				[^\n]+ 													# After exhibit there must be any chars
				(?: \. (?: html? | txt ) )?						# May contain file name
				\h+ 														# Must contain H whitespace
			)?

			(
				(?:														# May contain any chars without new line
					(?:
						(?:
							[^a-z\s] (?: [^\s]+ )?
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
						)
						\h+
					)+
				)?

				(\bA(?i)G(?:M|REEMEN)TS?(?-i))

				(?:														# May contain any chars as long the words first char is not lowercase OR an adjective word
					\h+
					(?:
						(?:
							[A-Z0-9] (?:[^\s]+)? (?= \s )
							| [^a-z\s] (?= \s )
							| [^a-z\s] (?:[^A-Za-z0-9\s]+)? [A-Za-z0-9] (?:[^\s]+)? (?= \s )
							| (?i) (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i) (?= \s )
							| \h+
						)+
					)														# One line only
				)?
			)
		/x';
		*/

		define('AGMT_CAPTURE_PATTERN', '/(?: ^ | \n )		# Must be in the beginning or new line
			(?: \h+ )?													# May contain horizontal whitespace

			(?: 															# May be started with Exhibit or its variance
				(?: E(?i)xhibit(?-i)
					| EX
				) \b
				[^\n]+ 													# After exhibit there must be any chars
				(?: \. (?: html? | txt ) )?						# May contain file name
				\h+ 														# Must contain H whitespace
			)?

			(
				(?:														# May contain any chars without new line
					(?:
						(?:
							[^a-z\s] (?: [^\s]+ )?
							| (?i) \b (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i)
						)
						\h+
					){1,6}
				)?

				\b (A(?i)G(?:M|REEMEN)TS?(?-i)) \b

				(?:														# May contain any chars as long the words first char is not lowercase or adjective word
					\h+
					(?:
						(?:
							[A-Z0-9] (?:[^\s]+)? (?= \s )
							| [^a-z\s] (?= \s )
							| [^a-z\s] (?:[^A-Za-z0-9\s]+)? [A-Za-z0-9] (?:[^\s]+)? (?= \s )
							| (?i) \b (?: ' . implode('|', $aRegexAdjectiveWords) . ') \b (?-i) (?= \s )
							| \h+
						){1,6}  (?= \n )
					)														# One line only
				)?
			)
		/x');
	}

	// Get $aInfo['info_description_tag'] from <DESCRIPTION> tag.
	if ($aInfo['category'] === false && defined('CAPTURE_PATTERN') && $sDescription && preg_match(CAPTURE_PATTERN, $sDescription, $aMatch))
	{
		$aInfo['info_description_tag'] = stripExcessiveSpaces($aMatch[1]);

		// Use category from $aInfo['info_description_tag'].
		//if ($aInfo['category'] !== false && stripos($aInfo['info_description_tag'], preg_replace('/S$/i', '', $aInfo['category'])) !== false && substr_count($aInfo['info_description_tag'], ' ') > substr_count($aInfo['category'], ' '))
		$aInfo['category'] = $aInfo['info_description_tag'];
	}

	if (isset($aMatch)) unset($aMatch);


	// Prioritize the Agreement!
	if ($aInfo['category'] === false && defined('CAPTURE_PATTERN'))
	{
		if (!$bMatch = preg_match(AGMT_CAPTURE_PATTERN, $sCleanHeaderContent, $aMatch))
		{
			$bMatch = preg_match(CAPTURE_PATTERN, $sCleanHeaderContent, $aMatch);
		}

		if ($bMatch)
		{
			$aInfo['info_search_term'] = stripExcessiveSpaces($aMatch[2]);

			$aInfo['info_captured_title'] = stripExcessiveSpaces($aMatch[1]);

			if ($aInfo['info_description_tag'] !== false) $aInfo['category'] = $aInfo['info_description_tag'];
			elseif (defined('FULL_TERM_PATTERN') && preg_match(FULL_TERM_PATTERN, $aInfo['info_captured_title'], $aMatch)) $aInfo['category'] = stripExcessiveSpaces($aMatch[1]);
			else $aInfo['category'] = $aInfo['info_captured_title'];
		}

		unset($aMatch);

		// Use category from $aInfo['info_description_tag'].
		//if ($aInfo['info_description_tag'] !== false && stripos($aInfo['info_description_tag'], preg_replace('/S$/i', '', $aInfo['info_search_term'])) !== false && substr_count($aInfo['info_description_tag'], ' ') > substr_count($aInfo['category'], ' ')) $aInfo['category'] = $aInfo['info_description_tag'];
	}






	// Get $aInfo['deal_parties'] & $aInfo['law_firm_attorney'].
	$aParties = getParties($sCleanContent);

	if ($aParties['deal_parties'] !== false) $aInfo['deal_parties'] = implode(',  ', array_map(function($party){return str_replace(',', '', $party);}, $aParties['deal_parties']));

	if ($aParties['law_firm_attorney'] !== false) $aInfo['law_firm_attorney'] = implode(',  ', array_map(function($party){return str_replace(',', '', $party);}, $aParties['law_firm_attorney']));


	// Get $aInfo['governing_law'].
	if ($sState = getGovLaw($sCleanContent)) $aInfo['governing_law'] = $sState;


	// Get `header`.
	$aInfo['header'] = $sCleanHeaderContent;


	return $aInfo;
}

// Merge both DEAL PARTIES and LAW FIRMS for efficiency.
function getParties(&$sCleanContent)
{
	if (!defined('PARTIES_PATTERN'))
	{
		$aRegexNames = array('Association'
			, 'BANK'
			, 'C(?i)o(?-i)'
			, 'C(?i)ompany(?-i)' //DISABLED, return many results!
			, 'C(?i)orp(?-i)'
			, 'CORPORATION'
			, 'I(?i)ncorporated(?-i)'
			, 'I(?i)nc(?-i)'
			, 'INTERNATIONAL'
			, 'Limited'
			, 'LLC'
			, 'L(?i)td(?-i)'
			, 'LP'
			, 'N\.A\.'
			, 'PLC'
			, '(?<! (?i)future(?-i) ) S(?i)ervices(?-i)'
		);

		$aRegexLawFirms = array('E(?i)sq(?-i)'
			//, 'G(?i)eneral(?-i)\h+C(?i)ounsel(?-i)'
			, 'LLP'
			, 'PLC'
		);

		$sPartiesPattern = '/
			(?:
				\n
				(?: (?:[^\n]+)? \h+ )?
				(?:														# May contain certain phrases in the beginning
					(?i)Page(?-i) \s+ [\d]+
					| [\d]+ (?= \s \d )
					| [\d]{3,} - [\d]{3,} (?= \s )
					| (?i)SETS \h+ FORTH(?-i) (?= \s \d )
					| W(?i)HEREAS(?-i),?
					| B(?i)eneficiary(?-i) \s+ A(?i)pplicant(?-i)
				)
				\s+

				| \s
			)

			(
				(?:
					(?:
						[AC-EG-NP-SU-Z] [^\s:;\[\]()]+
						| [0-9]  (?= \s )
						| [0-9] [^\s:;\[\]()]+
							(?= \s
								(?:
									(?<!
										, \s
										| \d \s
									)
								)
							)
							(?= \s )
						| B (?: [^Yy\s:;\[\]()\/] (?:[^\s:;\[\]()\/]+)? | [Yy] [^\s:;\[\]()\/]+ )
						| F (?: [^Oo\s:;\[\]()\/] (?:[^\s:;\[\]()\/]+)? | [Oo] [^Rr] (?:[^\s:;\[\]()\/]+)? | [Oo] [Rr] [^\s:;\[\]()\/]+ )
						| (?<=
								(?:
									(?<=
										B(?i)ANK(?-i)
										| B(?i)ANC(?-i)
									)
								)
							\s) [Oo] [Ff] (?= \s )
						| O (?: [^Ff\s:;\[\]()\/] (?:[^\s:;\[\]()\/]+)? | [Ff] [^\s:;\[\]()\/]+ )
						| T
							(?:
								[^OoHh\s:;\[\]()\/] (?:[^\s:;\[\]()\/]+)?
								| [Oo] [^\s:;\[\]()\/]+
								| [Hh] (?= \s )
								| [Hh] [^Ii] (?:[^\s:;\[\]()\/]+)?
								| [Hh] [Ii] (?= \s )
								| [Hh] [Ii] [^Ss] (?:[^\s:;\[\]()\/]+)?
								| [Hh] [Ii] [Ss] [^\s:;\[\]()\/]+
							)
						| &
					)

					(?= \s
						(?:
							(?<!
								-\s
								| D(?i)ated(?-i) \s
								| \d \s
								| - [\w] \s
								| - [\w][\w] \s
							)
						)
					)
					(?: \h+ | \n (?: \h+ )? )
				){1,6}

				(?<= \W
					(?:
						(?<! T(?i)he(?-i)\W )
					)
				)

				(' . implode('|', array_unique(array_merge($aRegexNames, $aRegexLawFirms))) . ') \b

			)
		/xU';

		$sNamesPattern = '/^(?:' . implode('|', $aRegexNames) . ')$/';
		define('NAMES_PATTERN', $sNamesPattern);
		unset($sNamesPattern);

		$sLawFirmsPattern = '/^(?:' . implode('|', $aRegexLawFirms) . ')$/';
		define('LAW_FIRMS_PATTERN', $sLawFirmsPattern);
		unset($sLawFirmsPattern);

		define('PARTIES_PATTERN', $sPartiesPattern);
		unset($sPartiesPattern);
	}

	//$aParties['law_firm_attorney'] = $aParties['deal_parties'] = false;
$aParties = [
    'law_firm_attorney' => [],
    'deal_parties' => []
];

	// Build the party denylist once per PHP execution.
	static $aPartyDenyList = null;
	if ($aPartyDenyList === null)
	{
		$aBuiltInDeny = array(
			'depository trust company',
			'the depository trust company',
			'dtc',
			'transfer agent',
			'securities and exchange commission',
			'the securities and exchange commission',
			'internal revenue service',
			'federal reserve',
		);
		$aOptionDeny = function_exists('get_option')
			? array_filter(array_map('trim', preg_split('/\r?\n/', get_option('sec_scraper_party_negatives', ''))))
			: array();
		$aPartyDenyList = array_map('strtolower', array_merge($aBuiltInDeny, $aOptionDeny));
	}

	if (preg_match_all(PARTIES_PATTERN, $sCleanContent, $aMatches, PREG_SET_ORDER))
	{
		// Remove double space & trim for each law firm name.
		foreach ($aMatches as $aVal)
		{
			$sName = trim(str_replace("\n", ' ', $aVal[1]));

			// Check if contain comma.
			if (substr_count($sName, ','))
			{
				$aWords = explode(',', $sName);

				if (count(explode(' ', trim($aWords[0]))) > 1 && count(explode(' ', trim($aWords[1]))) > 1)
				{
					array_shift($aWords);

					$sName = implode(',', $aWords);

					unset($aWords);
				}
			}

			$sName = stripExcessiveSpaces($sName);

			// Strip leading section/list number prefixes (e.g., "10.", "2.", "2.2.", "10.18.").
			$sName = preg_replace('/^\d+(?:\.\d+)*\.?\s*/', '', $sName);
			$sName = trim($sName);

			// Skip empty names.
			if (!strlen($sName)) continue;

			// Skip names that start with a lowercase letter.
			if (preg_match('/^[a-z]/', $sName)) continue;

			// Skip single-word names (bare suffix word like "Company" with nothing before it).
			if (strpos($sName, ' ') === false) continue;

			// Skip names with an embedded sentence-like period (e.g., "Voluntary Agreement. Company").
			// Two or more lowercase chars before ". " indicates a word boundary, not an abbreviation.
			if (preg_match('/[a-z]{2,}\.\s/', $sName)) continue;

			// Skip names that appear on the denylist.
			if (in_array(strtolower($sName), $aPartyDenyList)) continue;

			if (preg_match(NAMES_PATTERN, $aVal[2])) $aCompanies[] = $sName;

			if (preg_match(LAW_FIRMS_PATTERN, $aVal[2])) $aLawFirms[] = $sName;
		}

		// Remove duplicate.
		if (isset($aCompanies))
		{
			$aCompanies = array_unique($aCompanies);	// This is not enough

			$aCheckerBox = array();

			foreach ($aCompanies as $sComp)
			{
				$sName = str_replace(array(',', '.'), '', $sComp);
				$sName = strtolower(stripExcessiveSpaces($sName));

				if (!in_array($sName, $aCheckerBox))
				{
					$aParties['deal_parties'][] = $sComp;
					$aCheckerBox[] = $sName;
				}
			}
		}

		if (isset($aLawFirms))
		{
			$aLawFirms = array_unique($aLawFirms);	// This is not enough

			$aCheckerBox = array();

			foreach ($aLawFirms as $sLawFirm)
			{
				$sName = str_replace(array(',', '.'), '', $sLawFirm);
				$sName = strtolower(stripExcessiveSpaces($sName));

				if (!in_array($sName, $aCheckerBox))
				{
					$aParties['law_firm_attorney'][] = $sLawFirm;
					$aCheckerBox[] = $sName;
				}
			}
		}
	}

	return $aParties;
}

/* Old Governing Law
function getGovLaw(&$sCleanContent)
{
	
	
	$sGovLawPattern = '/(?<=\blaws of the State of\s)(?:Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New\s+Hampshire|New\s+Jersey|New\s+Mexico|New\s+York|North\s+Carolina|North\s+Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode\s+Island|South\s+Carolina|South\s+Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West\s+Virginia|Wisconsin|Wyoming)\b/i';

	if (preg_match($sGovLawPattern, $sCleanContent, $aMatch)) return ucwords(strtolower(trim($aMatch[0])));

	return false;
}
*/
//New Governing Law

function getGovLaw(&$sCleanContent)
{
    // Match "governed" in the same sentence or context as the state name
    $sGovLawPattern = '/\bgoverned\b.*?\blaws of the State of\s+(Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New\s+Hampshire|New\s+Jersey|New\s+Mexico|New\s+York|North\s+Carolina|North\s+Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode\s+Island|South\s+Carolina|South\s+Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West\s+Virginia|Wisconsin|Wyoming)\b/i';

    if (preg_match($sGovLawPattern, $sCleanContent, $aMatch)) {
        // The state name is in $aMatch[1]
        return ucwords(strtolower(trim($aMatch[1])));
    }

    return false;
}



function stripExcessiveSpaces(&$sContent)
{
	return trim(preg_replace('/\s\s+/', ' ', $sContent));
}


function cleanContent(&$sContent)
{
	/*$sCleanContent = preg_replace('/<(?:table|tr|p|br|div)(?:[^>]+)?>/i', "\n", $sCleanContent);	// Replace with new line*/
	$sCleanContent = preg_replace('/<(?:table|tr|p|div|h1)\b(?:[^>]+)?>/i', "\n\n", $sContent);	// Replace with double new line
	$sCleanContent = preg_replace('/<br(?:[^>]+)?>/i', "\n", $sCleanContent);	// Replace with new line
	$sCleanContent = preg_replace('/<\/td\s*>/i', "  ", $sCleanContent);	// Replace with double space 
	$sCleanContent = preg_replace('/<[^>]+>(?:Top\s+of\s+the\s+Form|Table\s+of\s+Contents)<\/[^>]+>/i', "\n", $sCleanContent);	// Del
	$sCleanContent = str_replace('&nbsp;', ' ', strip_tags($sCleanContent, '<div><p><b>'));	// Replace with single space
	$sCleanContent = preg_replace('/&amp(?:[^;]+)?;/i', '&', $sCleanContent);	// Replace ASCII ampersand to symbol
	$sCleanContent = preg_replace('/&#146;/', '\'', $sCleanContent);	// Replace quote ASCII to quote
	$sCleanContent = preg_replace('/&#14[78];/', '"', $sCleanContent);	// Replace quote ASCII to quote
	$sCleanContent = preg_replace('/&#[\dA-F]+;/', ' ', $sCleanContent);	// Replace any ASCII with single space
	$sCleanContent = strip_tags($sCleanContent);	// Strip HTML tags
	//$sCleanContent = preg_replace('/^\h+/m', '', $sCleanContent);	// Strip any front spaces in a line*/

	return $sCleanContent;
}

function cleanTip(&$sContent, $bText = false)
{
	if ($bText)
	{
		// Trim first section.
		if (false === $iPos = strpos($sContent, '<TEXT>')) $sCleanContent = preg_replace('/^((?:.+)?<TEXT>)/isU', '', $sContent);
		else $sCleanContent = substr($sContent, $iPos + 6);

		// Trim last section.
		$sLastSection = preg_replace('/(<\/TEXT>(?:[^$]+)?)$/i', '', substr($sCleanContent, -100));

		if (substr($sCleanContent, -100) == $sLastSection) $sCleanContent = preg_replace('/(<\/TEXT>[^$]{0,50})$/i', '', $sCleanContent);
		else $sCleanContent = substr($sCleanContent, 0, -100) . $sLastSection;

		unset($sLastSection);
	}
	else
	{
		// There is backtrack limit size problem and could be more, therefore, only get certain first & last section to overcome such problem.
		$iFirstSectionLength = 4000;
		$iLastSectionLength = 2000;

		$sFirstSection = substr($sContent, 0, $iFirstSectionLength);

		if (false === $iPos = stripos($sFirstSection, '<BODY'))	// <BODY not found
		{
			/*	Example of exhibit which has no <BODY!
				http://www.sec.gov/Archives/edgar/data/1035443/000103544304000010/exh14_1.htm
			*/
			if (false === $iPos = stripos($sFirstSection, '</HEAD>'))	// </HEAD not found
			{
				if (false === $iPos = stripos($sFirstSection, '<HTML'))	// <HTML not found
				{
					if (false === $iPos = strpos($sContent, '<TEXT>')) $sCleanContent = preg_replace('/^((?:.+)?<TEXT>)/isU', '', $sContent);
					else $sCleanContent = substr($sContent, $iPos + 6);
				}
				else $sCleanContent = preg_replace('/^(<HTML(?:[^>]+)?>(?:\s+)?)/iU', '', substr($sContent, $iPos));
			}
			else $sCleanContent = substr($sContent, $iPos + 7);
		}
		else $sCleanContent = substr($sContent, $iPos);

		$sTipBeginPattern = '/^
			(
				(?U) <BODY (?:[^<>]+)? > (?-U)

				(?:
					(?:
						(?:
							(?:\s+)? <[^A](?:[^<>]+)?>
						){1,4}
					)?
					(?:\s+)?
					<A \s+ [^>]+ > (?:\s+)? QuickLinks (?:\s+)?
					(?: (?:\s+)? <\/ [^<>]+ >)+
				)?
				(?:
					(?:
						(?:
							(?:
								(?:\s+)? <[^<>]+>
							){1,2}
						)?
						(?:\s+)?

						(?:[^\s]+ \s+)?
						Click \s+ here \s+ to \s+ rapidly \s+ navigate \s+ through \s+ this \s+ document
						(?:
							(?: (?:\s+)? <\/ [^>]+ > )+
						)?
					)?
				)?
				#(?: (?:\s+)? <!-- \h+ TOC_END \h+ --> )?
			)
		/xi';

		$sCleanContent = preg_replace($sTipBeginPattern, '', $sCleanContent);

		unset($sFirstSection);




		// Last section.
		if (false === $iPos = strripos($sCleanContent, '</BODY'))	// </BODY not found
		{
			if (false === $iPos = strripos($sCleanContent, '</HTML'))	// </HTML not found
			{
				$sLastSection = preg_replace('/(<\/TEXT>(?:[^$]+)?)$/i', '', substr($sCleanContent, -100));

				if (substr($sCleanContent, -100) == $sLastSection) $sCleanContent = preg_replace('/(<\/TEXT>[^$]{0,50})$/i', '', $sCleanContent);
				else $sCleanContent = substr($sCleanContent, 0, -100) . $sLastSection;

				unset($sLastSection);
			}
		}

		if ($iPos) $sCleanContent = substr($sCleanContent, 0, $iPos);	// </BODY or </HTML is found

		$sTipEndPattern = '/
			(
				#(?: <!-- \h+ TOC_BEGIN \h+ --> (?:\s+)? )?
				(?: (?: (?:\s+)? <(?:p|br)\b(?:[^<>]+)?> )+ )?
				(?:\s+)?
				<A \s+ [^<>]+ > (?:\s+)? QuickLinks (?:\s+)? <\/A>
				[^$]{0,500}
			)
		$ /xiU';


		$sCleanContent = substr($sCleanContent, 0, -($iLastSectionLength)) . preg_replace($sTipEndPattern, '', substr($sCleanContent, -($iLastSectionLength)));
	}

	// Make sure there is no link to sec.gov.
	if (!$bText) $sCleanContent = preg_replace('/(<a\s+[^>]+>\s*QuickLinks?\s*<\/A>|<a\s+(?:[^>]+)?\bhref\s*=\s*[\'"][^\'"]+\bsec\.gov[^>]+>.*<\/a>)/isU', '', $sCleanContent);

	return trim($sCleanContent);
}
