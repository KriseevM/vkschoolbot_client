<html>
    <head>
        <meta charset="utf-8"/>
        <title>vkschoolbot client</title>
        <script src="js/jquery.min.js"></script>
        <script src="js/config.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <script>
            var loginform = $('<div id="login">\
                <form method="POST" id="loginform">\
                    <h1 class="form-header">Вход</h1>\
                    <h4 class="error_msg">Вы не ввели данные для входа!</h4>\
                    <input type="text" name="user" id="user" required class="input_text user" placeholder="Имя пользователя"/>\
                    <input type="password" name="pass" id="pass" required class="input_text pass" placeholder="Пароль"/>\
                    <input type="submit" id="auth" value="Войти">\
                </form>\
            </div>');
            var contentwrap = $('<div id="left-panel-wrap">\
                                    <ul id="menu">\
                                        <li act="homework">ДЗ</li>\
                                        <li act="changes">Замены</li>\
                                        <li act="timetable">Расписание</li>\
                                    </ul>\
                                </div>\
                                <div id="maincontent"></div>');
            
            var key = "";
            loginform.find('#auth').click(function(e)
            {
                e.preventDefault();
                var user = $('#user')[0].value;
                var pass = $('#pass')[0].value;
                if(user.search(/^[\w]+$/) !== 0)
                {
                    $('.error_msg').slideUp(500, function() {
                        $('.error_msg')[0].innerHTML = "Введите имя пользователя";
                        $('.error_msg').slideDown(500);
                    });
                    
                }
                else if(pass.length < 4)
                {
                    $('.error_msg').slideUp(500, function()
                    {
                        $('.error_msg')[0].innerHTML = "Пароль должен быть не короче 4 символов";
                        $('.error_msg').slideDown(500);
                    });
                    
                }
                else
                {
                    $('.error_msg').slideUp(500);
                    $.ajax({
                        url: apiurl + "/auth.php",
                        data: {
                            user: user,
                            pass: pass
                        },
                        type: "post",
                        contentType: "application/x-www-form-urlencoded",
                        dataType: "json",
                        success: function(data) {
                            if(data.hasOwnProperty("key"))
                            {
                                key = data.key;
                                loginform.slideUp();
                                loginform.detach();
                                contentwrap.fadeOut(0);
                                $('body').append(contentwrap);
                                contentwrap.fadeIn(500);
                            }
                            else if(data.hasOwnProperty("error"))
                            {
                                $('.error_msg').slideUp(500, function()
                                {
                                    $('.error_msg')[0].innerHTML = data.error;
                                    $('.error_msg').slideDown(500);
                                });
                            }
                        }
                    });
                }
            });
            loginform.hide();
            $('body').append(loginform);
            loginform.fadeIn(500);
            
            
        </script>
    </body>
</html>