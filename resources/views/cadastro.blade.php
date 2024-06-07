<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Desafio</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form id="search-form" method="GET" action="{{ route('cadastro.search') }}">
            <div class="form-group">
                <label for="search-id">Buscar por ID</label>
                <input type="number" class="form-control" id="search-id" name="search_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <form id="address-form" action="{{ route('cadastro.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ old('id') ?? $cadastro->id ?? '' }}">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') ?? $cadastro->nome ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') ?? $cadastro->data_nascimento ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" data-input value="{{ old('cep') ?? $cadastro->cep ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" data-input value="{{ old('endereco') ?? $cadastro->endereco ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') ?? $cadastro->numero ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" data-input value="{{ old('bairro') ?? $cadastro->bairro ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" data-input value="{{ old('cidade') ?? $cadastro->cidade ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="uf">UF</label>
                <input type="text" class="form-control" id="uf" name="uf" data-input value="{{ old('uf') ?? $cadastro->uf ?? '' }}" required>
            </div>
            <button type="submit" id="save-button" class="btn btn-primary">Salvar</button>
            <button type="button" id="delete-button" class="btn btn-danger" style="display:none;">Excluir</button>
        </form>
    </div>
    
    <div id="fade" class="hide"></div>
    <div id="loader" class="hide"></div>
    <div id="message" class="hide">
        <p></p>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector("#search-form");
            const deleteButton = document.querySelector("#delete-button");

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.querySelector("#search-id").value;
                window.location.href = `/cadastro/${id}/edit`;
            });

            deleteButton.addEventListener('click', function() {
                const id = document.querySelector("#id").value;
                if (id) {
                    window.location.href = `/cadastro/${id}/delete`;
                }
            });

            const idField = document.querySelector("#id").value;
            if (idField) {
                deleteButton.style.display = 'inline-block';
            }

            const cepField = document.querySelector("#cep");
            cepField.addEventListener('blur', function() {
                const cep = cepField.value.replace(/\D/g, '');
                if (cep) {
                    fetch(`/cep/${cep}`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.error) {
                                document.querySelector("#endereco").value = data.logradouro;
                                document.querySelector("#bairro").value = data.bairro;
                                document.querySelector("#cidade").value = data.localidade;
                                document.querySelector("#uf").value = data.uf;
                            } else {
                                alert('CEP não encontrado!');
                            }
                        })
                        .catch(() => {
                            alert('Erro ao buscar o CEP!');
                        });
                }
            });
        });
    </script>
</body>
</html>
