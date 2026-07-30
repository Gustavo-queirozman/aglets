4. Perguntas Teóricas
4.1 API Resources no Laravel
Explique:
•Qual é o objetivo de utilizar API Resources? 
Api resources no Laravel é transformar e padronizar os dados retornados pela API.

•Em quais situações eles são úteis no desenvolvimento de APIs?
.Padronizar resposta de API;
.Ocultar informações sensíveis;
.Formatar dados antes de enviá-los ao cliente;
.Manter o código organizado, separado a lógica de apresentação da lógica de negócio;
.Facilitar a manutenção e evolução da API.


4.2 Organização de Validação em Laravel
Explique as vantagens de utilizar classes específicas para validação de dados, em vez de realizar validações diretamente no controller. Considere aspectos como:
•Organização do código: regras de validação ficam separadas da lógica de negócio da aplicação.
•Manutenção: quando as regras de validação estão centralizadas em uma classe específica, qualquer alteração precisa ser feita em apenas um local.
•Reutilização:As classes de validação podem sr reutilizadas em diferentes controllers e endpoints que utilizam as mesmas rgras.

4.3 Testes Automatizados no Laravel
Responda às seguintes perguntas:
1.Para que servem testes automatizados em uma aplicação Laravel? Para verificar se um software continua funcionando após uma alteração.

2. Caso você precise testar um endpoint da API, explique como você implementaria esse teste utilizando PHPUnit no Laravel, incluindo:
•onde o teste seria criado
•como o endpoint seria testado
•como executar os testes no projeto

Seria um teste de funcionalidade, pois ele verifica o comportamento completo da requisição HTTP: rota, controller, validação, banco de dados e resposta.
1 – Seria criado dentro de pasta tests/Feature. Exemplo: UserApiTest.php. Asssim que se cria o arquivo php artisan make:test UserApiTest

2- O teste enviaria uma requisição para o endpoint que se deseja validar, simulando o comportamento de um usuário ou sistema consumidor da API. Em seguida, seriam verificadas as respostas retornadas pela aplicação, como:
•Código HTTP (200, 201, 404, etc.);
•Estrutura dos dados em JSON;
•Conteúdo das informações retornadas;
•Comportamento esperado após a execução da ação.
Por exemplo, em um endpoint de listagem de usuários, o teste verificaria se a resposta foi retornada com sucesso e se os dados dos usuários estão presentes no formato esperado.
3- php artisan test




