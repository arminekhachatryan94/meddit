
<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Account Deletion</title>
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
                <h1>Account Deletion</h1>
                <h3>Your account was successfully deleted by an admin!</h3>
                <div>We hope you enjoyed using MEAT Labs, {{$user->first_name}}.</div>
            </main>
            <footer>
                <div><i>MEATLabs</i> &copy; 2018</div>
            </footer>
        </body>
        </html>