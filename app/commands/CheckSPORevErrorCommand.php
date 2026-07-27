<?php
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
class CheckSPORevErrorCommand extends Command
{
    protected $name = 'spo:check-rev-error';
    protected $description = 'Prüft SPO Rev Error und aktualisiert Fortschritt';
    public function fire()
    {
        $jobKey = 'spo_rev_error_check';
        $status = $this->option('status');
        $ausm = $this->option('ausm');
        if (!$status) {
            $status = 'PLAN';
        }
        if (!$ausm) {
            $ausm = '26';
        }
        JobProgress::where('job_key', $jobKey)->update(array(
            'status' => 'running',
            'message' => 'Command gestartet mit Status=' . $status . ', Ausm=' . $ausm,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        try {
            $controller = App::make('Office365Controller');
            $controller->runCheckSPORevErrorFromCommand($jobKey, $status, $ausm);
        } catch (Exception $e) {
            JobProgress::where('job_key', $jobKey)->update(array(
                'status' => 'failed',
                'message' => 'Command-Fehler: ' . $e->getMessage(),
                'updated_at' => date('Y-m-d H:i:s')
            ));
            Log::error('CheckSPORevErrorCommand Fehler: ' . $e->getMessage());
        }
    }
    protected function getOptions()
    {
        return array(
            array('status', null, InputOption::VALUE_OPTIONAL, 'Status', null),
            array('ausm', null, InputOption::VALUE_OPTIONAL, 'Ausm', null),
        );
    }
}