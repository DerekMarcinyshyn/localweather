<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Localweather\Data\Image;

class CleanImageCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'localweather:clean-image';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get clean image no watermark from RaspberryPi.';

    /**
     * @var Localweather\Data\Image
     */
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
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		return $scheduler
            ->hours(4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21)
            ->everyMinutes(10);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->image->getCleanImage();
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
