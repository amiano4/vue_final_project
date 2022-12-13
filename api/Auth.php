<?php

function register() {
  global $con;
  
  $data = json_decode($_POST['data'], true);

  $usernameTaken = $con->query("SELECT * FROM tbl_users WHERE username = ?", $data['username'])->numRows() > 0;
  $emailTaken = $con->query("SELECT * FROM tbl_users WHERE email = ?", $data['email'])->numRows() > 0;
  
  if($usernameTaken && $emailTaken) {
    res_send([ 'status' => 4 ]);
  }
  else if($usernameTaken) {
    res_send([ 'status' => 2 ]);
  }
  else if($emailTaken) {
    res_send([ 'status' => 3 ]);
  }
  else {
    if(strcmp($data['password'], $data['password_confirmation']) == 0) {
      if($con->query(
        "INSERT INTO tbl_users (firstname,lastname,email,username,password,role,counterlock,status,date_inserted) VALUES (?,?,?,?,?,?,?,?,?)",
        [
          $data['firstname'],
          $data['lastname'],
          $data['email'],
          $data['username'],
          password_hash($data['password'], PASSWORD_DEFAULT),
          1, // role
          3, // counterlock
          1, // status
          date('Y-m-d')
        ]
      )->affectedRows() == 1) {
        res_send([ 'status' => 1 ]);
      }
    }
  }
  
  $con->close();
}

function login() {
  global $con;

  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $account = $con->query("SELECT * FROM tbl_users WHERE username = ? OR email = ?", [ $user, $user ])->fetchArray();

  /**
   * account status:
   * 0 = deleted
   * 1 = active
   * 2 = locked
   * 3 = banned (by the admin)
   * 
   * return status code: (ajax req)
   * 0 = email/user do not exist
   * 1 = ok
   * 2 = invalid pass
   * 3 = account locked
   * 4 = account banned
   */

  if(sizeof($account) == 0) {
    res_send([
      'status' => 0,
      'message' => 'Email/Username does not exist'
    ]);
  } else {
    if(password_verify($pass, $account['password'])) {
      if($account['status'] == 2) {
        // locked account
        res_send([
          'status' => 3,
          'message' => "This user account has been locked!"
        ]);
      } else if($account['status'] == 3) {
        // banned account
        res_send([
          'status' => 4,
          'message' => "Your account has been deactivated by the administrator"
        ]);
      } else if($account['status'] == 1) {
        // successful login
        res_send([ 'status' => 1 ]);

        // session variables
        $_SESSION['user-data'] = array( 
          'id' => $account['userid'], 
          'role' => $account['role'],
          'firstname' => $account['firstname'],
          'lastname' => $account['lastname'],
        );

        // reset counterlock
        $con->query("UPDATE tbl_users SET counterlock = ? WHERE userid = ?", [ 3, $account['userid'] ]);
      }
    } else {
      if($account['role'] != 0 && $account['status'] != 3) {
        if($account['counterlock'] <= 0) {
          // incorrect password, but locked account
          res_send([
            'status' => 3,
            'message' => "Your account has been locked!",
            'incorrect-password' => true
          ]);
        } else {
          // user inputs incorrect password
          res_send([
            'status' => 2,
            'message' => "Password is incorrect"
          ]);
    
          if($account['counterlock'] - 1 == 0) {
            // lock account if login fail attemps reach the maximum
            $con->query("UPDATE tbl_users SET counterlock = ?, status = ? WHERE userid = ?", [ 0, 2, $account['userid'] ]);
          }
          else {
            // update counterlock (decrement by one)
            $con->query("UPDATE tbl_users SET counterlock = ? WHERE userid = ?", [ $account['counterlock'] - 1, $account['userid'] ]);
          }
        }
      } else { // if admin login, no counterlocking
        res_send([
          'status' => 2,
          'message' => "Password is incorrect"
        ]);
      }
    }
  }

  $con->close();
}

function logout() {
  $_SESSION = array();
  
  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }

  // Finally, destroy the session.
  session_destroy();

  if(isset($_POST['redirect'])) {
    header("location: .{$_POST['redirect']}");
    exit();
  }
}