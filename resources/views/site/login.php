<div class="container col-md-3 mt-5">
    <?php
    if ($data->error) : ?>
        <div class="alert alert-danger" role="alert">
            Ocorreu um erro a submeter os dados, por favor verifique novamente!
        </div>
    <?php
    endif; ?>
    <form id="login" class="row g-3 needs-validation" action="/Site/doLogin" method="POST"
          enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <div class="form-group mb-2">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                   placeholder="Enter email" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please enter a valid email.
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                   placeholder="Password" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>