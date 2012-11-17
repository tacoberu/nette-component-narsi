<?php
/**
 * Navigation
 * Elwean
 * Narsi
 * Ynias
 *
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


use Nette\Application\UI\Control;


/**
 * Navigation control element.
 */
class Navigation extends Control
{

	private $showRules;


	private $counter = 0;



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
		$control->setParent(Null);
		$control->setPresenter($this->getPresenter());
		$control->setShowRules($this->showRules);
		return $this[$name] = $control;
	}



	/**
	 * Create template
	 * @return Template
	 */
	protected function createTemplate($class = NULL)
	{
		return parent::createTemplate()->setFile(__DIR__ . "/menu.latte");
	}



	/**
	 * Create template
	 * @return Template
	 */
	protected function getComponentsExt()
	{
		$data = array();

		//	Projít všechny komponenty a nechat je rozpadnout.
		foreach (parent::getComponents() as $key => $row) {
			if (method_exists($row, 'expand')) {
				foreach ($row->expand() as $rownew) {
					if ($this->showRules && ! call_user_func($this->showRules, $rownew)) {
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
	 * Render full menu
	 */
	public function render()
	{
		//	Předat do šablony.
		$this->template->model = $this->getComponentsExt();
		$this->template->renderChildren = True;
		$this->template->render();
	}



	/**
	 * Pravidla určujhící zda se prvek zoibrazí,.
	 */
	public function setShowRules($closure)
	{
		$this->showRules = $closure;
	}

}
