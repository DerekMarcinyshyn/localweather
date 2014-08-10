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
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;

class LatestImageCommand extends ScheduledCommand {

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

    /**
     * @var Localweather\Data\Image
     */
    protected $image;

    /**
     * @param Image $image
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
     * When a command should run
     *
     * @param Scheduler $scheduler
     * @return \Indatus\Dispatcher\Scheduling\Schedulable
     */
    public function schedule(Schedulable $scheduler)
    {
        return $scheduler->everyMinutes(5);
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
