<?php

namespace ConsoleTVs\Charts\Commands;

use Illuminate\Console\Command;

class ChartsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:chart
                                {name : The name of the chart file}
                                {library? : Library of the chart}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new chart';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('[Charts] Creating chart...');

        $path = base_path('app/Charts');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fpath = $path.'/'.$this->arguments('name')['name'].'.php';

        if (file_exists($fpath)) {
            $this->error('[Charts] File already exists!');

            return;
        }

        $file = file_get_contents(__DIR__.'/../Classes/ChartCLass.php');

        file_put_contents($fpath, $file);

        $this->strReplaceFile('ChartClass', $this->arguments('name')['name'], $fpath);
        $this->strReplaceFile(
            'Library',
            $this->arguments('library')['library'] ? ucfirst($this->arguments('library')['library']) : ucfirst(config('charts.default_library')),
            $fpath
        );

        $this->info("[Charts] Chart created! - Location: {$fpath}");
    }

    /**
     * Replace a string from a file.
     *
     * @param string $find
     * @param string $replace
     * @param string $file_path
     *
     * @return void
     */
    protected function strReplaceFile(string $find, string $replace, string $file_path)
    {
        file_put_contents($file_path, str_replace($find, $replace, file_get_contents($file_path)));
    }
}
