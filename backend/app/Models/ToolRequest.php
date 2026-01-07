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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
