<?php
namespace App\Interfaces;
interface RepositoryInterface {
public function findById(int $id): ?object;
public function findAll(): array;
public function save(object $entity): void;
public function delete(int $id): void;
}