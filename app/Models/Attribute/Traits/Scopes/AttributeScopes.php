<?php

namespace App\Models\Attribute\Traits\Scopes;

/**
 * Trait ModifierScopes
 */
trait AttributeScopes
{
    public function scopeOwner($query)
    {
        if (auth()->user()) {
            $query->where('created_by', auth()->user()->id);
        }
    }
}
