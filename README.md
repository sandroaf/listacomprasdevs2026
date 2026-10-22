# Lista de Compras DEVS TI 2026

Aplicação didática para ensinar Desenvolvimento Web, backend com PHP e persistência em MySQL. O projeto demonstra o ciclo completo de cadastro, consulta, alteração e exclusão de listas e itens, com comentários em português nos arquivos PHP, JavaScript, CSS e no SQL complementar.

## Material de estudo

- [Tutorial completo em Markdown](material_didatico/Tutorial_Lista_de_Compras_PHP_MySQL.md): explicações para iniciantes, diagramas, trechos da implementação atual e exercícios.
- [Tutorial em Word](material_didatico/Tutorial_Lista_de_Compras_PHP_MySQL.docx): versão editável para usar em aula.

As duas versões descrevem o código corrigido. Charset, validação, escape de HTML, token CSRF, redirecionamentos e transações já estão implementados.

## Funcionalidades

- Criar, consultar, renomear e excluir listas.
- Adicionar, consultar, alterar e excluir itens.
- Informar descrição e quantidade decimal de cada item.
- Registrar data e hora do cadastro e da última alteração do item.
- Confirmar exclusões na interface e verificar o formulário no servidor.
- Apresentar listas e itens em ordem alfabética.

## Tecnologias

| Tecnologia | Responsabilidade |
| --- | --- |
| HTML e CSS | Estrutura, formulários, apresentação e foco de teclado. |
| JavaScript | Confirmação de exclusão e limpeza da mensagem de retorno. |
| PHP com PDO | Sessões, validação, consultas parametrizadas e respostas HTTP. |
| MySQL com InnoDB | Persistência, chaves, restrições e transações. |

## Requisitos

- PHP **8.1 ou superior**, com `PDO`, `pdo_mysql`, `mbstring` e sessões habilitados.
- MySQL **8.0.16 ou superior**, com a collation `utf8mb4_0900_ai_ci` e suporte a `CHECK` aplicado pelo banco.
- Navegador, editor e um banco local para estudo.
- Opcional: phpMyAdmin para importar e consultar o banco.

Verifique a instalação:

```bash
php -v
php -m
```

A sessão do PHP precisa ter um diretório de armazenamento gravável pelo servidor. O navegador deve aceitar o cookie de sessão usado pelos formulários.

## Executar localmente

### 1 Obter o projeto

Clone este repositório ou extraia o ZIP baixado pelo GitHub. Abra o terminal na pasta de `index.php`.

### 2 Instalar o banco

Crie um banco vazio de estudo:

```sql
CREATE DATABASE listadecompras CHARACTER SET utf8mb4;
USE listadecompras;
```

Selecione o banco no phpMyAdmin e importe [`listadecompras.sql`](listadecompras.sql). **O arquivo principal agora cria `lista` e `itens`**, incluindo os exemplos de lista `Casa` e `Sitio`.

Para uma instalação antiga que já tem `lista` mas ainda não tem `itens`, execute somente [`banco/itens.sql`](banco/itens.sql). Não execute o complemento depois de importar o arquivo completo no mesmo banco novo.

Se as duas tabelas já existirem, compare as colunas e restrições antes de planejar uma migração: o complemento não altera tabelas existentes. Não reimporte o dump sobre dados que devem ser preservados.

### 3 Configurar a conexão

Se `acessos.php` estiver ausente, copie [`acessos.exemplo.php`](acessos.exemplo.php) para `acessos.php`. Configure as constantes `hostname`, `database`, `user` e `password` com os dados locais. O exemplo usa valores fictícios.

Como alternativa, `conexao.php` aceita `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` e `DB_PASSWORD` definidos no ambiente. Esses valores prevalecem sobre a configuração local; uma senha de ambiente explicitamente vazia também é aceita. O arquivo local continua sendo carregado para fornecer os valores padrão.

A conexão usa `charset=utf8mb4`, exceções PDO, leitura associativa e preparação nativa do MySQL. Em uma falha de conexão, responde com HTTP 500, registra o detalhe no log do PHP e encerra o processamento.

### 4 Abrir a aplicação

```bash
php -S 127.0.0.1:8000
```

Abra [a aplicação local](http://127.0.0.1:8000/index.php), mantendo o MySQL ativo separadamente. Pressione `Ctrl+C` para encerrar o servidor PHP. Também é possível usar Apache configurado pelo professor; o servidor embutido do PHP destina-se a desenvolvimento.

### 5 Exercitar o CRUD

1. Crie uma lista com nome diferente dos exemplos.
2. Adicione dois itens com quantidades como `2` e `1.50`.
3. Renomeie a lista e altere a quantidade de um item.
4. Cancele uma confirmação de exclusão e confira que os dados permanecem.
5. Exclua um item e depois a lista de teste.

Veja os [resultados esperados e casos de limite](material_didatico/Tutorial_Lista_de_Compras_PHP_MySQL.md#secao-18).

## Regras implementadas

- Nome da lista: de 1 a 100 caracteres após remover espaços nas extremidades; sem duplicidade no banco.
- Descrição do item: de 1 a 150 caracteres após remover espaços nas extremidades.
- Quantidade: de `0.01` a `99999999.99`, com no máximo duas casas decimais. O valor enviado pelo campo numérico usa ponto; valores fora da regra são rejeitados sem arredondamento.
- Identificadores: inteiros positivos dentro do intervalo de `INT`; os registros precisam existir.
- Todos os cadastros, alterações e exclusões exigem **POST e token CSRF da sessão**. GET nesses processadores recebe 405; token inválido recebe 403.
- Mensagens e dados recebem escape ao entrar no HTML. Os links enviam apenas identificadores e consultam os nomes no banco.
- Gravações bem-sucedidas redirecionam com **HTTP 303 e `exit`**.
- A exclusão de lista bloqueia o registro e remove itens e lista em uma transação, com rollback em caso de falha.
- A página principal faz duas consultas e agrupa os itens por lista, sem uma consulta adicional para cada lista.

## Arquivos principais

| Arquivo ou pasta | Uso |
| --- | --- |
| `index.php` | Consultas, agrupamento e página inicial. |
| `funcoes.php` | Sessão, CSRF, validação, escape, buscas e respostas. |
| `conexao.php` | Criação do PDO e tratamento de falha de conexão. |
| `acessos.exemplo.php` | Modelo de configuração sem credenciais reais. |
| `incluirlista.php` e `incluirlistasalva.php` | Formulário e cadastro de lista. |
| `incluiritens.php` e `incluiritenssalva.php` | Formulário e cadastro de item. |
| `alterarlista.php` e `alterarlistasalva.php` | Carregamento e alteração da lista. |
| `alteraritem.php` e `alteraritemsalva.php` | Carregamento e alteração do item. |
| `excluirlista.php` e `excluiritem.php` | Exclusões por POST protegido. |
| `funcoes.js` e `estilo.css` | Interação e apresentação. |
| `img/` | Ícones da aplicação. |
| `listadecompras.sql` | Instalação completa do banco. |
| `banco/itens.sql` | Complemento para bancos antigos sem `itens`. |
| `testes/validacoes.php` | Verificações automatizadas sem banco. |
| `material_didatico/` | Tutoriais Word e Markdown e seus diagramas. |

## Modelo de dados

![Relacionamento entre listas e itens](material_didatico/imagens/relacionamento.png)

`lista.codigo` é a chave primária da lista. `itens.codigo_lista` é a chave estrangeira que associa cada item à lista. `itens.codigo` identifica o item. A estrutura de instalação define uma chave estrangeira com `ON DELETE RESTRICT` e um `CHECK` para quantidade positiva.

## Verificações

Execute as regras de entrada sem acessar o banco:

```bash
php testes/validacoes.php
```

O teste contém **32 verificações**, incluindo limites de tamanho, números inválidos, arrays, UTF-8, escape HTML e token de sessão. Para conferir a sintaxe de todos os arquivos em um terminal Bash:

```bash
for arquivo in *.php testes/*.php; do php -l "$arquivo" || exit 1; done
node --check funcoes.js
```

O segundo comando requer Node.js apenas para a verificação sintática do JavaScript; a aplicação usa JavaScript no navegador e não depende de Node para executar.

A revisão também passou por **56 verificações de integração e navegador em um MySQL temporário**, incluindo CRUD, acentos e emojis, bloqueio de GET e CSRF inválido, cancelamento de exclusão e rollback após falha simulada. Esses testes de integração foram feitos em ambiente descartável. O [roteiro do tutorial](material_didatico/Tutorial_Lista_de_Compras_PHP_MySQL.md#secao-18) orienta a repetição das verificações em aula.

## Dificuldades comuns

| Sintoma | O que conferir |
| --- | --- |
| `could not find driver` | Extensão `pdo_mysql` no PHP que atende a página. |
| Função `mb_*` indisponível | Extensão `mbstring` nesse PHP. |
| Falha de conexão | Serviço MySQL, host, porta, banco e credenciais. |
| Tabela `itens` inexistente | SQL completo em banco novo ou complemento em instalação antiga. |
| `Unknown collation` | Compatibilidade do servidor com o dump MySQL 8. |
| Nome repetido | Índice `UNIQUE`: escolha outro nome. |
| HTTP 405 em exclusão | Abra a interface e use o formulário POST; os antigos links GET não excluem. |
| HTTP 403 ao salvar | Recarregue o formulário e confira cookies e sessão. |

Detalhes técnicos ficam no log do PHP. Leia a [seção de diagnóstico](material_didatico/Tutorial_Lista_de_Compras_PHP_MySQL.md#secao-17).

## Publicação e configuração local

A aplicação é uma base de ensino e não implementa login ou isolamento de dados por usuário. A sessão é usada para proteção dos formulários, e não para autenticação.

O `.gitignore` inclui `/acessos.php`, e `acessos.exemplo.php` pode ser publicado como modelo. **O arquivo `acessos.php` já era rastreado pelo Git**: ignorá-lo não remove esse rastreamento nem as versões do histórico. Revise as credenciais e o rastreamento antes da publicação e troque qualquer senha real que já tenha sido divulgada.

Inclua os tutoriais e a pasta `material_didatico/imagens/` no mesmo envio para preservar as imagens e os links relativos no GitHub.
