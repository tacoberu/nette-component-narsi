<?php
/**
 * This file is part of the Taco Library (http://dev.taco-beru.name)
 *
 * Copyright (c) 2004, 2011 Martin Takáč (http://martin.takac.name)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 *
 * PHP version 5.3
 */

namespace Narsi;



/**
 * Base class that implements the basic functionality common to form controls.
 *
 * @author     Martin Takáč <taco@taco-beru.name>
 */
interface INode
{


	/**
	 * Nastavení sobě a předkům currentnost.
	 */
	function setIsCurrent($bool);


}
