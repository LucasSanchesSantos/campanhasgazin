<section class="vh-100 bg-light">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow">
                    <form class="w-100" action="<?= URL ?>login/logar" method="post">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <img src="<?= PATH_IMG ?>cartazeando.png" width="70%" alt="">
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="login"><b>Login</b></label>
                                <input type="text" id="login" name="login" class="form-control form-control-lg" required/>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="senha"><b>Senha</b></label>
                                <input type="password" id="senha" name="senha" class="form-control form-control-lg" required/>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit"><b>Entrar</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>