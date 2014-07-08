<?php

/**
 * ccdatepicker extension for Contao Open Source CMS
 * 
 * Copyright © 2014 ETES GmbH
 * 
 * @package ccdatepicker
 * @author  Andreas Schempp <andreas@schempp.ch
 * @author  Sebastian Leitz <sebastian.leitz@etes.de>
 * @license LGPLv3
 */


/**
 * Class CCExpireDateField
 *
 * Provide a date picker for future expiration dates of credit cards (month/year)
 */
class CCExpireDateField extends Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;
	
	
	/**
	 * Use month names
	 * @var boolean
	 */
	protected $blnMonthNames = false;
	

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'form_widget';

	/**
	 * Contents
	 * @var array
	 */
	protected $arrContents = array();
	
	
	/**
	 * Values
	 */
	protected $varValue = array();
	
	
	/**
	 * Define default values
	 */
	protected $fieldMonth = 'select';
	protected $fieldYear = 'select';
	
	
	/**
	 * Overwrite parent constructor to select correct template
	 */
	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
		if (TL_MODE == 'BE') $this->strTemplate = 'be_widget';
	}
	


	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'value':
				$this->varValue = array();
				if (!$varValue)
				{
					$this->varValue['month'] = $GLOBALS['TL_LANG']['MSC']['month_hint'];
					$this->varValue['year'] = $GLOBALS['TL_LANG']['MSC']['year_hint'];
				}
				else
				{
					$this->varValue['month'] = intval(date('m', intval($varValue)));
					$this->varValue['year'] = intval(date('Y', intval($varValue)));
				}
				break;

			// maxlength and rgxp is not allowed
			case 'maxlength':
			case 'rgxp':
				break;

			case 'mandatory':
				$this->arrConfiguration['mandatory'] = $varValue ? true : false;
				break;
				
			case 'names':
				$this->blnMonthNames = $varValue;
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}


	/**
	 * Trim values
	 * @param mixed
	 * @return mixed
	 */
	protected function validator($varInput)
	{
		if (!is_array($varInput))
		{
			return false;
		}
		
		if (!strlen($varInput['month']) || !strlen($varInput['year']))
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
		}
		
		if (!preg_match('/^[\d \.-]*$/', $varInput['month']) || !preg_match('/^[\d \.-]*$/', $varInput['year']))
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['digit'], $this->strLabel));
		}
		
		return mktime(0, 0, 0, intval($varInput['month'])+1, 0, intval($varInput['year']));
//		return parent::validator(trim($varInput));
	}


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$strBuffer = '';
		
		if (!is_array($this->varValue))
			$this->value = $this->varValue;
		
		// Generate months
		if ($this->fieldMonth == 'text')
		{
			$strBuffer .= sprintf('<input type="text" name="%s[month]" id="ctrl_%s_month" class="tl_text ccdate_month%s" value="%s" maxlength="2"%s /> ',
									$this->strName,
									$this->strId,
									(strlen($this->strClass) ? ' ' . $this->strClass : ''),
									specialchars($this->varValue['month']),
									$this->getAttributes());
		}
		else
		{
			$arrOptions = array('<option value="">' . $GLOBALS['TL_LANG']['MSC']['month'] . '</option>');
			foreach( range(1, 12, 1) as $var )
			{
				$arrOptions[] = sprintf('<option value="%s"%s>%s</option>', 
											$var, 
											(($this->varValue['month'] === $var) ? ' selected="selected"' : ''),
											$this->blnMonthNames ? $GLOBALS['TL_LANG']['MONTHS'][($var-1)] : $var);
			}
			
			$strBuffer .= sprintf('<select name="%s[month]" id="ctrl_%s_month" class="tl_mselect ccdate_month%s"%s>%s</select> ',
									$this->strName,
									$this->strId,
									(strlen($this->strClass) ? ' ' . $this->strClass : ''),
									$this->getAttributes(),
									implode('', $arrOptions));
		}
		
		
		// Generate years
		if ($this->fieldYear == 'text')
		{
			$strBuffer .= sprintf('<input type="text" name="%s[year]" id="ctrl_%s_year" class="tl_text ccdate_year%s" value="%s" maxlength="4" onblur="if (this.value==\'\') { this.value=\'' . $GLOBALS['TL_LANG']['MSC']['year_hint'] . '\'; this.style.color = \'#868686\' }" onfocus="if (this.value==\'' . $GLOBALS['TL_LANG']['MSC']['year_hint'] . '\') { this.value=\'\'; this.style.color = \'#000000\' }"%s /> ',
									$this->strName,
									$this->strId,
									(strlen($this->strClass) ? ' ' . $this->strClass : ''),
									specialchars($this->varValue['year']),
									$this->getAttributes());
		}
		else
		{
			$date = new DateTime();
			$arrOptions = array('<option value="">' . $GLOBALS['TL_LANG']['MSC']['year'] . '</option>');
			foreach( range($date->format('Y'), $date->modify('+3year')->format('Y'), 1) as $var )
			{
				$arrOptions[] = sprintf('<option value="%s"%s>%s</option>', 
											$var, 
											(($this->varValue['year'] == $var) ? ' selected="selected"' : ''),
											$var);
			}
			
			$strBuffer .= sprintf('<select name="%s[year]" id="ctrl_%s_year" class="tl_mselect ccdate_year%s"%s>%s</select> ',
									$this->strName,
									$this->strId,
									(strlen($this->strClass) ? ' ' . $this->strClass : ''),
									$this->getAttributes(),
									implode('', $arrOptions));
		}
	
		return $strBuffer;
	}
}

?>
