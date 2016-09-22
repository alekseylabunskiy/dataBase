<div class="row marg">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/index.php?c=user&a=login" method="post" role="form">
                    <div class="form-group">
                        <input id="u_email" type="text" name="u_mail" class="form-control" placeholder="Email Address">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <input id="u_password" type="password" name="u_password" class="form-control"
                               placeholder="Password">
                        <p class="help-block"></p>
                    </div>
                    <div class="col-lg-offset-2">
                            <span class="col-lg-10">
                                <button id="login_btn" class="btn btn-info btn-block" type="submit"
                                        name="send">login</button>
                            </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>