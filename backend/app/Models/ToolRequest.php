<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolRequest extends Model
{
    protected $fillable = [
        'user_id',
        'tool_id',
        'input_data',
        'output_data',
        'status',
        'conversation_id',
        'role',
    ];

    protected $casts = [
        'input_data' => 'array',
        'output_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
