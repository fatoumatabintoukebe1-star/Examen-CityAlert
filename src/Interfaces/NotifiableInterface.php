<?php
namespace App\Interfaces;
interface NotifiableInterface {
public function notify(string $message): void;
public function getEmail(): string;
}