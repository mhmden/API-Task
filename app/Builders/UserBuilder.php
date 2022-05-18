<?php
namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder {

    // Two Methods -> BannedUsers / Active Users

    public function banned (): self {
        return $this->whereNotNull('banned_at');
    }

    public function active (): self {
        return $this->whereNull('banned_at');
    }

}