<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2008
 * @author     Andreas Schempp <andreas@schempp.ch
 * @license    LGPL
 */


/**
 * Uncomment this line to convert the member birthday field
 */
//define('BIRTHDAY_DATEFIELD', 1);



if(defined('BIRTHDAY_DATEFIELD'))
{
	/**
	 * Uncomment those lines to display day, month or year as text field (not select)
	 */
//	$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['fieldDay'] = 'text';
//	$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['fieldMonth'] = 'text';
//	$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['fieldYear'] = 'text';
	
	/**
	 * Uncomment this line if you want to show month names (not numbers)
	 */
	$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['names'] = true;
	
	
	// Do not change below!
	$GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['inputType'] = 'date';
	unset($GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['datepicker']);
	unset($GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['rgxp']);
	
	$GLOBALS['TL_CSS'][] = 'system/modules/datefield/html/style.css';
}
