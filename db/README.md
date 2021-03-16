# Instruções de geração do banco de dados

Para utilizar o banco de dados com o endereçamento já inserido, você pode baixar o arquivo `.sql` de *dump* em https://1drv.ms/u/s!Ars0gs5ebRPkgbYpvYCgNgeRbQAf1Q?e=QwX3pg. Depois de baixá-lo, basta executá-lo da forma que preferir. O banco de dados `cabeca_de_vento` será criado.

O *script* responsável pela criação do banco de dados está em `cabeca_de_vento.sql`. Ele gera as tabelas, e preenche as necessárias.

Também incluo neste diretório os arquivos `.sql` responsáveis pela criação do banco de dados. No diretório `select_procedures`, você verá as *stored procedures* desenvolvidas para recuperar os dados do banco de dados para a aplicação. Analogamente, `insert_procedures` e `update_procedures` detém as *stored procedures* desenvolvidas para obter e alterar dados no banco de dados.
