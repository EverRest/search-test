<?php
class Genre_Model extends Model
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
     * get genre name by id
     * @param $id
     * @return mixed name
     */
    public function getName($id)
    {
        try {
            $sql = "SELECT id, name FROM genres WHERE id =  :id LIMIT 1";
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
     * get genres names
     * @return array names
     */
    public function getNames()
    {
        try {
            $sql = "SELECT id, name FROM genres ORDER BY name ASC";
            $sth = $this->db->prepare($sql);
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * get genre by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM genres WHERE id =  :id LIMIT 1";
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
     * get all genres
     * @return array genres
     */
    public function all()
    {
        try {
            $sth = $this->db->prepare('SELECT * FROM genres');
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
                echo 'Model error: ',  $e->getMessage(), "\n";
            }
    }
}
?>