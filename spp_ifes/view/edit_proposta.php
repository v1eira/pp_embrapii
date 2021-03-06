<?php
include_once("../controller/sessao.php");
include_once("header.php");
include_once("../model/conexao.php");
include_once("../model/propostas/funcoes_propostas.php");
$_SESSION['submit'] = 0;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$row = getProjeto($id);


if($_SESSION['tipo'] != 1 AND $_SESSION['id'] != $row['id_usuario']){ /* usuário não é administrador e não criou a proposta */
	$_SESSION['msg'] = "Você não tem permissão para acessar essa página.";
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<link rel="stylesheet" href="css/proposta.css">
	</head>
	<body id="grad1">
		<div class="container">
			<div class="py-5 text-center">
				<h2 class="mb-0 text-dark">Preencher proposta</h2>

				<div class="py-2 text-right" id="botoes-preencher-proposta">
					<a class='btn btn-sm mr-4 btn-outline-danger' href="#" role='button' onclick="pdf(<?php echo $id; ?>)">Gerar PDF</a>
					<a class='btn btn-sm mr-4 btn-outline-success' href="#" role='button' onclick="csv(<?php echo $id; ?>)">Gerar CSV</a></p>
				</div>
			</div>
			
			<!-- USAR ENCODE NO FORM PARA OS DADOS SEREM EXIBIDOS CORRETAMENTE -->

			<form name="formulario" method="POST" action="../controller/proc_edit_proposta.php">
				<div class="col-md-12 mb-3">
					<input type="hidden" name="id" value="<?php echo utf8_encode($row['id_projeto']); ?>">

					<label><b>Nome do projeto: </b></label><br>
					<input type="text" class="form-control" name="nome_projeto" placeholder="Nome do projeto" maxlength="100" value="<?php echo utf8_encode($row['nome_projeto']); ?>"><br><br>

					<label><b>Nome do produto que será desenvolvido: </b></label><br>
					<input type="text" class="form-control" name="nome_produto" placeholder="Nome do produto" maxlength="100" value="<?php echo utf8_encode($row['nome_produto']); ?>"><br><br>
					
					<label><b>Descrição do produto: </b></label><br>
					<textarea type="text" class="form-control" name="descricao" rows="5" cols="80" placeholder="Descrição do produto, suas características e finalidade" maxlength="4000"/><?php echo utf8_encode($row['descricao']); ?></textarea><br><br>
					
					<label><b>Nome da empresa: </b></label><br>
					<input type="text" class="form-control" name="nome_empresa" readonly="readonly" placeholder="Nome da empresa" maxlength="100" value="<?php echo utf8_encode($row['nome_empresa']); ?>"><br><br>

					<label><b>CNPJ: </b></label><br>
					<input type="text" class="form-control" name="cnpj" readonly="readonly" placeholder="Apenas números" maxlength="14" value="<?php echo utf8_encode($row['cnpj']); ?>"><br><br>

					<label><b>Tipo de empresa: </b></label><br>
					<div class="custom-control custom-radio">
						<input id="MEI/ME" name="tipo_empresa" type="radio" value="MEI/ME" <?php echo (utf8_encode($row['tipo_empresa'])=='MEI/ME')?'checked':''?> class="custom-control-input" disabled>
						<label class="custom-control-label" for="MEI/ME" >MEI/ME</label> <br>
					</div>
					<div class="custom-control custom-radio">
						<input id="EPP" name="tipo_empresa" type="radio" value="EPP" <?php echo (utf8_encode($row['tipo_empresa'])=='EPP')?'checked':''?> class="custom-control-input" disabled>
						<label class="custom-control-label" for="EPP" >EPP</label> <br>
					</div>
					<div class="custom-control custom-radio">
						<input id="Médio/Grande porte" name="tipo_empresa" type="radio" value="Médio/Grande porte" <?php echo (utf8_encode($row['tipo_empresa'])=='Médio/Grande porte')?'checked':''?> class="custom-control-input" disabled>
						<label class="custom-control-label" for="Médio/Grande porte" >Médio/Grande porte</label> <br><br>
					</div>

					<label><b>Prospectado por: </b></label><br>
					<input type="text" class="form-control" name="nome_usuario" readonly="readonly" value="<?php echo utf8_encode($row['nome_usuario']); ?>"><br><br>
					
					<label><b>Telefone: </b></label><br>
					<input type="text" class="form-control" name="telefone" readonly="readonly" value="<?php echo utf8_encode($row['telefone']); ?>"><br><br>

					<label><b>Email: </b></label><br>
					<input type="email" class="form-control" name="email" readonly="readonly" value="<?php echo utf8_encode($row['email']); ?>"><br><br>

					<label><b>Riscos: </b></label><br>
					<textarea type="text" class="form-control" name="riscos" rows="5" cols="80" placeholder="Riscos inerentes ao andamento/execução do projeto" maxlength="2000"/><?php echo utf8_encode($row['riscos']); ?></textarea><br><br>

					<label><b>Partes interessadas: </b></label><br>
					<textarea type="text" class="form-control" name="interessados" rows="5" cols="80" placeholder="Empresas que têm interesse no projeto" maxlength="2000"/><?php echo utf8_encode($row['interessados']); ?></textarea><br><br>

					<label><b>Viabilidade: </b></label><br>
					<textarea type="text" class="form-control" name="viabilidade" rows="5" cols="80" placeholder="Fatores que propiciam a viabilidade do projeto" maxlength="2000"/><?php echo utf8_encode($row['viabilidade']); ?></textarea><br><br>

					<label><b>Equipe do projeto: </b></label><br>
					<textarea type="text" class="form-control" name="equipe" rows="5" cols="80" placeholder="Pessoas envolvidas no projeto" maxlength="2000"/><?php echo utf8_encode($row['equipe']); ?></textarea><br><br>

					<label><b>Entregas: </b></label><br>
					<textarea type="text" class="form-control" name="entregas" rows="5" cols="80" placeholder="Entregas do projeto" maxlength="2000"/><?php echo utf8_encode($row['entregas']); ?></textarea><br><br>

					<label><b>Cronograma: </b></label><br>
					<textarea type="text" class="form-control" name="cronograma" rows="5" cols="80" placeholder="Datas para realização das entregas" maxlength="2000"/><?php echo utf8_encode($row['cronograma']); ?></textarea><br><br>

					<label><b>Premissas: </b></label><br>
					<textarea type="text" class="form-control" name="premissas" rows="5" cols="80" placeholder="Pontos de partida para realização do projeto" maxlength="2000"/><?php echo utf8_encode($row['premissas']); ?></textarea><br><br>

					<label><b>Efeitos do projeto: </b></label><br>
					<textarea type="text" class="form-control" name="efeitos" rows="5" cols="80" placeholder="Efeitos do projeto ao ser implementado com sucesso" maxlength="2000"/><?php echo utf8_encode($row['efeitos']); ?></textarea><br><br>

					<label><b>Custo: </b></label><br>
					<textarea type="text" class="form-control" name="custo" rows="5" cols="80" placeholder="Custo total e detalhado do projeto" maxlength="2000"/><?php echo utf8_encode($row['custo']); ?></textarea><br><br>

					<label><b>Anotações complementares: </b></label><br>
					<textarea type="text" class="form-control" name="anotacoes_complementares" rows="5" cols="80" placeholder="Informações adicionais sobre o projeto" maxlength="2000"/><?php echo utf8_encode($row['anotacoes_complementares']); ?></textarea><br><br>

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="finalizado" value="1" id="checkbox">
						<label class="custom-control-label" for="checkbox">Análise finalizada?</label>
						<br> <small>*Marcando esta opção a proposta não estará mais disponível para edição.</font></small> <br>
					</div>

					<div class="py-5 text-center">
						<button class="btn mr-2 btn-dark" type="button" onclick="validate()">Preencher</button>
					</div>
				</div>
			</form>
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		function validate()
		{
			<?php $_SESSION['submit'] = 1; ?>
			formulario.submit();
		}
	</script>
	<script>
		function pdf(id)
		{
			<?php $_SESSION['submit'] = 1; ?>;
			window.open('../controller/gerar_pdf.php?id='+ id, "_blank");;
		}
	</script>
	<script>
		function csv(id)
		{
			<?php $_SESSION['submit'] = 1; ?>;
			location.href = '../controller/gerar_csv.php?id='+ id;
		}
	</script>
	</body>
</html>