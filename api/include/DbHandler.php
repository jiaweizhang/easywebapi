<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Jiawei Zhang
 */
class DbHandler
{

    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function addxml($xml, $author, $gamename, $description)
    {
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d');
        $stmt = $this->conn->prepare("INSERT into xmls(author, xml, gamename, description, date) values (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $author, $xml, $gamename, $description, $date);
        $result = $stmt->execute();
        //$last_id = mysql_insert_id();
        if ($result) {
            return $stmt->insert_id;
        }
        return 0;
    }

    public function getxml($id) {
        $stmt = $this->conn->prepare("SELECT id, author, xml, gamename, description, date FROM xmls WHERE id=?");
        $stmt->bind_param("s", $id);

        $stmt->execute();


        $id = null;
        $author = null;
        $xml = null;
        $gamename = null;
        $description = null;
        $date = null;
        $stmt->bind_result($id, $author, $xml, $gamename, $description, $date);

        while ($stmt->fetch()) {
            $stmt->close();
            return array(
                "id" => $id,
                "author" => $author,
                "xml" => $xml,
                "gamename" => $gamename,
                "description" => $description,
                "date" => $date
            );
        }
    }

    public function getxmls()
    {
        $stmt = $this->conn->prepare("SELECT id, author, gamename, description, date FROM xmls ORDER BY id DESC");

        $stmt->execute();
        $id = null;
        $author = null;
        $gamename = null;
        $description = null;
        $date = null;
        $stmt->bind_result($id, $author, $gamename, $description, $date);

        $menu = array();
        while ($stmt->fetch()) {
            $menu[] = array(
                "id" => $id,
                "author" => $author,
                "gamename" => $gamename,
                "description" => $description,
                "date" => $date
            );
        }
        $stmt->close();

        $question_result['xmls'] = $menu;
        return $question_result;
    }

    public function deletexml($id) {
        $stmt = $this->conn->prepare("DELETE FROM xmls WHERE id=?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        if ($result) {
            return 1;
        }
        return 0;
    }

    public function addcomment($id, $author, $comment) {
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $stmt = $this->conn->prepare("INSERT into comments(id, author, comment, date, time) values (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $id, $author, $comment, $date, $time);
        $result = $stmt->execute();
        if ($result) {
            return 1;
        }
        return 0;
    }

    public function getcomment($id) {
        if ($stmt = $this->conn->prepare("SELECT author, comment, date, time FROM comments WHERE id=? ORDER BY commentid DESC")) {

            $stmt->bind_param("s", $id);

            $stmt->execute();

            $author = null;
            $comment = null;
            $date = null;
            $time = null;
            $stmt->bind_result($author, $comment, $date, $time);

            $menu = array();
            while ($stmt->fetch()) {
                $menu[] = array(
                    "id" => $id,
                    "author" => $author,
                    "comment" => $comment,
                    "date" => $date,
                    "time" => $time
                );
            }
            $stmt->close();
            $question_result['comments'] = $menu;
            return $question_result;
        }
    }
}

?>
