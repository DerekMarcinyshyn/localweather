<?php
/**
 * Timelapse Command
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 11, 2014
 */


use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Localweather\Video\CreateTimelapse;

class TimelapseCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'localweather:create-timelapse';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create the daily timelapse video and archive images.';

    protected $createTimelapse;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(CreateTimelapse $createTimelapse)
	{
        $this->createTimelapse = $createTimelapse;
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
		return $scheduler;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->createTimelapse->render();
	}
}
