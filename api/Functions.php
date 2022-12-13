<?php

function allUsers() {
  global $con;

  $users = $con->query("SELECT userid,CONCAT(firstname, ' ', lastname) AS fullname,username,email,role,date_inserted,status FROM tbl_users WHERE role = ? ORDER BY date_inserted DESC", 1);

  res_send($users->fetchAll());

  $con->close();
}

function deactivateUser() {
  global $con;

  $id = intval($_POST['id']);
  res_send($con->query("UPDATE tbl_users SET status = ? WHERE userid = ?", [ 3, $id ])->affectedRows());

  $con->close();
}

function activateUser() {
  global $con;

  $id = intval($_POST['id']);
  res_send($con->query("UPDATE tbl_users SET status = ?, counterlock = ? WHERE userid = ?", [ 1, 3, $id ])->affectedRows());

  $con->close();
}

function unlockUser() {
  global $con;

  $id = intval($_POST['id']);
  res_send($con->query("UPDATE tbl_users SET status = ?, counterlock = ? WHERE userid = ?", [ 1, 3, $id ])->affectedRows());

  $con->close();
}

function fetchUserData() {
  global $con;

  $account = $con->query("SELECT * FROM tbl_users WHERE userid = ?", intval($_POST['userid']));

  res_send($account->fetchArray());

  $con->close();
}

function updateProfile() {
  global $con;

  res_send($con->query("UPDATE tbl_users SET firstname=?,lastname=? WHERE userid=?", [ $_POST['firstname'], $_POST['lastname'], intval($_POST['userid']) ])->affectedRows());

  // session variables
  $_SESSION['user-data']['firstname'] = $_POST['firstname'];
  $_SESSION['user-data']['lastname'] = $_POST['lastname'];
  
  $con->close();
}

function changePassword() {
  global $con;

  $userid = intval($_SESSION['user-data']['id']);
  $oldPass = $_POST['oldPassword'];
  $newPass = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

  $current_pass = $con->query("SELECT password FROM tbl_users WHERE userid = ?", $userid)->fetchArray();

  if(password_verify($oldPass, $current_pass['password'])) {
    res_send($con->query("UPDATE tbl_users SET password = ? WHERE userid = ?", [ $newPass, $userid ])->affectedRows());
  } else {
    res_send(0);
  }

  $con->close();
}