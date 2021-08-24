<?php
if(isset($_POST['username'])) {
    $return['error'] = true;
    include('db.con.php');
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = md5(mysqli_real_escape_string($con, $_POST['password']));

    if ( $username && $password ) {
    
        $sql = "SELECT id, user_type FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
        $run = mysqli_query($con, $sql);
        $res = mysqli_fetch_assoc($run);

        if( $res ) {
            $return['usertype'] = $res['user_type'];
            session_start();
            $_SESSION['user_id'] = $res['id'];
            $_SESSION['username'] = $username;
            $return['success'] = true;
            unset($return['error']);
            echo json_encode($return);
            return;
        } else { //of ($res)
            echo json_encode($return);
            return;
        }

    } else { //of if ($username && $password) ...
        echo json_encode($return);
        return;
    }
    
die();
}

include_once("main.template.php");

myheader("Login");
?>          
            <div class="container">
                 <!--Login-->
                 <div id="checkuser" class="alert alert-danger" role="alert" style="display:none;">
                    <i class="fa fa-exclamation-circle"></i>
                    &nbsp;&nbsp;Invalid Username/Password Combination!
                    <span href='#' class="pull-right fa fa-times"style="cursor: pointer;" onclick="$(this).parent().hide();"></span>
                </div>
                <div id="login" class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form" id="login" method="post" onsubmit="return false">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" id="username" type="text" autofocus required />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="password" type="password" required />
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" id="logbtn" class="btn btn-lg btn-primary btn-block" value="Login" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
                <script type="text/javascript">
                $("#logbtn").on('click', function(){
                    if($("form").valid()) {
                        var username = $("#username").val();
                        var password = $("#password").val();
                        $.ajax({
                            type:'POST',
                            data: { username: username, password: password },
                            success: function(response){
                                var json = JSON.parse(response);
                                if( json.success ) {
                                    console.log(json);
                                    window.location = json.usertype+'.php';
                                } else {
                                    $("#checkuser").show();
                                }
                            },
                            error: function() {
                                $("#error").show();
                            }
                        });
                    }
                });

                </script>