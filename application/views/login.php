<html>
    <head>
        <title>Login</title>
	<base href="/" />
        <style type="text/css">
            body {font-family: Georgia;}
            h1 {font-style: italic;}
 
        </style>
    </head>
    <body>
        <p>Login!</p>
        <form action="auth/login" method='POST'>
            username: <input type="text" name="username"><br>
            password: <input type="password" name="password"><br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
