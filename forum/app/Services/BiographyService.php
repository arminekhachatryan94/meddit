<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\BiographyContract;
use App\Biography;
use Validator;

class BiographyService implements BiographyContract {

    public function getBiography(int $user_id): Biography {
        return Biography::where('user_id', $user_id)->first();
    }

    public function saveBiography(Biography $bio, string $description): bool {
        $bio->description = $description;
        return $bio->save();
    }
}
?>