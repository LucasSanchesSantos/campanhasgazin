<h3 class="text-center mb-4"><i class="bi bi-person-add"></i> Usuário</h3>

<form action="<?= URL ?>usuario/cadastrar" method="post">
    <div class="mb-3">
        <label for="idFilial" class="form-label">ID Filial</label>
        <select class="form-select" id="idFilial" name="idFilial" required>
            <option value=0>Selecione</option>
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
    <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha" name="senha" required>
        <small class="form-text text-muted">
            A senha deve conter pelo menos 8 caracteres, incluindo pelo menos uma letra maiúscula e uma letra minúscula.
        </small>
    </div>
    <div class="mb-3">
        <label for="idTipoPermissao" class="form-label">Permissão</label>
        <select class="form-select" id="idTipoPermissao" name="idTipoPermissao" required>
            <option value=0>Selecione</option>

            <?php
                foreach ($this->viewVar['tiposPermissao'] as $tipoPermissao) {
            ?>
                <option value=<?= $tipoPermissao['id'] ?>>
                    <?= $tipoPermissao['descricao'] ?>
                </option>
            <?php
                }
            ?>
        </select>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary bg-dark-blue">Salvar</button>
    </div>
</form>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");

        form.addEventListener("submit", function(event) {
            const passwordInput = document.getElementById("senha");
            const password = passwordInput.value;

            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);

            if (password.length < 8 || !hasUppercase || !hasLowercase) {
                let message = "A senha deve conter:\n";
                if (password.length < 8) {
                    message += "- Pelo menos 8 caracteres\n";
                }
                if (!hasUppercase) {
                    message += "- Pelo menos uma letra maiúscula\n";
                }
                if (!hasLowercase) {
                    message += "- Pelo menos uma letra minúscula\n";
                }

                message = message.replace(/\n/g, "<br>");

                // Exibindo a mensagem de alerta em um modal Bootstrap
                const modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = message;

                const modal = new bootstrap.Modal(document.getElementById("alertModal"));
                modal.show();

                event.preventDefault();  // Evita o envio do formulário se a senha não atender aos critérios
            }
        });
    });
</script>

<!-- Adicione este HTML para criar o modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Atenção!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content">
                <!-- O conteúdo da mensagem será exibido aqui -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
