ALTER TABLE `cantina`.`cliente_credito`
  ADD COLUMN `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'campo que define se credito/debito esta ativo ou n�o(deletado)';
