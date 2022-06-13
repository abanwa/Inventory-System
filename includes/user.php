

<?php 


/**
 * User Class for account creation and Login purposes
 */
class User
{
	private $conn;

	function __construct()
	{
		include_once("../database/database.php");
		$db = new Database();
		$this->conn = $db->connect();

		// if ($this->conn){
		// 	echo "Connected";
		// }
	}

	// check whether user is already registered or not
	private function emailExists($email){
		$pre_stmt = $this->conn->prepare("SELECT id FROM user WHERE email = ? ");
		$pre_stmt->bind_param("s", $email);
		$pre_stmt->execute() or die($this->conn->error);
		$result = $pre_stmt->get_result();

		if ($result->num_rows > 0){
			return 1; // meanning that user is already registered
		} else {
			return 0; // meanning that user is  not registered
		}
	}

				// Create account ( EMAIL is our unique key in the sql database)
	public function createUserAccount($username,$email,$password,$usertype){
		// to protect your application from sql attack, you can use prepare statement

		if ($this->emailExists($email)){
			return "EMAIL_ALREADY_EXISTS";
		} else {
			$pass_hash = password_hash($password, PASSWORD_BCRYPT,["cost"=>8]); // hashing my password
			$date = date("Y-m-d h:m:s");
			$note = "";
			$pre_stmt = $this->conn->prepare("INSERT INTO `user`(`username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$pre_stmt->bind_param("sssssss", $username, $email, $pass_hash, $usertype, $date, $date, $note); 
			// date is the same here because the first registration and last login will be the same
			$result = $pre_stmt->execute() or die($this->conn->error);

			if ($result){
				return $this->conn->insert_id;
			} else {
				return "SOME_ERROR";
			}

		}
		
	}

					// User Login 

		public function userLogin($email, $password){
			$pre_stmt = $this->conn->prepare("SELECT id,username,password,last_login FROM user WHERE email = ?");
			$pre_stmt->bind_param("s", $email);
			$pre_stmt->execute() or die($this->conn->error);
			$result = $pre_stmt->get_result();

			if ($result->num_rows < 1){
				return "NOT_REGISTERD";
			} else {
				$row = $result->fetch_assoc();
				if (password_verify($password, $row["password"])){
					$_SESSION["userid"] = $row["id"];
					$_SESSION["username"] = $row["username"];
					$_SESSION["last_login"] = $row["last_login"];
					
					// Here we are updating last login time when he logins in
					$last_login = date("Y-m-d h:m:s");
					$pre_stmt = $this->conn->prepare("UPDATE user SET last_login = ? WHERE email = ?");
					$pre_stmt->bind_param("ss", $last_login, $email);
					$result = $pre_stmt->execute() or die($this->conn->error);

					if ($result){
						return "logged_in";
					} else {
						return "not_logged_in";
					}
				} else {
					return "PASSWORD_NOT_MATCHED";
				}
			}
		}



}


 //$user = new User();
 //$user->createUserAccount("joe","jo@gmail.com","0000","Admin");

 //echo $user->userLogin("jo@gmail.com","0000");
//echo $user->emailExists("chi@gmail.com");
// echo $_SESSION["username"];

//echo $user->__construct();




?>


