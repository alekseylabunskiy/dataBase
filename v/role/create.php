<div class="col-md-12 text-left height90">
    <h2>Створити нову роль</h2>
</div>
<form action="/index.php?c=role&a=create" method="post" role="form">
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
