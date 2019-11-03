<?php


namespace App\Model;

class CharacterManager extends AbstractManager
{
    const TABLE = 'characters';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $character
     * @return int
     */
    public function insert(array $character): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO $this->table (`name`, `state`, `description`, `picture`) 
            VALUES (:name, :state, :description, :picture)"
        );
        $statement->bindValue('name', $character['name'], \PDO::PARAM_STR);
        $statement->bindValue('state', $character['state'], \PDO::PARAM_STR);
        $statement->bindValue('description', $character['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $character['picture'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param array $character
     * @return bool
     */
    public function update(array $character):bool
    {
        // prepared request
        $query = "UPDATE ". self::TABLE .
            " SET name = :name, state = :state, description = :description, picture = :picture WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $character['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $character['name'], \PDO::PARAM_STR);
        $statement->bindValue('state', $character['state'], \PDO::PARAM_STR);
        $statement->bindValue('description', $character['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $character['picture'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
