CREATE TABLE `aluno` (
  `id_aluno` int(11) NOT NULL,
  `matricula` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_aluno` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `turma` (
  `id_turma` int(11) NOT NULL,
  `nome_turma` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_workspace` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `turma_aluno` (
  `id_turma` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL,
  `user_nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `workspace` (
  `id_workspace` int(11) NOT NULL,
  `nome_workspace` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` date NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices de tabela
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id_aluno`),
  ADD UNIQUE KEY `matricula` (`matricula`);

ALTER TABLE `turma`
  ADD PRIMARY KEY (`id_turma`),
  ADD KEY `fk_workspace` (`id_workspace`);

ALTER TABLE `turma_aluno`
  ADD PRIMARY KEY (`id_turma`,`id_aluno`),
  ADD KEY `id_turma_fk` (`id_turma`) USING BTREE,
  ADD KEY `id_aluno_fk` (`id_aluno`) USING BTREE;

--
-- Índices de tabela
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `idx_login` (`login`);

ALTER TABLE `workspace`
  ADD PRIMARY KEY (`id_workspace`),
  ADD KEY `fk_id_usuario` (`id_usuario`);

ALTER TABLE `turma`
  ADD CONSTRAINT `fk_workspace` FOREIGN KEY (`id_workspace`) REFERENCES `workspace` (`id_workspace`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `turma_aluno`
  ADD CONSTRAINT `id_aluno_fk` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_turma_fk` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `workspace`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;



