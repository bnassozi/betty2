<?php
class Product{
  
    // database connection and table name
    private $conn;
    private $table_name = "products";
  
    // object properties
    public $id;
    public $name;
    public $email;
    public $phone_no;
    public $category_id;
    public $category_name;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }
	// read cv
function read(){
  
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.email, p.phone_no, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
  
    return $stmt;
}
// create cv
function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, phone_no=:phone_no, email=:email, category_id=:category_id, created=:created";
  
    $stmt = $this->conn->prepare($query);
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->phone_no=htmlspecialchars(strip_tags($this->phone_no));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone_no", $this->phone_no);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
  
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
function readOne(){
  
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.email, p.phone_no, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
  
    $stmt = $this->conn->prepare( $query );
  
    $stmt->bindParam(1, $this->id);
  
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->name = $row['name'];
    $this->phone_no = $row['phone_no'];
    $this->email = $row['email'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}



}
?>
