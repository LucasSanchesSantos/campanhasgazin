<h3 class="text-center mb-4"><i class="bi bi-person-gear"></i> Usuário</h3>

<form action="<?= URL ?>usuario/editar" method="post" enctype="multipart/form-data">
    <input type="hidden" id="id" name="id" value=<?= !empty($_GET['id']) ? intval($_GET['id']) : intval($usuario['id']) ?>>

    <?php
        if ($isAdministrativo) {
    ?>
        <div class="mb-3">
            <label for="idFilial" class="form-label">ID Filial</label>
            <select class="form-select" id="idFilial" name="idFilial" required>
                <option value="<?= $this->viewVar['usuario']['id_filial'] ?>"><?= $this->viewVar['usuario']['filial'] ?></option>
                <?php
                    foreach ($this->viewVar['filiais'] as $filial) {
                ?>
                    <option value=<?= $filial['id_filial'] ?>>
                        <?= $filial['filial'] ?>
                    </option>
                <?php
                    }
                ?>
            </select>        
        </div>
    <?php
        }
    ?>

    <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $this->viewVar['usuario']['usuario'] ?>" required <?= $isAdministrativo ? '' : 'disabled' ?>>
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha" name="senha">
    </div>

    <?php
        if ($isAdministrativo) {
    ?>
        <div class="mb-3">
            <label for="idTipoPermissao" class="form-label">Permissão</label>
            <select class="form-select" id="idTipoPermissao" name="idTipoPermissao" required>
                <?php
                    foreach ($this->viewVar['tiposPermissao'] as $tipoPermissao) {
                ?>
                    <option value=<?= $tipoPermissao['id'] ?> <?= $this->viewVar['usuario']['id_tipo_permissao'] == $tipoPermissao['id'] ? 'selected' : '' ?>>
                        <?= $tipoPermissao['descricao'] ?>
                    </option>
                <?php
                    }
                ?>
            </select>
        </div>
    <?php
        }
    ?>

    <div class="mb-3">
        <p>
            <label for="" class="form-label">Selecione a sua melhor foto</label>
            <input type="file" class="form-control" name="imagem" id="imagem">
        </p>
    </div>

    
    <div class="text-end">
        <button type="submit" class="btn btn-primary bg-dark-blue">Salvar</button>
    </div>
</form>