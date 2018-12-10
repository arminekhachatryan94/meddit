<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use App\Biography;

interface BiographyContract {
    public function createBiography(int $user_id): Biography;
    public function getBiography(int $user_id): Biography;
    public function saveBiography(Biography $bio, string $description): bool;
}
?>