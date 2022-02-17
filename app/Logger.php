<?php

namespace App;



class Logger
{
    public function __construct($log_name, $page_name)
    {
        $date = date("Y_m_d");
        $this->log = null;
        if ($log_name == null) {
            $log_name = "a_default_log_{$date}.log";
        } else {
            $log_name = "{$log_name}_{$date}.log";
        }
        $this->log_name = $log_name;

        $this->app_id = uniqid(); //give each process a unique ID for differentiation
        $this->page_name = $page_name;

        $this->log_file = public_path('logs') . '/' . $this->log_name;
    }
    public function log_msg($msg)
    { //the action
        return;
        try {
            $this->log = fopen($this->log_file, 'a');
            $log_line = join(' : ', array(date(DATE_RFC822), $this->page_name, $this->app_id, $msg));
            fwrite($this->log, $log_line . "\n");
        } catch (\Throwable $th) {
        }
    }
    function close()
    { //makes sure to close the file and write lines when the process ends.
        return;
        $date = date('Y-m-d');

        $this->log_msg("Closing log $date-----------------------");
        if ($this->log) {

            fclose($this->log);
        }
    }
}
