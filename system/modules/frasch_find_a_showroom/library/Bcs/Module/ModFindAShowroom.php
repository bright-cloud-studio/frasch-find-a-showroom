<?php

/**
 * Bright Cloud Studio's Find A Showroom
 *
 * Copyright (C) 2023 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/frasch-find-a-showroom
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

  
namespace Bcs\Module;
 
use Bcs\Model\Showroom;
use Bcs\Showrooms; 
 
class ModFindAShowroom extends \Contao\Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_find_a_showroom';
 
	protected $arrStates = array();
 
	/**
	 * Initialize the object
	 *
	 * @param \ModuleModel $objModule
	 * @param string       $strColumn
	 */
	public function __construct($objModule, $strColumn='main')
	{
		parent::__construct($objModule, $strColumn);
		$this->arrStates = $this->getStates();
	}
	
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['mod_find_a_showroom'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
 
            return $objTemplate->parse();
        }
 
        return parent::generate();
    }
 
 
    /**
     * Generate the module
     */
    protected function compile()
    {
		  $objLocation = Showroom::findBy('published', '1');

        if (!in_array('system/modules/frasch_find_a_showroom/assets/js/mod_find_a_showroom.js', $GLOBALS['TL_JAVASCRIPT'])) { 
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/frasch_find_a_showroom/assets/js/mod_find_a_showroom.js';
        }
		

		
  		// Return if no pending items were found
  		if (!$objLocation)
  		{
  			$this->Template->empty = 'No Locations Found';
  			return;
  		}

		$arrShowrooms = array();
        $showroom_id = 0;
		
		// Generate List
		while ($objLocation->next())
		{
            
			$arrLocation['showroom_name']              = $objLocation->showroom_name;
			$arrLocation['territory_sales_manager']    = $objLocation->territory_sales_manager;
			$arrLocation['street_address']             = $objLocation->street_address;
			$arrLocation['city']                       = $objLocation->city;
			$arrLocation['products']                   = $objLocation->products;
            $arrLocation['partner_type']               = $objLocation->partner_type;
            $arrLocation['gallery_url']                = $objLocation->gallery_url;
			
			$arrLocation['state']                      = unserialize($objLocation->state);

			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_showroom');
			$objTemplate = new \FrontendTemplate($strItemTemplate);
			$objTemplate->setData($arrLocation);
			$arrShowrooms[$showroom_id] = $objTemplate->parse();
            $showroom_id++;
		}

        $this->Template->showrooms = $arrShowrooms;
		
	}

	public function generateSelectOptions($blank = TRUE) {
		$strUnitedStates = '<optgroup label="United States">';
		$strCanada = '<optgroup label="Canada"><option value="CAN">All Provinces</option></optgroup>';
		foreach ($this->arrStates['United States'] as $abbr => $state) {
			if (!in_array($objLocation->state, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strUnitedStates .= '<option value="' .$abbr .'">' .$state .'</option>';
			}
		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Select Location...</option>' : '') .$strUnitedStates .$strCanada;
	}
	
	function sortByState($a, $b) {
		if ($a['Name'] == $b['Name']) {
			return 0;
		}
		return ($a['Name'] < $b['Name']) ? -1 : 1;
	}
	
	
	
	
	
	
	function getStates()
    	{		
        	return array(
			'United States' => array(
				'alabama' => 'Alabama',
				'alaska' => 'Alaska',
				'arizona' => 'Arizona',
				'arkansas' => 'Arkansas',
				'california' => 'California',
				'colorado' => 'Colorado',
				'connecticut' => 'Connecticut',
				'delaware' => 'Delaware',
				'florida' => 'Florida',
				'georgia' => 'Georgia',
				'hawaii' => 'Hawaii',
				'idaho' => 'Idaho',
				'illinois' => 'Illinois',
				'indiana' => 'Indiana',
				'iowa' => 'Iowa',
				'kansas' => 'Kansas',
				'kentucky' => 'Kentucky',
				'louisiana' => 'Louisiana',
				'maine' => 'Maine',
				'maryland' => 'Maryland',
				'massachusetts' => 'Massachusetts',
				'michigan' => 'Michigan',
				'minnesota' => 'Minnesota',
				'mississippi' => 'Mississippi',
				'missouri' => 'Missouri',
				'montana' => 'Montana',
				'nebraska' => 'Nebraska',
				'nevada' => 'Nevada',
				'new_hampshire' => 'New Hampshire',
				'new_jersey' => 'New Jersey',
				'new_mexico' => 'New Mexico',
				'new_york' => 'New York',
				'north_carolina' => 'North Carolina',
				'north_dakota' => 'North Dakota',
				'ohio' => 'Ohio',
				'oklahoma' => 'Oklahoma',
				'oregon' => 'Oregon',
				'pennsylvania' => 'Pennsylvania',
				'rhode_island' => 'Rhode Island',
				'south_carolina' => 'South Carolina',
				'south_dakota' => 'South Dakota',
				'tennessee' => 'Tennessee',
				'texas' => 'Texas',
				'utah' => 'Utah',
				'vermont' => 'Vermont',
				'virginia' => 'Virginia',
				'washington' => 'Washington',
				'west_virginia' => 'West Virginia',
				'wisconsin' => 'Wisconsin',
				'wyoming' => 'Wyoming',
                'washington_dc' => 'Washington, D.C.',
				'puerto_rico' => 'Puerto Rico'),
			'Canada' => array(
				'alberta' => 'Alberta',
				'british_columbia' => 'British Columbia',
                'manitoba' => 'Manitoba',
				'new_brunswick' => 'New Brunswick',
                'newfoundland' => 'Newfoundland',
				'nova_scotia' => 'Nova Scotia',
                'ontario' => 'Ontario',
                'prince_edward_island' => 'Prince Edward Island',
				'quebec' => 'Quebec',
				'saskatchewan' => 'Saskatchewan'),
		);
	}

	
	
	

} 
