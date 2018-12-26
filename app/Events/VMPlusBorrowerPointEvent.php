<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VMPlusBorrowerPointEvent{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $borrower_id;
    public $plus_type;
    public $point = 0;

    /**
     * Create a new event instance.
     * @param $borrower_id
     * @param $plus_type
     * @param int $bonus
     */
    public function __construct($borrower_id, $plus_type, $point = 0){
        $this->borrower_id = $borrower_id;
        $this->plus_type = $plus_type;
        $this->point = $point;
    }
}