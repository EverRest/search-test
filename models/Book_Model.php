<?php
class Book_Model extends Model
{
    protected  $id;
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
     * add new book
     * @param array $book
     * return void
     */
    public function insert($book = array())
    {
        $this->title = !empty($book['title'])? $book['title'] : NULL;
        $this->author_id = !empty($book['author'])? $book['author'] : 0;
        $this->genre_id = !empty($book['genre'])? $book['genre'] : 0;
        $this->photo = !empty($book['photo'])? $book['photo'] : NULL;
        $this->language = !empty($book['lang'])? $book['lang'] : NULL;
        $this->date = !empty($book['date'])? $book['date'] : 0;
        $this->isbn = !empty($book['isbn'])? $book['isbn'] : NULL;

        try {
            $sql = "INSERT INTO books(
            author_id, genre_id, title, photo, language, year, code
            ) VALUES (
            :author, :genre, :title, :photo,  :language, :year, :isbn
            )";

            $sth = $this->db->prepare($sql);

            $sth->bindParam(':author', $this->author_id, PDO::PARAM_INT);
            $sth->bindParam(':genre', $this->genre_id, PDO::PARAM_INT);
            $sth->bindParam(':title', $this->title, PDO::PARAM_STR);
            $sth->bindParam(':language', $this->language, PDO::PARAM_STR);
            $sth->bindParam(':photo', $this->photo, PDO::PARAM_STR);
            $sth->bindParam(':year', $this->date, PDO::PARAM_INT);
            $sth->bindParam(':isbn', $this->isbn, PDO::PARAM_STR);

            $sth->execute();
        } catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }

    }

    /**
     * update book
     * @param array $book
     * return void
     */
    public function update($book = array())
    {

        $this->title = !empty($book['title'])? $book['title'] : NULL;
        $this->author_id = !empty($book['author'])? $book['author'] : $book['author_id'];
        $this->genre_id = !empty($book['genre'])? $book['genre'] : $book['genre_id'];
        $this->photo = !empty($book['photo'])? $book['photo'] : false;
        $this->language = !empty($book['lang'])? $book['lang'] : NULL;
        $this->date = !empty($book['date'])? $book['date'] : 0;
        $this->isbn = !empty($book['isbn'])? $book['isbn'] : NULL;
        $this->id = !empty($book['book_id'])? $book['book_id'] : $book['id'];

        try {
            if (!empty($book['photo'])) {
                $stmt =
//                    'author_id = :author,' .
//                        'genre_id = :genre, ' .
                        'title = :title, ' .
                        'photo = :photo,' .
                        'language = :language, ' .
                        ' year = :year, ' .
                        'code = :isbn, ';
            } else {
                $stmt =
//                    'author_id = :author, ' .
//                        'genre_id = :genre, ' .
                        'title = :title, ' .
                        'language = :language, ' .
                        'year = :year, ' .
                        'code = :isbn ';
            }

            $sql = "UPDATE books SET  {$stmt}  WHERE id = :book_id LIMIT 1";

            $sth = $this->db->prepare($sql);

//            $sth->bindParam(':author', $this->author_id, PDO::PARAM_INT);
//            $sth->bindParam(':genre', $this->genre_id, PDO::PARAM_INT);
            $sth->bindParam(':title', $this->title, PDO::PARAM_STR);
            $sth->bindParam(':language', $this->language, PDO::PARAM_STR);
            if (!empty($book['photo'])) $sth->bindParam(':photo', $this->photo, PDO::PARAM_STR);
            $sth->bindParam(':year', $this->date, PDO::PARAM_INT);
            $sth->bindParam(':isbn', $this->isbn, PDO::PARAM_STR);
            $sth->bindParam(':book_id', $this->id, PDO::PARAM_INT);

//            die($sql);


//            echo '<pre>';print_r($this);exit;
            $sth->execute();
        } catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }

    }

    /**
     * get book by id
     * @param integer $id
     * @return mixed book by id
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM books WHERE id =  :id LIMIT 1";
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
     * get all books
     * @return array books
     */
    public function all()
    {
        try {
            $sth = $this->db->prepare('SELECT * FROM books ORDER BY title ASC LIMIT 3');
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * sort
     * @param $type
     * @return array books
     */
    public function sortByTitle($type = ASC)
    {
        try {
            $sth = $this->db->prepare('SELECT * FROM books ORDER BY title ' . $type . ' LIMIT 3');
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * search by str
     * @param $str
     * @return array books
     */
    public function search($str)
    {
        try {
            $str = '%' . $str . '%';
            $sth = $this->db->prepare('SELECT * FROM books WHERE title LIKE :str ORDER BY title ASC');
            $sth->bindParam(':str', $str, PDO::PARAM_STR);
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Count all books
     * @return int count
     */
    public function countBooks()
    {
        try {
            $sth = $this->db->prepare('SELECT COUNT(id) FROM books');
            $sth->execute();
            return $sth->fetch();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }


    /**
     * paginate books
     * @param int $offset
     * @return array books
     */
    public function paginate($offset = 0)
    {

        try {
            $sth = $this->db->prepare('SELECT * FROM books ORDER BY title ASC LIMIT 3 OFFSET :offset');
            $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }
}
?>