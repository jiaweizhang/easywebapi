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

    public function addxml($xml, $author)
    {
        $stmt = $this->conn->prepare("INSERT into xmls(author, xml) values (?, ?)");
        $stmt->bind_param("ss", $author, $xml);
        $result = $stmt->execute();
        if ($result) {
            return 1;
        }
        return $xml;
    }

    public function getxml()
    {
        $stmt = $this->conn->prepare("SELECT id, author, xml FROM xmls");

        $stmt->execute();
        $id = null;
        $author = null;
        $xml = null;
        $stmt->bind_result($id, $author, $xml);

        $menu = array();
        while ($stmt->fetch()) {
            $menu[] = array(
                "id" => $id,
                "author" => $author,
                "xml" => $xml
            );
        }
        $stmt->close();

        $question_result['xmls'] = $menu;
        return $question_result;
    }
}

?>
