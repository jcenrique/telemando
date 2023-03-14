<?php
 
 namespace App\Logs;
  
 use Monolog\Handler\AbstractProcessingHandler;
 use App\Models\LogMessage;
  
 class DatabaseHandler extends AbstractProcessingHandler
 {
    /**
     * @inheritDoc
     */
    protected function write(array $record): void
    {
      //  dd($record);
        LogMessage::create([
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'message' => $record['message'],
            'logged_at' => $record['datetime'],
            'context' => $record['context'],
            'extra' => $record['extra'],
        ]);
    }
}