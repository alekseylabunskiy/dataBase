<div class="panel panel-default">
    <div class="panel-body text-center">
        <h3>Створити нову роль</h3>
    </div>
</div>
<div class="row">
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Створити Роль</h3>
            </div>
            <div class="panel-body">
                <form action="/index.php?c=roles" method="post" role="form">
                    <div class="form-group">
                        <label for="name_new_role">Ім'я нової Ролі</label>
                        <input class="form-control" type="text" name="name_new_role" title="Нова роль">
                    </div>
                    <div class="form-group">
                        <label for="description_new_role">Опис нової Ролі</label>
                        <input class="form-control" type="text" name="description_new_role" title="Опис">
                    </div>
                    <button class="btn btn-info" type="submit" name="create_new_role">Створити</button>
                </form>
            </div>
        </div>
    </div>
</div>