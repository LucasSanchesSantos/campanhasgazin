<div class="d-flex justify-content-between mb-4">
    <h3 class="text-center"><i class="bi bi-printer"></i> Quantidade de impressões por promoção</h3>
</div>

<button type="button" class="btn btn-dark-blue me-1" data-bs-toggle="modal" data-bs-target="#modalFiltro">
    Filtros
</button>

<div class="modal fade" id="modalFiltro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark-blue text-white">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Filtros</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="<?= URL ?>impressoes/filtrarRelatorioQuantidade" method="post">
                <div class="mb-4">
                    <label class="form-label" for="idFilial">Filiais</label>
                    <select class="form-control selectpicker" id="idFilial" title="Selecione" name="idFilial" data-live-search="true">
                        <option value="">Selecione</option>
                        <?php foreach ($this->viewVar['filiais'] as $idFilial) { ?>
                            <option value="<?= $idFilial['id'] ?>"><?= $idFilial['filial']?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label" for="idProduto">Código produto</label>
                    <select class="form-control selectpicker" id="idProduto" title="Selecione" name="idProduto" data-live-search="true">
                        <option value="">Selecione</option>
                        <?php foreach ($this->viewVar['produtos'] as $idProduto) { ?>
                            <option value="<?= $idProduto['id_produto'] ?>"><?= $idProduto['id_produto'].' - '.$idProduto['produto']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="data_inicio">Data de Início</label>
                        <input type="date" class="form-control" id="dataInicio" name="dataInicio">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="data_fim">Data de Fim</label>
                        <input type="date" class="form-control" id="dataFim" name="dataFim">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-dark-blue">Filtrar</button>
                </div>
            </form>
      </div>
      
    </div>
  </div>
</div>

<div class="table-responsive mt-2">
    <table class="table table-hover" id="impressoesTable">
        <thead>
            <tr>
                <th class="text-center align-middle">Promoção</th>
                <th class="text-center align-middle">Filial</th>
                <th class="text-center align-middle">Quantidade de impressões</th>
                <th class="text-center align-middle">Data impressão</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->getViewVar()['impressoes'] as $impressoes) { ?>
                <tr>
                    <td class="text-center align-middle"><?= $impressoes['promocao'] ?></td>
                    <td class="text-center align-middle"><?= $impressoes['filial'] ?></td>
                    <td class="text-center align-middle"><?= $impressoes['quantidade_impressoes'] ?></td>
                    <td class="text-center align-middle"><?= date('d/m/Y', strtotime($impressoes['data_impressao'])) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>