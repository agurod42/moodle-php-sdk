<?php namespace MoodleSDK\Log;

define('EOL', "\n");

class ConsoleLog extends Log {

    protected static function newInstance() {
        return new ConsoleLog();
    }

    protected function render() {
        echo EOL.'--- DEBUG INFO ---'.EOL.EOL;
        foreach ($this->lines as $line) {
            echo $line.EOL;
        }
    }

    public function section($title) {
        $this->lines[] = EOL.date_format(new \DateTime(), 'Y-m-d h:i:s').' '.$title.EOL;
        return $this;
    }

    public function info($data) {
        if (is_string($data)) {
            $this->lines[] = $data;
        }
        else if (is_array($data)) {
            foreach ($data as $d) {
                $this->info($d);
            }
        }
        else {
            $this->lines[] = json_encode($data);
        }
        
        return $this;
    }

    public function infoAnx($data) {
        $this->lines[] = EOL."\t".$data.EOL;
        return $this;
    }

}