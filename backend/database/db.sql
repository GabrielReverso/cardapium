DROP DATABASE cardapiumDB;

CREATE DATABASE cardapiumDB DEFAULT CHARACTER SET utf8;

USE cardapiumDB;


CREATE TABLE IF NOT EXISTS cardapiumDB.TB_CATEGORIA (
	id int NOT NULL AUTO_INCREMENT,
	nome varchar(255) NOT NULL,
	PRIMARY KEY (id)
)ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS cardapiumDB.TB_ITENS (
	id int NOT NULL AUTO_INCREMENT,
	idCategoria int NOT NULL,
	nome varchar(255) NOT NULL,
	descricao TEXT NULL,
	foto varchar(500) NULL,
	preco DECIMAL(10, 2) NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT FK_ITENS_CATEGORIA FOREIGN KEY (idCategoria) 
	REFERENCES TB_CATEGORIA(id)
		ON DELETE NO ACTION
		ON UPDATE CASCADE
)ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS cardapiumDB.TB_USUARIO (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  data_nascimento DATE NULL,
  telefone VARCHAR(20) NULL,
  senha VARCHAR(255) NOT NULL,
  cep VARCHAR(10) NULL,
  rua VARCHAR(255) NULL,
  numero VARCHAR(10) NULL,
  bairro VARCHAR(100) NULL,
  complemento VARCHAR(100) NULL,
  cidade VARCHAR(100) NULL,
  estado CHAR(2) NULL,
  PRIMARY KEY (id)
)ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS cardapiumDB.TB_PEDIDOS (
	id int NOT NULL AUTO_INCREMENT,
	preco DECIMAL(10,2) NOT NULL,
	nome varchar(255) NOT NULL,
	idUsuario int NOT NULL,
	finalizado tinyint NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT FK_PEDIDO_USUARIO FOREIGN KEY (idUsuario)
		REFERENCES TB_USUARIO(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
)ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS cardapiumDB.TB_ITENS_PEDIDOS(
  id INT NOT NULL AUTO_INCREMENT,
  idPedido INT NOT NULL,
  idItem INT NOT NULL,
  quantidade INT NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_ITENS FOREIGN KEY (idItem)
    REFERENCES TB_ITENS(id)
    	ON DELETE CASCADE
		ON UPDATE CASCADE,
  CONSTRAINT FK_PEDIDOS FOREIGN KEY (idPedido)
    REFERENCES TB_PEDIDOS (id)
    	ON DELETE CASCADE
		ON UPDATE CASCADE
)ENGINE = InnoDB;



-- inserção das categorias
INSERT INTO TB_CATEGORIA (nome) VALUES ('Hamburgueres');
INSERT INTO TB_CATEGORIA (nome) VALUES ('Hot Dogs');
INSERT INTO TB_CATEGORIA (nome) VALUES ('Sobremesas');
INSERT INTO TB_CATEGORIA (nome) VALUES ('Bebidas');
INSERT INTO TB_CATEGORIA (nome) VALUES ('Drinks');

-- inserção dos itens
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (1, 'Texas BBQ', 'Um clássico robusto com carne suculenta grelhada, bacon crocante, molho barbecue defumado e cebola empanada, tudo em um pão macio para um sabor cheio de personalidade.', 'TexasBBQ.png', 29.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (1, 'Cheese Overload', 'Uma explosão de sabor para os amantes de queijo! Combina cheddar derretido, suíço cremoso e mussarela elástica sobre uma carne bem temperada e grelhada à perfeição.', 'CheeseOverload.png', 27.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (1, 'Tradição Premium', 'Um hambúrguer clássico e equilibrado com carne bovina artesanal, alface fresca, tomate maduro, queijo derretido e um molho especial que realça o sabor, servido em pão brioche dourado.', 'TradicaoPremium.png', 24.90);


INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (2, 'American BBQ Dog', 'Um hot dog clássico com salsicha grelhada, molho barbecue defumado, bacon crocante e cebolas caramelizadas, tudo envolvido em um pão macio.', 'AmericanBBQDog.png', 19.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (2, 'Cheese Lovers Dog', 'Para os apaixonados por queijo, combina uma salsicha suculenta coberta com cheddar cremoso, queijo ralado e molho especial, derretendo a cada mordida.', 'CheeseLoversDog.png', 17.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (2, 'Hot Chili Dog', ' Uma explosão de sabor picante com salsicha temperada, chili apimentado, molho de jalapeños e uma pitada de queijo ralado para equilibrar.', 'HotChiliDog.png', 21.90);


INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (3, 'Banoffee Supreme', 'Uma sobremesa irresistível que combina uma base crocante de biscoito, camadas generosas de doce de leite, bananas maduras e chantilly cremoso, finalizado com raspas de chocolate.', 'BanoffeeSupreme.png', 16.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (3, 'Tiramisu di Classe', 'Um clássico italiano com camadas de biscoito champagne embebido em café, intercaladas com um creme suave de mascarpone e polvilhado com cacau em pó para um toque elegante.', 'TiramisudiClasse.png', 18.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (3, 'Churros Gourmet Deluxe', 'Churros macios e crocantes, recheados com doce de leite artesanal, acompanhados de calda de chocolate belga e finalizados com açúcar e canela. Servidos em apresentação especial.', 'ChurrosGourmetDeluxe.png', 5.90);


INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (4, 'Coca-Cola (lata)', 'O refrigerante mais amado do mundo, com seu sabor inconfundível e refrescante, perfeito para acompanhar qualquer refeição.', 'coca-cola.png', 6.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (4, 'Guaraná Antarctica (lata)', 'Um clássico nacional, com sabor autêntico e borbulhante, feito com o melhor do fruto do guaraná. Ideal para quem busca um toque de brasilidade.', 'guarana.png', 5.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (4, 'Schweppes Citrus (lata)', 'Um refrigerante sofisticado, com um toque cítrico e borbulhas elegantes, perfeito para quem aprecia sabores refrescantes e únicos.', 'SchweppesCitrus.png', 7.90);


INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (5, 'Tropical Sunset', 'Uma combinação refrescante de rum branco, suco de abacaxi, xarope de grenadine e um toque de limão, criando camadas de sabor e uma apresentação deslumbrante.', 'TropicalSunset.png', 21.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (5, 'Berry Gin Tonic', 'Uma versão sofisticada do clássico gin tônica, com gin premium, água tônica, frutas vermelhas frescas e uma rodela de limão-siciliano para um toque especial.', 'BerryGinTonic.png', 24.90);
INSERT INTO TB_ITENS (idCategoria, nome, descricao, foto, preco) VALUES (5, 'Whiskey Sour Classic', 'Um drink equilibrado com whiskey bourbon, suco de limão fresco, xarope de açúcar e um toque de clara de ovo para uma textura suave, finalizado com uma pitada de angostura.', 'WhiskeySourClassic.png', 26.90);
