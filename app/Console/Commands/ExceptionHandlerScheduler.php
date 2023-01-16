<?php

namespace SMT\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use SMT\Models\Application;
use SMT\Models\Exception;
use SMT\Models\ServerDetail;
use DB;

class ExceptionHandlerScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:exception {--application=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $this->checkLogException();
    }

    public function checkLogException()
    {
        $applications = Application::where('is_deleted', 0)->where('is_active', 1)
                        ->where('server_connect', 1)
                        ->select('id', 'owner_id', 'name')
                        ->with('getServerDetails');
        if ($this->option('application')) {
            $applications = $applications->where('id', $this->option('application'));
        }
        $applications = $applications->get();
        if ($applications) {
            foreach ($applications as $application) {
                /* FTP Account */
                $ftpDetails = [
                    'id' => $application['id'], /* application id */
                    'server' => $application['getServerDetails']['host'], /* host */
                    'username' => $application['getServerDetails']['username'], /* username */
                    'password' => $application['getServerDetails']['password'], /* password */
                    'port' => $application['getServerDetails']['port'], /* port */
                    'path' => $application['getServerDetails']['path'] /* path */
                ];
                /* Connect using basic FTP */
                $connectIt = ftp_connect($ftpDetails['server']);
                if ($connectIt) {
                    /* Login to FTP */
                    $loginResult = ftp_login($connectIt, $ftpDetails['username'], $ftpDetails['password']);
                    if ($loginResult) {
                        ftp_set_option($connectIt, FTP_USEPASVADDRESS, false); /* set ftp option */
                        ftp_pasv($connectIt, true); /* make connection to passive mode */

                        $directories = ftp_rawlist($connectIt, $ftpDetails['path'].'storage/logs');
                        if ($directories) {
                            $this->readFiles($directories, $ftpDetails);
                        } else {
                            Application::where('id', $application['id'])->update(['server_connect' => 0]);
                        }
                    } else {
                        Application::where('id', $application['id'])->update(['server_connect' => 0]);
                    }
                    ftp_close($connectIt);
                } else {
                    Application::where('id', $application['id'])->update(['server_connect' => 0]);
                }
            }
        }
    }

    public function readFiles($directories, $ftpDetails)
    {
        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)\s{(?<detail>.*)/m";
        $allowed = array('log');
        $lastException = Exception::where('project_id', $ftpDetails['id'])
                        ->select('timestamp')->orderBy('timestamp', 'DESC')->first();
        foreach (array_reverse($directories) as $directory) {
            $file = preg_split('/\s+/', $directory);
            // $filename = 'ftp://p487996:x!8En_ir9inymh@p487996.mittwaldserver.info'.$directory;
            $filename = 'ftp://'.$ftpDetails['username'].':'.$ftpDetails['password'].'@'.$ftpDetails['server'].$ftpDetails['path'].'storage/logs/'.$file['8'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (is_file($filename) && in_array($ext, $allowed)) {
                $contents = file_get_contents($filename);
                if ($contents) {
                    preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER, 0);
                    if ($matches) {
                        foreach (array_reverse($matches) as $key => $match) {
                            if (empty($lastException) || (strtotime($match['date']) > strtotime($lastException['timestamp']))) {
                                $logs = [
                                        'project_id' => $ftpDetails['id'],
                                        'date' => date('Y-m-d', strtotime($match['date'])),
                                        'timestamp' => $match['date'],
                                        'env' => $match['env'],
                                        'type' => $match['type'],
                                        'message' => trim($match['message']),
                                        'detail' => trim($match['detail']),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ];
                                Exception::insert($logs);
                            }
                        }
                    }
                }
            }
        }
    }
}
