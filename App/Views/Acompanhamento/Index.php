
<div class="d-flex justify-content-between mb-4">
    <h3 class="text-center"><i class=""></i> Classificações</h3>
</div>

<?php foreach ($this->getViewVar()['acompanhamento'] as $acompanhamento) { ?>
    <div class="card mb-3 custom-card"> <!-- Adicionando a classe customizada para o card -->
        <div class="row g-0">
            <div class="col-md-2 text-center ">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Colocação</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['colocacao']?>ª</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <img src="<?= PATH_USERS_IMG . $acompanhamento['caminho_imagem'] ?>" alt="Imagem" width="180" height="180" class="imagem-destaque"> <!-- Adicionando classe img-fluid para garantir a responsividade -->
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Loja</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['filial']?></p>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Ouro</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['ouro']?></p>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Prata</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['prata']?></p>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Bronze</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['bronze']?></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body text-center custom-card-body"> <!-- Adicionando a classe customizada para o corpo do card -->
                    <h5 class="custom-card-body-title">Score</h5>
                    <p class="custom-card-body-text"><?= $acompanhamento['score']?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
