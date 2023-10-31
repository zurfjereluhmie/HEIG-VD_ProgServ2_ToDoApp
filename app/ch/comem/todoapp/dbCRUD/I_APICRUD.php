<?php

namespace ch\comem\todoapp\dbCRUD;

/**
 * Interface for API CRUD operations.
 * 
 * @package ch\comem\todoapp\dbCRUD
 */
interface I_APICRUD
{
    /**
     * Creates a new record in the database.
     *
     * @param object $object The object to create.
     * @return int The ID of the newly created record. Returns 0 if the creation failed.
     */
    public function create(object $object): int;

    /**
     * Reads a single record from the database based on its ID.
     *
     * @param int $id The ID of the record to read.
     * @return object|null The record read from the database, or null if it was not found.
     */
    public function read(int $id): ?object;

    /**
     * Updates an record in the database based on its database ID.
     *
     * @param int $id The ID of the record to update.
     * @param object $object The record to update.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(int $id, object $object): bool;

    /**
     * Deletes a record from the database based on its ID.
     *
     * @param int $id The ID of the record to delete.
     * @return bool True if the record was successfully deleted, false otherwise.
     */
    public function delete(int $id): bool;
}
