<?php
namespace App\Contracts;

interface UserContract {
    public function getUser($id);
    public function existsUser($id);
}
?>