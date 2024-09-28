<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    protected $guarded = ['id'];
    protected $table = "support_attachments";

    public function supportMessage()
    {
        return $this->belongsTo(SupportMessage::class,'support_message_id');
    }
}
