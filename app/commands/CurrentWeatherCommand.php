<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Localweather\Data\Current;

class CurrentWeatherCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'localweather:current';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Does not do anything!!!';

    protected $current;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Current $current)
	{
        $this->current = $current;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $this->current->getCurrentWeatherData();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
