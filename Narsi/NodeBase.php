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


use Nette\ComponentModel\Container,
	Nette\Application\UI\Presenter;


/**
 * Base class that implements the basic functionality common to form controls.
 *
 * @author     Martin Takáč <taco@taco-beru.name>
 */
abstract class NodeBase extends Container implements INode
{


	private $counter = 0;
	


	private $showRules;

	

	private $presenter;
	
	

	/** @var string */
	private $label;



	/** @var Nette\ITranslator */
	private $translator;



	/** @var bool */
	private $isCurrent = False;


	/** @var bool */
	private $disabled = False;


	/** @var string */
	public $resource;


	/** @var string */
	public $privilege;



	/**
	 */
	public function setLabel($string)
	{
		$this->label = $string;
		return $this;
	}



	/**
	 */
	final public function getLabel()
	{
		return $this->translate($this->label);
	}



	/**
	 * Nastaví, zda má být prvek aktivní. Coé to znamená řeší až renderer.
	 */
	public function setDisabled($bool)
	{
		$this->disabled = $bool;
		return $this;
	}



	public function getIsDisabled()
	{
		return $this->disabled;
	}



	/**
	 * Adds push buttons with no default behavior.
	 * @param  string  control name
	 * @param  string|IComponent control
	 * @return self
	 */
	public function add(INode $control, $name = Null)
	{
		if (empty($name)) {
			$name = ++$this->counter;
		}
		$control->setPresenter($this->getPresenter());
		$control->setShowRules($this->showRules);

		$this->addComponent($control, $name);

		return $control;
	}



	public function addLink($title, $url, $args = array(), $isAjax = False, $name = Null)
	{
		$control = new NodeLink($title, $url, $args, $isAjax);
		return $this->add($control, $name);
	}



	public function addLabel($title, $name = Null)
	{
		$control = new NodeLabel($title);
		return $this->add($control, $name);
	}






	/**
	 * Nastavení sobě a předkům currentnost.
	 */
	public function setIsCurrent($bool)
	{
		$this->isCurrent = $bool;

		if ($this->parent instanceof INode) {
			$this->parent->setIsCurrent($bool);
		}

		return $this;
	}



	public function getIsCurrent()
	{
		return $this->isCurrent;
	}



	public function setPresenter(Presenter $presenter)
	{
		$this->presenter = $presenter;
		return $this;
	}



	public function getPresenter()
	{
		return $this->presenter;
	}


	/********************* translator ******************/



	/**
	 * Sets translate adapter.
	 * @param  Nette\ITranslator
	 * @return FormControl  provides a fluent interface
	 */
	public function setTranslator(Nette\ITranslator $translator = NULL)
	{
		$this->translator = $translator;
		return $this;
	}



	/**
	 * Returns translate adapter.
	 * @return Nette\ITranslator|NULL
	 */
	final public function getTranslator()
	{
		return $this->translator;
	}



	/**
	 * Returns translated string.
	 * @param  string
	 * @param  int      plural count
	 * @return string
	 */
	public function translate($s, $count = NULL)
	{
		$translator = $this->getTranslator();
		return $translator === NULL || $s == NULL ? $s : $translator->translate($s, $count); // intentionally ==
	}



	/**
	 * Create template
	 * @return Template
	 */
	public function getComponentsExt()
	{
		$data = array();

		//	Projít všechny komponenty a nechat je rozpadnout.
		foreach (parent::getComponents() as $key => $row) {
			if (method_exists($row, 'expand')) {
				foreach ($row->expand() as $rownew) {
					if (! call_user_func($this->showRules, $rownew)) {
						$rownew->setDisabled(True);
					}
					$data[] = $rownew;
				}
			}
			else {
				if ($this->showRules && ! call_user_func($this->showRules, $row)) {
					$row->setDisabled(True);
				}
				$data[] = $row;
			}
		}

		return $data;
	}



	/**
	 * Pravidla určujhící zda se prvek zoibrazí,.
	 */
	public function setShowRules($closure)
	{
		$this->showRules = $closure;
	}


}
