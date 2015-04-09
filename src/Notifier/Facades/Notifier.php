<?php namespace Coreplex\Notifier\Facades;

use Illuminate\Support\Facades\Facade;

class Notifier extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'coreplex.notifier.driver'; }

}