<?php
/**
 * Get latest image command
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 8, 2014
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Localweather\Data\Image;

class LatestImageCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'localweather:latest-image';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get the latest image from the RaspberryPi.';

    protected $image;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Image $image)
	{
        $this->image = $image;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->image->getLatestImage();
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
