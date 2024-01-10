</div>

<div class="modal fade" id="retornoCadastroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <?php if($sucesso && !$erro) { ?>
                    <div class="alert alert-success m-0" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <span id="sucesso"><?= $sucesso ?></span>
                    </div>
                <?php } ?>

                <?php if($erro && !$sucesso) { ?>
                    <div class="alert alert-danger m-0" role="alert">
                        <i class="bi bi-x-circle-fill"></i>
                        <span id="erro"><?= $erro ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="loading" class="text-center d-none">
    <div class="spinner-border text-dark-blue" role="status">
      <span class="visually-hidden">Carregando...</span>
    </div>
    <div class="text-white">Carregando...</div>
</div>

<div id="blackScreen"></div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="<?= PATH_JS ?>Componentes/Rodape.js"></script>
<script src="<?= PATH_JS ?>Componentes/Tabela.js"></script>
<script src="<?= PATH_JS ?>Componentes/Modal.js"></script>

<?php if ($this->getViewVar()['nameController'] === 'ImpressaoController' && (empty($this->getViewVar()['nameAction']) || $this->getViewVar()['nameAction'] == 'index')) { ?>
    <script src="<?= PATH_JS ?>Impressao/Index.js"></script>
<?php } ?>

<?php if ($this->getViewVar()['nameController'] === 'ImpressaoController' && $view == 'impressao/a4') { ?>
    <script src="<?= PATH_JS ?>Impressao/A4.js"></script>
<?php } ?>

<?php if ($this->getViewVar()['nameController'] === 'ImpressaoPersonalizadaController' && (empty($this->getViewVar()['nameAction']) || $this->getViewVar()['nameAction'] == 'index')) { ?>
    <script src="<?= PATH_JS ?>ImpressaoPersonalizada/Index.js"></script>
<?php } ?>