-- Complemento para bancos que já importaram listadecompras.sql e ainda não têm itens.
-- Confira a estrutura existente antes de executar: este arquivo não altera tabelas existentes.
CREATE TABLE itens (
  codigo INT NOT NULL AUTO_INCREMENT,
  descricao VARCHAR(150) NOT NULL,
  quantidade DECIMAL(10,2) NOT NULL DEFAULT 1.00,
  codigo_lista INT NOT NULL,
  datahora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (codigo),
  INDEX idx_itens_lista (codigo_lista),
  CONSTRAINT fk_itens_lista FOREIGN KEY (codigo_lista)
    REFERENCES lista (codigo) ON DELETE RESTRICT,
  CONSTRAINT ck_itens_quantidade CHECK (quantidade > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
