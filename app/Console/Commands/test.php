<?php

namespace Gressel\Console\Commands;

use Illuminate\Console\Command;
use SSH;

class Test extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'run:test {--project_id=}';
    protected $cmdOutput;
    protected $ftpDetails;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to find package statuses of all packages in a project run by composer';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projectId = $this->option('project_id');
        $this->cmdOutput = '';
        $this->ftpDetails = [
            'host' => 'p487996.mittwaldserver.info',
            'username'  => 'p487996',
            'password'  => 'x!8En_ir9inymh',
            'path' => 'cd /home/www/p487996/html/simsstage.spawoz.com',
            'timeout'   => 10000
        ];
        config(['remote.connections.production' => $this->ftpDetails]); // Set SSH configuration
        if ($this->activeConnection()) {
            SSH::run(
                [
                    $this->ftpDetails['path'],
                    'composer outdated --format json',
                ], function($line)
                {
                    $this->cmdOutput = $this->cmdOutput.' '.(string)$line.PHP_EOL;
                }
            );
            $this->cmdOutput = preg_replace('/\s+/', ' ',$this->cmdOutput); // Format output for json decoding
            $outputDecoded = json_decode($this->cmdOutput, true);
            $packages = isset($outputDecoded['installed']) ? $outputDecoded['installed'] : [];
            $uptoDate = $minorUpdateAvailble = $majorUpdateAvaiable = $specialCase = [];
            foreach ($packages as $package) {
                if ($package['latest-status'] == 'update-possible') { // Major update available
                    $majorUpdateAvaiable[] = $package;
                } elseif ($package['latest-status'] == 'semver-safe-update') { // Minor update available
                    $minorUpdateAvailble[] = $package;
                } elseif ($package['latest-status'] == 'up-to-date') { // Uptodate
                    $uptoDate[] = $package;
                }
            }
            dd($uptoDate , $minorUpdateAvailble , $majorUpdateAvaiable);
        }
    }

    // Run a simple composer command to check if connection is active
    function activeConnection()
    {
        try {
            SSH::run(
                [
                    $this->ftpDetails['path'],
                    'composer self-update',
                ]
            );
            
            return true;
        }   catch (\RuntimeException $exception) {
            return false;
        }
    }
}
