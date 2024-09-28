<?php

namespace App\Models\Attribute;

use App\Models\Attribute\Traits\Relationships\AttributeRelationships;
use App\Models\Attribute\Traits\Scopes\AttributeScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory,
        AttributeRelationships, AttributeScopes;
        protected $table = 'attribute';
        protected $fillable = [
            'name',
            'slug',
            'status',
        ];
        protected $casts = [
            'status' => 'int',
            'created_by' => 'int',
            'edited_by ' => 'int',
        ];
        public $timestamps = true;

        protected $dates = [
            'created_at',
            'updated_at',
        ];
        protected $fakeColumns = [];
}
