<!doctype html>
<html>
<head>
    <title>Import CSV Data from url to MySQL database with Laravel</title>
</head>
<body>

<h1>Click to get the newest data from WHO</h1>
<!-- Form -->
<form method='post' action='/uploadFile' enctype='multipart/form-data' >
    {{ csrf_field() }}
    <input type='submit' name='submit' value='Import'>
</form>
</body>
</html>
