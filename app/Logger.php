<?php

namespace App;



class Logger
{
    public function __construct($log_name, $page_name)
    {
        $date = date("Y_m_d");
        if (!file_exists('logs/' . $log_name)) {
            $log_name = "a_default_log_{$date}.log";
        }
        $log_name = "a_default_log_{$date}.log";
        $this->log_name = $log_name;

        $this->app_id = uniqid(); //give each process a unique ID for differentiation
        $this->page_name = $page_name;

        $this->log_file = public_path('logs') . '/' . $this->log_name;
    }
    public function log_msg($msg)
    { //the action
        $this->log = fopen($this->log_file, 'a');
        $log_line = join(' : ', array(date(DATE_RFC822), $this->page_name, $this->app_id, $msg));
        fwrite($this->log, $log_line . "\n");
    }
    function close()
    { //makes sure to close the file and write lines when the process ends.
        $date = date('Y-m-d');

        $this->log_msg("Closing log $date-----------------------");

        fclose($this->log);
    }
}
