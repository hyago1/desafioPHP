<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,700;1,14..32,700&family=Poppins&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styleIndex.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <h2>Gerenciador de associados - Desafio PHP</h2>
  
    <div class="tables" style="overflow: hidden;">


        <section>
            <div>
                <h4>Associados</h4>
                <table style="width: 100%;">

                    <thead>
                        <tr>
                            <th style="border-radius: 10px 0 0 0 ;">Nome</th>
                            <th>CPF</th>
                            <th style="border-radius: 0 10px 0 0 ;">DataFili</th>
                        </tr>
                    </thead>
                    <tbody></tbody>


                    <?php



                    require_once './controller/bd.php';
                    require_once './models/associado.php';
                    $sql = "SELECT * FROM associado";
                    $result = getDataAssociado($sql);



                    if (!$result) {
                    } else {
                        // Verifica se a consulta retornou resultados
                        if (pg_num_rows($result) > 0) {
                            // Loop para exibir cada produto em um item de lista
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<tr>";

                                echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['datafiliacao']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<li>Nenhum associado encontrado.</li>";
                        }
                    }



                    ?>

                </table>

                <h4>Anuidades</h4>
                <table>

                    <thead>
                        <tr>
                            <th style="border-radius: 10px 0 0 0 ;">Ano</th>
                            <th>Valor</th>
                            <th style="border-radius: 0 10px 0 0 ;">Edit<br></th>
                        </tr>
                    </thead>
                    <tbody></tbody>


                    <?php
                    require_once './controller/bd.php';
                    require './models/anuidade.php';

                    $sql = "SELECT * FROM anuidade order by anoanu";
                    $result = getDataAnuidade($sql);

                    if (!$result) {
                    } else {
                        // Verifica se a consulta retornou resultados
                        if (pg_num_rows($result) > 0) {
                            // Loop para exibir cada produto em um item de lista
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<form method='POST' action='/desafiophp/index.php' <tr>";
                                echo '<td style="display:none"><input type="text" name="id" value=' . htmlspecialchars($row['id']) . ' />';
                                echo "<td>" . htmlspecialchars($row['anoanu']) . "</td>";
                                echo '<td> R$ <input type="text"   style="background-color:transparent; border:none; color:black;" name="valor" value='  . htmlspecialchars($row['valor']) . '>' . '  </td>';
                                echo "<td> <button type='submit'  name='editValue' class='edit'>Editar</button></form>  ";
                                echo "</tr></form>";
                            }
                        } else {
                            echo "<li>Nenhuma anuidade encontrado.</li>";
                        }
                    }

                    if (isset($_POST['editValue'])) {
                        $id = $_POST['id'];
                        $valor = $_POST['valor'];
                        updateAnuidade($valor, $id);
                    }




                    ?>

                </table>
            </div>

            <div class="tableChecks" style="height: 86%;width: 68%; overflow: auto;">

                    <h4>Checkouts de pagamentos</h4>

                    <table>
                        <tr><th style="border-radius: 10px 0 0 0 ;">Nome</th><th>Email</th><th>CPF</th><th>Ano Anuidade</th><th>Valor</th><th style="border-radius: 0 10px 0 0 ;">Pago</th>
                    </tr>


                        <?php


                        require_once './controller/bd.php';
                        require './models/checkout.php';




                              if (isset($_POST['buscar'])) {
                                

                                if (isset($_POST['status'])) {
                                    $status = $_POST['status'];
                                    if ($status === 'tudo') {
                                        exibir( getDataCheckout());
                                    }else if  ($status === 'dia') {
                                        exibir( getDataFilterCheckout(true));
                                    }else {
                                        exibir( getDataFilterCheckout(false));
                                    }

                                    
                                } else {
                                    echo 'Por favor, selecione uma opção.';
                                }
                            }
                       function exibir($result){
                         if ($result && pg_num_rows($result) > 0) {
                        
                           
                                while ($row = pg_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["cpf"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["anoanu"]) . "</td>";
                                    echo "<td>"  . "R$". htmlspecialchars($row["valor"])  . "</td>";
                                    echo "<td>" . htmlspecialchars($row["pago"]) . "</td>";
                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                                echo "<li>Nenhum pagamento encontrado.</li>";
                            }
                        
                       }

                       



                        ?>

              
            </div> 



        </section>

        <div class="divBtns">
              <form class="formBuscar" method="POST" action="/desafiophp/index.php">
                              <label for="status">Tudo</label>
                              <input type="radio" name="status" checked value="tudo" id="Tudo">
                              <label for="status">Pagos</label>
                              <input type="radio" name="status" value="dia" id="Em dia">
                              <label for="status">Atrasados</label>              
                              <input type="radio" name="status" value="atr" id="Atrasados">
                              <button type="submit" name="buscar" id="cadastrar" value="buscar">Buscar</button>
         </form>

       

            <a href="/desafiophp/cadastro.php">
            <input type="submit" id="cadastrar" value="Cadastrar">

            </a>


        </div>
      

    </div>





</body>

</html>