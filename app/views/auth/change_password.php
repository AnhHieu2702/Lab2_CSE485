<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
<h2>Change Password</h2>
<form method="POST" action="<?= APP_ROOT ?>/tlunews/public/index.php?action=change">
    <label>New Password:</label>
    <input type="password" name="new_password" required>
    <button type="submit">Change Password</button>
</form>
</body>
</html>
