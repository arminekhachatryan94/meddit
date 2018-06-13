
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <style>
        body {
            background-color: rgb(255, 241, 230);
            text-align: center;
        }
        
        h1 {
            color: lightcoral;
        }

        footer {
            position: absolute;
            bottom: 0px;
            left: 350px;
            color: indianred;
        }
    </style>        
</head>
<body>
    <main>
        <h1>Welcome to MEAT Labs!</h1>
        <h3>Thank you for registering, {{$user->first_name}}</h3>
        <div>We hope you enjoy the experience.</div>
    </main>
    <footer>
        <div><i>MEATLabs</i> &copy; 2018</div>
    </footer>
</body>
</html>