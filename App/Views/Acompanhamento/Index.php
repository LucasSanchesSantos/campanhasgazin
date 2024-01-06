<div class="d-flex justify-content-between mb-4">
    <h3 class="text-center"><i class="bi bi-printer"></i> Quantidade de impressões por filial</h3>
</div>

<div class="table-responsive mt-2">
    <table class="table table-hover" id="acompanhamentoTable">
        <thead>
            <tr>
                <th class="text-center align-middle">Colocação</th>
                <th class="text-center align-middle">Gerente</th>
                <th class="text-center align-middle">Filial</th>
                <th class="text-center align-middle">Ouro</th>
                <th class="text-center align-middle">Prata</th>
                <th class="text-center align-middle">Bronze</th>
                <th class="text-center align-middle">Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->getViewVar()['acompanhamento'] as $acompanhamento) { ?>
                <tr>
                    <td class="text-center align-middle"><?= $acompanhamento['colocacao']?></td>
                    <td class="text-center align-middle">
                        <img src="<?= PATH_USERS_IMG . $acompanhamento['caminho_imagem'] ?>" alt="Imagem" width="50" height="50">
                    </td>
                    <td class="text-center align-middle"><?= $acompanhamento['filial']?></td>
                    <td class="text-center align-middle"><?= $acompanhamento['ouro']?></td>
                    <td class="text-center align-middle"><?= $acompanhamento['prata']?></td>
                    <td class="text-center align-middle"><?= $acompanhamento['bronze']?></td>
                    <td class="text-center align-middle"><?= $acompanhamento['score']?></td>
                   
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>