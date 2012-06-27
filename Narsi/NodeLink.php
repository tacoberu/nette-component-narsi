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


use Nette,
	Nette\Application\UI\Presenter,
	Nette\Web\Html;



/**
 * Base class that implements the basic functionality common to form controls.
 *
 * @author     Martin Takáč <taco@taco-beru.name>
 */
class NodeLink extends NodeBase
{



	/** @var string */
	public $destination;

	/** @var array */
	public $args;

	/** @var bool */
	public $ajax = False;

	/** @var array */
	public $optional;



	/**
	 * @param  string  caption
	 */
	public function __construct($caption, $destination, $args = array(), $ajax = False)
	{
		$this->label = $caption;
		$this->destination = $destination;
		$this->args = $args;
		$this->ajax = $ajax;
		$this->optional = new \stdClass;
	}



	/**
	 * @param  string  caption
	 */
	public function setPresenter(Presenter $presenter)
	{
		parent::setPresenter($presenter);

		foreach ($this->args as &$arg){
			if (is_callable($arg)){
				$arg = call_user_func($arg, $presenter);
			}
		}
		
		$desc = $this->presenter->link($this->destination, $this->args);
		$th = $this->presenter->link('this');

//		if (!$this->isCurrent)
//			$this->isCurrent = ($desc == $th);
#		if ($this->isCurrent = ($desc == $th)) {
#			$this->parent->isCurrent = True;
#		}

		return $this;
	}



	/**
	 * @param  string  caption
	 */
	public function getUrl()
	{
		if (empty($this->presenter)) {
			throw new \InvalidStateException('Not set presenter.');
		}
		return $this->presenter->link($this->destination, $this->args);
	}



}
