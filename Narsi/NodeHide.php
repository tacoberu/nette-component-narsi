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


class NodeHide extends NodeBase
{

	/** @var string */
	public $destination;

	/** @var array */
	public $args;



	/**
	 * @param  string  caption
	 */
	public function __construct($caption, $destination, $args = array())
	{
		$this->label = $caption;
		$this->destination = $destination;
		$this->args = $args;
	}
}
