<?php
class Author_Model extends Model
{
    protected $title;
    protected $author_id;
    protected $genre_id;
    protected $photo;
    protected $language;
    protected $date;
    protected $isbn;

    /**
     * Book_Model constructor.
     * return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get name by id
     * @param $id
     * @return mixed book
     */
    public function getName($id)
    {
        try {
            $sql = "SELECT id, name FROM authors WHERE id =  :id LIMIT 1";
            $sth = $this->db->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->fetch();
        }
        catch (Exception $e) {
            echo 'Model getName error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * get names
     * @return array names
     */
    public function getNames()
    {
        try {
            $sql = "SELECT id, name FROM authors ORDER BY name ASC";
            $sth = $this->db->prepare($sql);
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model getNames error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * get author by id
     * @param $id
     * @return mixed author
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM authors WHERE id =  :id LIMIT 1";
            $sth = $this->db->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->fetch();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * get all authors
     * @return array authors
     */
    public function all()
    {
        try {
            $sth = $this->db->prepare('SELECT * FROM authors');
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }
}
?>