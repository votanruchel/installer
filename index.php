<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de instalacao</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  </head>
  <style media="screen">
  @import url('https://fonts.googleapis.com/css?family=Montserrat');
    *{
      margin: 0;
      padding: 0;
      font-family: 'Montserrat';
    }
    p{
      margin-top: 10px;
      font-size: 12px;
      margin-left: 3%;
    }
    small{
      font-size: 9px;
      margin-left: 3%;
    }
    h2{
      font-size: 20px;
      display: block;
      background-color: #DDD;
      padding: 10px;
    }
    span{
      display: flex;
      justify-content: center;
      margin: auto;
      width: 1000px;
      color: #FFF;
      padding: 20px;
    }
    .rage{
      background-color: #eb4d4b;
      width: 100%;
      color: #FFF;
    }
    .box{
      display: flex;
      width: 1000px;
      height: auto;
      background-color: #F1F1F1;
      margin: auto;
      padding: 2.5%;
      margin-top: 3%;
    }
    .flex-column{
      display: flex;
      flex-direction: column;
      margin-top: 3%;
      padding-bottom: 3%;
      margin-right: 20px;
      border: 1px solid #DDD;
    }
    input[type=text],input[type=password]{
      width: auto;
      height: 30px;
      border-radius: 5px;
      border: 2px solid #DDD;
      padding-left: 20px;
      margin-left: 3%;
      margin-right: 3%;
    }
    button{
      display: flex;
      justify-content: center;
      padding: 15px;
      border: none;
      border-radius: 5px;
      background-color: #4834d4;
      color: #f1f1f1;
      cursor: pointer;
      width: 1040px;
      margin: auto;
      transition: all 1.5s;
    }
    a{
      text-decoration: none;
      color: #f1f1f1;
    }
  </style>
  <body>
      <span></span>
    <div class="box">

      <div class="flex-column">
        <h2>Configuracao do banco de dados</h2>
        <p>Host: (ex: localhost)</p>
        <input type="text" name="db_host" value="" placeholder="DB Host">
        <p>Nome do banco de dados</p>
        <input type="text" name="db_name" value="" placeholder="DB Nome">
        <p>Nome de usuario do banco de dados</p>
        <input type="text" name="db_user" value="" placeholder="DB Usuario">
        <p>Senha do usuario</p>
        <input type="text" name="db_pass" value="" placeholder="DB Pass">
      </div>
      <div class="flex-column">
        <h2>Configuracoes basicas do site</h2>
        <p>Dominio principal: (ex: http://www.seusite.com.br/)</p>
        <input type="text" name="site_domain" value="" placeholder="URL principal do site">
        <p>E-mail para notificacoes</p><small>Seu desenvolvedor entrara em contato atrves dete email</small>
        <input type="text" name="site_email" value="" placeholder="E-mail para contatos administrativos">
      </div>
      <div class="flex-column">
        <h2>Configuracoes painel administrativo</h2>
        <p>Usuario admin</p>
        <input type="text" name="adm_user" value="admin" placeholder="Nome de usuario (ex: admin)">
        <p>E-mail</p>
        <input type="text" name="adm_email" value="" placeholder="E-mail para notificacoes">
        <p>Senha</p>
        <input type="password" name="adm_pass" value="" placeholder="Senha">
      </div>

    </div>
    <div>
      <button type="button" name="ready">Pronto</button>
    </div>
    <script type="text/javascript">
      $(function(){
        $('button').on('click',function(){
          if ($('input[type=text]').val() == '') {
            alert('Todos os campos devem ser preenchidos');
            return;
          }
          var data = [];
          data['db_host'] = $('input[name=db_host]').val();
          data['db_name'] = $('input[name=db_name]').val();
          data['db_user'] = $('input[name=db_user]').val();
        //  data['db_pass'] = $('input[name=db_pass]').val();
          data['site_domain'] = $('input[name=site_domain]').val();
          data['site_email'] = $('input[name=site_email]').val();
          data['adm_user'] = $('input[name=adm_user]').val();
          data['adm_email'] = $('input[name=adm_email]').val();
          data['adm_pass'] = $('input[name=adm_pass]').val();
          //var data = $('input[type=text], input[type=password]').serialize();
          for (var i in data) {
            if (data[i] == "") {
              alert("Voce deve preencher todos os dados para concluir a configuracao inicial!");
              return;
            }
          }
          data['db_pass'] = $('input[name=db_pass]').val();
          $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {db_host:data['db_host'],
            db_name:data['db_name'],
            db_user:data['db_user'],
            db_pass:data['db_pass'],
            site_domain:data['site_domain'],
            site_email:data['site_email'],
            adm_user:data['adm_user'],
            adm_email:data['adm_email'],
            adm_pass:data['adm_pass']},
            beforeSend: function(){
              $('button').css('background-color','#f9ca24');
              //$('.box').slideUp(2500);
            },
            success:function(response){

              $('span').html(response);
              if (response == 'Arquivo de configuracao criado com sucesso e sistema extraido com sucesso para a pasta raiz!') {
                $('span').css('background-color','#6ab04c');
                $('button').html('<a href="'+data['site_domain']+'">Finalizado, clique para ir ao sistema</a>');
                $('button').css('background-color', '#686de0');
                $("button").css('border-radius','0px');
                $('.box').slideUp(2500);
                setTimeout(window.location.reload(),2500);
              }else{
                $('span').css('background-color', '#eb4d4b')
                $("button").html('Nao eh possivel criar um novo documento de configuracao | tentar novamente');
                $("button").css('background-color','#eb4d4b');
                $("button").css('border-radius','0px');
              }
            },
          });
        });
      });
    </script>
  </body>
</html>
