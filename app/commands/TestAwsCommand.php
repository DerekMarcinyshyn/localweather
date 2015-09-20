<?php

/**
 * Test AWS command
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    September 20, 2015
 */

use Illuminate\Console\Command;
use Localweather\Video\Aws;

class TestAwsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'localweather:test-aws';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test connection AWS S3.';

    /**
     * @var Aws
     */
    protected $aws;

    /**
     * @param Aws $aws
     */
	public function __construct(Aws $aws)
	{
		parent::__construct();
        $this->aws = $aws;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('AWS test start...');
        $this->info($this->aws->uploadVideos());
        $this->info('finished.');
	}
}
