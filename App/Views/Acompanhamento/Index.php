
<div class="d-flex justify-content-between mb-4">
    <h3 class="text-center"><i class=""></i> Classificação</h3>
</div>

<?php foreach ($this->getViewVar()['acompanhamento'] as $index => $acompanhamento) { ?>
    <div class="accordion">
        <div class="card mb-3 custom-card">
            <div class="row g-0">
                <div class="col-md-2 text-center">
                    <div class="card-body text-center custom-card-body"> 
                        <?php if($acompanhamento['colocacao'] <= 20){?>
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <img src="<?= PATH_USERS_IMG . 'App/Views/Imagens/Medalhas/'. $acompanhamento['colocacao'] .'.png'?>" alt="" width="300" height="140" class="imagem-colocacao"> 
                            </div>
                        <?php }else{ ?>
                            <div class="card-body text-center custom-card-body"> 
                                <p class="colocacao-format"><?= $acompanhamento['colocacao']?>ª</p> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <img src="<?= PATH_USERS_IMG . $acompanhamento['caminho_imagem'] ?>" alt="Imagem" width="180" height="180" class="imagem-destaque"> 
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body text-center custom-card-body"> 
                        <h5 class="custom-card-body-title" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">Loja</h5>
                        <p class="custom-card-body-text"><?= $acompanhamento['filial']?></p>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="card-body text-center custom-card-body"> 
                        <h5 class="custom-card-body-title">Ouro</h5>
                        <p class="custom-card-body-text"><?= $acompanhamento['ouro']?></p>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="card-body text-center custom-card-body"> 
                        <h5 class="custom-card-body-title">Prata</h5>
                        <p class="custom-card-body-text"><?= $acompanhamento['prata']?></p>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="card-body text-center custom-card-body"> 
                        <h5 class="custom-card-body-title">Bronze</h5>
                        <p class="custom-card-body-text"><?= $acompanhamento['bronze']?></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body text-center custom-card-body"> 
                        <h5 class="custom-card-body-title">Score</h5>
                        <p class="custom-card-body-text"><?= $acompanhamento['score']?></p>
                    </div>
                </div>
            </div>
            <div id="collapse<?= $index ?>" class="collapse" aria-labelledby="heading<?= $index ?>" data-parent=".accordion">
                <div class="card-body">
                    <div class="table-responsive mt-2">
                        <table class="table table-hover" id="impressoesTable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Campanha</th>
                                    <th class="text-center align-middle">Filial</th>
                                    <th class="text-center align-middle">Ouro</th>
                                    <th class="text-center align-middle">Prata</th>
                                    <th class="text-center align-middle">Bronze</th>
                                    <th class="text-center align-middle">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->getViewVar()['acompanhamentoDetalhado'] as $detalhadoIndex => $acompanhamentoDetalhado) { ?>
                                    <?php if ($acompanhamentoDetalhado['idfilial'] === $acompanhamento['idfilial']) { ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['campanha_ref'] ?></td>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['filial'] ?></td>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['ouro'] ?></td>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['prata'] ?></td>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['bronze'] ?></td>
                                            <td class="text-center align-middle"><?= $acompanhamentoDetalhado['score'] ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    var cards = document.querySelectorAll('.custom-card');

    cards.forEach(function(card, index) {
        card.addEventListener('click', function() {
            var collapseId = "#collapse" + index;
            var collapse = document.querySelector(collapseId);
            if (collapse) {
                $(collapse).collapse('toggle');
            }
        });
    });
</script>


