## API WHATSAPP

>> Passos para a configuração da api do whatsapp:

1 -> Foi configurado dentro da plataforma Whatsapp Business um contato teste;
** Para envio de mensagens precisa cadastrar os números que irão receber as mensagens dentro da plataforma do whats;
** Para envio de mensagem com o número de produção precisa gerar um novo token permanente e acrescentar os dados para pagamento;
** Só será descontado do cartão cadastrado o valor por mensagens se ultrapassar mais de 1000 mensagens enviadas por mês, ou quando a conversa durar mais de 24h utilizando a api do whats, ou quando ultrapassar o limite de 250 mensagens diarias enviadas;
** Mensagens iniciadas pelo cliente para o contato cadastrado na api não contabiliza nas 1000 mensagens;

2 -> Configurar os templeds de envio de mensagens dentro da plataforma do Whatsapp Business; 

3-> Criar a tabela para webhook, onde receberá os dados das mensagens e fidbacks da API do Whatsapp;
** Pode ser criada separada um banco de dados apenas para o webhook ou em um banco existente;
** Campos existente para a tabela: id, created_at, updated_at, type, webhook;
** Quando é enviado a requisição para o webhook (quando é enviado uma mensagem pela API do Whatsapp), o retorno na tabela fica com um campo: status: sent, quando a mensagem é visualizada pelo cliente é enviado a mesma requisição para o banco de dados mas com o status: read;

4 -> Configurar o webhook com o ngrok:
>>> Abra o arquivo whatsbot separado no editor de código;
>>> No terminal digite php artisan serve;
>>> No Chrome abra a aba 127.0.0.1:8000/api/whatsapp;
>>> Em um novo terminal, (sem fechar o aberto), digite ./ngrok http 8000, para rodar no servidor do whats;
>>> Abra o link que aparece no terminal + api/whatsapp no Chrome; 
>>> Por fim precisa alterar nas configurações da API do Whatsapp o link e token que foi aberto do ngrok;
>>> Esse arquivo precisa estar aberto 24h. Todas as vezes que fechar precisa repetir as configurações.
