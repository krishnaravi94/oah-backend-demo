<?php
class Database
{
    protected $connection = null;
    private $link = null;
    public $filter;
    static $inst = null;
    public static $counter = 0;
 
    public function log_db_errors( $error, $query )
    {
        $message = '<p>Error at '. date('Y-m-d H:i:s').':</p>';
        $message .= '<p>Query: '. htmlentities( $query ).'<br />';
        $message .= 'Error: ' . $error;
        $message .= '</p>';

        if( defined( 'SEND_ERRORS_TO' ) )
        {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // $headers .= 'To: Admin <'.SEND_ERRORS_TO.'>' . "\r\n";
            $headers .= 'From: Yoursite <system@'.$_SERVER['SERVER_NAME'].'.com>' . "\r\n";

            // mail( SEND_ERRORS_TO, 'Database Error', $message, $headers );   
        }
        else
        {
            trigger_error( $message );
        }

        if( !defined( 'DISPLAY_DEBUG' ) || ( defined( 'DISPLAY_DEBUG' ) && DISPLAY_DEBUG ) )
        {
            echo $message;   
        }
    }

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        //  echo('db connection successful');
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }
 
    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
 
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
 
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
 
            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }
 
            $stmt->execute();
 
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }   
    }
    public function insert( $table, $variables = array() )
    {
        self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }
        
        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            $values[] = "'".$value."'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        
        $sql .= $fields .' VALUES '. $values;
        $query = $this->connection->query( $sql );
        
        if( $this->connection->error )
        {
            //return false; 
            $this->log_db_errors( $this->connection->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }
}