--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET search_path = public, pg_catalog;

--
-- Name: tb_area_setor_cod_area_setor_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_area_setor_cod_area_setor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_area_setor_cod_area_setor_seq OWNER TO svc_sgrd;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: tb_area_setor; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_area_setor (
    cod_area_setor integer DEFAULT nextval('tb_area_setor_cod_area_setor_seq'::regclass) NOT NULL,
    desc_area_setor character varying(30) NOT NULL
);


ALTER TABLE public.tb_area_setor OWNER TO svc_sgrd;

--
-- Name: tb_empresa; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_empresa (
    cod_empresa integer NOT NULL,
    razao_social character varying(45) NOT NULL,
    cnpj_empresa character varying(18) NOT NULL,
    end_empresa_rua character varying(20) NOT NULL,
    end_empresa_nro character varying(6) NOT NULL,
    end_empresa_complem character varying(15),
    end_empresa_bairro character varying(15) NOT NULL,
    end_empresa_cidade character varying(45) NOT NULL,
    end_empresa_uf character varying(20) NOT NULL,
    end_empresa_cep character varying(9) NOT NULL,
    inscr_estadual character varying(14),
    data_cadastro date NOT NULL,
    fone_empresa character varying(14) NOT NULL,
    email_empresa character varying(50),
    nome_fantasia character varying(45),
    obs character varying(255)
);


ALTER TABLE public.tb_empresa OWNER TO svc_sgrd;

--
-- Name: tb_empresa_cod_empresa_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_empresa_cod_empresa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_empresa_cod_empresa_seq OWNER TO svc_sgrd;

--
-- Name: tb_empresa_cod_empresa_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svc_sgrd
--

ALTER SEQUENCE tb_empresa_cod_empresa_seq OWNED BY tb_empresa.cod_empresa;


--
-- Name: tb_etapa; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_etapa (
    cod_etapa integer NOT NULL,
    desc_etapa character varying(30) NOT NULL
);


ALTER TABLE public.tb_etapa OWNER TO svc_sgrd;

--
-- Name: tb_etapa_cod_etapa_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_etapa_cod_etapa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_etapa_cod_etapa_seq OWNER TO svc_sgrd;

--
-- Name: tb_etapa_cod_etapa_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svc_sgrd
--

ALTER SEQUENCE tb_etapa_cod_etapa_seq OWNED BY tb_etapa.cod_etapa;


--
-- Name: tb_itens_pedido; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_itens_pedido (
    cod_item_pedido integer NOT NULL,
    data_despesa date NOT NULL,
    cod_tipo_item integer NOT NULL,
    valor_item numeric(10,2) NOT NULL,
    obs_item character varying(45),
    cod_pedido bigint NOT NULL,
    comprovante_item character varying(255)
);


ALTER TABLE public.tb_itens_pedido OWNER TO svc_sgrd;

--
-- Name: tb_itens_pedido_cod_item_pedido_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_itens_pedido_cod_item_pedido_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_itens_pedido_cod_item_pedido_seq OWNER TO svc_sgrd;

--
-- Name: tb_itens_pedido_cod_item_pedido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svc_sgrd
--

ALTER SEQUENCE tb_itens_pedido_cod_item_pedido_seq OWNED BY tb_itens_pedido.cod_item_pedido;


--
-- Name: tb_logs_pedidos; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_logs_pedidos (
    id_logs_pedidos integer NOT NULL,
    cod_usuario character varying(8) NOT NULL,
    data_hora timestamp without time zone NOT NULL,
    ip_origem character varying(45) NOT NULL,
    operacao character varying(20) NOT NULL,
    cod_pedido bigint NOT NULL
);


ALTER TABLE public.tb_logs_pedidos OWNER TO svc_sgrd;

--
-- Name: tb_logs_pedidos_id_logs_pedidos_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_logs_pedidos_id_logs_pedidos_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_logs_pedidos_id_logs_pedidos_seq OWNER TO svc_sgrd;

--
-- Name: tb_logs_pedidos_id_logs_pedidos_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svc_sgrd
--

ALTER SEQUENCE tb_logs_pedidos_id_logs_pedidos_seq OWNED BY tb_logs_pedidos.id_logs_pedidos;


--
-- Name: tb_pedidos; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_pedidos (
    cod_pedido bigint NOT NULL,
    cod_solicitante character varying(8) NOT NULL,
    data_pedido date NOT NULL,
    periodo_ini_pedido date NOT NULL,
    periodo_fim_pedido date NOT NULL,
    justif_pedido character varying(255) NOT NULL,
    destino_pedido character varying(15) NOT NULL,
    cod_etapa integer NOT NULL,
    cod_empresa integer NOT NULL,
    vlr_total_pedido money
);


ALTER TABLE public.tb_pedidos OWNER TO svc_sgrd;

--
-- Name: tb_perfis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tb_perfis (
    cod_perfil integer NOT NULL,
    desc_perfil character varying(45) NOT NULL
);


ALTER TABLE public.tb_perfis OWNER TO postgres;

--
-- Name: tb_perfis_cod_perfil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tb_perfis_cod_perfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_perfis_cod_perfil_seq OWNER TO postgres;

--
-- Name: tb_perfis_cod_perfil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tb_perfis_cod_perfil_seq OWNED BY tb_perfis.cod_perfil;


--
-- Name: tb_tipo_item; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_tipo_item (
    cod_tipo_item integer NOT NULL,
    tipo_item character varying(20) NOT NULL
);


ALTER TABLE public.tb_tipo_item OWNER TO svc_sgrd;

--
-- Name: tb_tipo_item_cod_tipo_item_seq; Type: SEQUENCE; Schema: public; Owner: svc_sgrd
--

CREATE SEQUENCE tb_tipo_item_cod_tipo_item_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tb_tipo_item_cod_tipo_item_seq OWNER TO svc_sgrd;

--
-- Name: tb_tipo_item_cod_tipo_item_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: svc_sgrd
--

ALTER SEQUENCE tb_tipo_item_cod_tipo_item_seq OWNED BY tb_tipo_item.cod_tipo_item;


--
-- Name: tb_uf; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_uf (
    cod_uf integer NOT NULL,
    uf character varying(2) NOT NULL,
    uf_ext character varying(20) NOT NULL
);


ALTER TABLE public.tb_uf OWNER TO svc_sgrd;

--
-- Name: tb_usuario; Type: TABLE; Schema: public; Owner: svc_sgrd; Tablespace: 
--

CREATE TABLE tb_usuario (
    cod_usuario character varying(8) NOT NULL,
    primeiro_nome character varying(15) NOT NULL,
    ultimo_nome character varying(25) NOT NULL,
    cod_perfil integer NOT NULL,
    cod_empresa integer NOT NULL,
    cod_area_setor integer NOT NULL,
    pass_usuario character varying(255) NOT NULL,
    email_usuario character varying(50) NOT NULL,
    cpf_usuario character varying(14) NOT NULL,
    status_usuario integer NOT NULL
);


ALTER TABLE public.tb_usuario OWNER TO svc_sgrd;

--
-- Name: cod_empresa; Type: DEFAULT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_empresa ALTER COLUMN cod_empresa SET DEFAULT nextval('tb_empresa_cod_empresa_seq'::regclass);


--
-- Name: cod_etapa; Type: DEFAULT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_etapa ALTER COLUMN cod_etapa SET DEFAULT nextval('tb_etapa_cod_etapa_seq'::regclass);


--
-- Name: cod_item_pedido; Type: DEFAULT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_itens_pedido ALTER COLUMN cod_item_pedido SET DEFAULT nextval('tb_itens_pedido_cod_item_pedido_seq'::regclass);


--
-- Name: id_logs_pedidos; Type: DEFAULT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_logs_pedidos ALTER COLUMN id_logs_pedidos SET DEFAULT nextval('tb_logs_pedidos_id_logs_pedidos_seq'::regclass);


--
-- Name: cod_perfil; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tb_perfis ALTER COLUMN cod_perfil SET DEFAULT nextval('tb_perfis_cod_perfil_seq'::regclass);


--
-- Name: cod_tipo_item; Type: DEFAULT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_tipo_item ALTER COLUMN cod_tipo_item SET DEFAULT nextval('tb_tipo_item_cod_tipo_item_seq'::regclass);


--
-- Data for Name: tb_area_setor; Type: TABLE DATA; Schema: public; Owner: svc_sgrd
--

INSERT INTO tb_area_setor VALUES (1, 'Recursos Humanos');
INSERT INTO tb_area_setor VALUES (2, 'Tecnologia');
INSERT INTO tb_area_setor VALUES (3, 'Comercial');
INSERT INTO tb_area_setor VALUES (4, 'Jurídico');
INSERT INTO tb_area_setor VALUES (5, 'Atendimento ao Cliente');
INSERT INTO tb_area_setor VALUES (6, 'Administração e Finanças');


--
-- Name: tb_area_setor_cod_area_setor_seq; Type: SEQUENCE SET; Schema: public; Owner: svc_sgrd
--

SELECT pg_catalog.setval('tb_area_setor_cod_area_setor_seq', 6, true);


--
-- Data for Name: tb_empresa; Type: TABLE DATA; Schema: public; Owner: svc_sgrd
--

INSERT INTO tb_empresa VALUES (6, 'Ping Informática Ltda', '01001011000101', 'Mário Monteiro', '82', 'esq Ereneu Parm', 'Solar do Campo', 'Campo Bom', 'Rio Grande do Sul', '93700-000', 'N/A', '2019-04-12', '51993665549', 'contato@pinginformatica.com.br', 'Ping Informática', 'última compra em 22/02 está em aberto.
Contato Uiliam Mello');
INSERT INTO tb_empresa VALUES (9, 'Carlos e Julio Limpeza ME', '75727832000103', 'Rua Nove', '803', '', 'Marechal Rondon', 'Canoas', 'Rio Grande do Sul', '92025130', '2688601371', '2019-04-12', '5128708480', 'administracao@carlosejuliolimpezame.com.br', 'Clean Limpezas', 'Carlos 51 987609382');
INSERT INTO tb_empresa VALUES (19, 'João e Helena Transportes Ltda', '34563245000149', 'Travessa João Antoni', '750', 'esquina', 'Montanhão', 'São Bernardo do Campo', 'São Paulo', '09791255', '049380571467', '2019-05-09', '1137038468', 'estoque@joaoehelenatransportesltda.com.br', 'Transportadora JH', 'agdlkfdjjfadskjlsakj');
INSERT INTO tb_empresa VALUES (22, 'SGRD - Desenvolvimento de Software Ltda', '38.170.126/0001-87', 'Rua Vitória Régia', '987', '', 'Chác das Rosas', 'Cachoeirinha', 'Rio Grande do Sul', '94967-388', '602/0874862', '2019-06-06', '(51) 2749-0012', 'diretoria@sgrdsoftware.com.br', 'SGRD Software', 'Empresa controladora da aplicação SGRD - Masters somente cadastrados nela');


--
-- Name: tb_empresa_cod_empresa_seq; Type: SEQUENCE SET; Schema: public; Owner: svc_sgrd
--

SELECT pg_catalog.setval('tb_empresa_cod_empresa_seq', 22, true);


--
-- Data for Name: tb_etapa; Type: TABLE DATA; Schema: public; Owner: svc_sgrd
--

INSERT INTO tb_etapa VALUES (1, 'Em aprovação com gestor');
INSERT INTO tb_etapa VALUES (2, 'Em aprovação com financeiro');
INSERT INTO tb_etapa VALUES (3, 'Aguardando pagamento');
INSERT INTO tb_etapa VALUES (4, 'Pago');
INSERT INTO tb_etapa VALUES (5, 'Rascunho');
INSERT INTO tb_etapa VALUES (6, 'Reprovado');
INSERT INTO tb_etapa VALUES (7, 'Cancelado pelo solicitante');


--
-- Data for Name: tb_perfis; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tb_perfis VALUES (3, 'Gestor');
INSERT INTO tb_perfis VALUES (4, 'Financeiro');
INSERT INTO tb_perfis VALUES (5, 'Administrador');
INSERT INTO tb_perfis VALUES (6, 'Master');
INSERT INTO tb_perfis VALUES (2, 'Colaborador');


SELECT pg_catalog.setval('tb_perfis_cod_perfil_seq', 12, true);


--
-- Data for Name: tb_tipo_item; Type: TABLE DATA; Schema: public; Owner: svc_sgrd
--

INSERT INTO tb_tipo_item VALUES (1, 'Aluguel de veículos');
INSERT INTO tb_tipo_item VALUES (2, 'Material expediente');
INSERT INTO tb_tipo_item VALUES (3, 'Alimentação');
INSERT INTO tb_tipo_item VALUES (4, 'Aluguel imóvel');
INSERT INTO tb_tipo_item VALUES (5, 'Estacionamento');
INSERT INTO tb_tipo_item VALUES (6, 'Passagem aérea');
INSERT INTO tb_tipo_item VALUES (7, 'Despesa com veículos');
INSERT INTO tb_tipo_item VALUES (8, 'Despesas de bagagem');
INSERT INTO tb_tipo_item VALUES (9, 'Hospedagem');
INSERT INTO tb_tipo_item VALUES (10, 'Pedágios');
INSERT INTO tb_tipo_item VALUES (11, 'Incentivo à Educação');
INSERT INTO tb_tipo_item VALUES (12, 'Telefone');
INSERT INTO tb_tipo_item VALUES (18, 'Reembolso de cliente');


INSERT INTO tb_usuario VALUES ('mm446021', 'Master', 'Master', 6, 22, 2, '$2y$10$LYujCLQxhi7s0WFZll8h0eiyne0lOF6DcPMimQfJP6TKjuLPh36La', 'contato@pinginformatica.com.br', '729.544.460-21',
1);



--
-- Name: tb_tipo_item_cod_tipo_item_seq; Type: SEQUENCE SET; Schema: public; Owner: svc_sgrd
--

SELECT pg_catalog.setval('tb_tipo_item_cod_tipo_item_seq', 18, true);


--
-- Data for Name: tb_uf; Type: TABLE DATA; Schema: public; Owner: svc_sgrd
--

Insert into tb_uf (cod_uf, uf_ext, uf) values (12, 'Acre', 'AC');
Insert into tb_uf (cod_uf, uf_ext, uf) values (27, 'Alagoas', 'AL');
Insert into tb_uf (cod_uf, uf_ext, uf) values (16, 'Amapá', 'AP');
Insert into tb_uf (cod_uf, uf_ext, uf) values (13, 'Amazonas', 'AM');
Insert into tb_uf (cod_uf, uf_ext, uf) values (29, 'Bahia', 'BA');
Insert into tb_uf (cod_uf, uf_ext, uf) values (23, 'Ceará', 'CE');
Insert into tb_uf (cod_uf, uf_ext, uf) values (53, 'Distrito Federal', 'DF');
Insert into tb_uf (cod_uf, uf_ext, uf) values (32, 'Espírito Santo', 'ES');
Insert into tb_uf (cod_uf, uf_ext, uf) values (52, 'Goiás', 'GO');
Insert into tb_uf (cod_uf, uf_ext, uf) values (21, 'Maranhão', 'MA');
Insert into tb_uf (cod_uf, uf_ext, uf) values (51, 'Mato Grosso', 'MT');
Insert into tb_uf (cod_uf, uf_ext, uf) values (50, 'Mato Grosso do Sul', 'MS');
Insert into tb_uf (cod_uf, uf_ext, uf) values (31, 'Minas Gerais', 'MG');
Insert into tb_uf (cod_uf, uf_ext, uf) values (15, 'Pará', 'PA');
Insert into tb_uf (cod_uf, uf_ext, uf) values (25, 'Paraíba', 'PB');
Insert into tb_uf (cod_uf, uf_ext, uf) values (41, 'Paraná', 'PR');
Insert into tb_uf (cod_uf, uf_ext, uf) values (26, 'Pernambuco', 'PE');
Insert into tb_uf (cod_uf, uf_ext, uf) values (22, 'Piauí', 'PI');
Insert into tb_uf (cod_uf, uf_ext, uf) values (33, 'Rio de Janeiro', 'RJ');
Insert into tb_uf (cod_uf, uf_ext, uf) values (24, 'Rio Grande do Norte', 'RN');
Insert into tb_uf (cod_uf, uf_ext, uf) values (43, 'Rio Grande do Sul', 'RS');
Insert into tb_uf (cod_uf, uf_ext, uf) values (11, 'Rondônia', 'RO');
Insert into tb_uf (cod_uf, uf_ext, uf) values (14, 'Roraima', 'RR');
Insert into tb_uf (cod_uf, uf_ext, uf) values (42, 'Santa Catarina', 'SC');
Insert into tb_uf (cod_uf, uf_ext, uf) values (35, 'São Paulo', 'SP');
Insert into tb_uf (cod_uf, uf_ext, uf) values (28, 'Sergipe', 'SE');
Insert into tb_uf (cod_uf, uf_ext, uf) values (17, 'Tocantins', 'TO');

--
-- Name: tb_area_setor_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_area_setor
    ADD CONSTRAINT tb_area_setor_pkey PRIMARY KEY (cod_area_setor);


--
-- Name: tb_empresa_cnpj_empresa_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_empresa
    ADD CONSTRAINT tb_empresa_cnpj_empresa_key UNIQUE (cnpj_empresa);


--
-- Name: tb_empresa_nome_empresa_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_empresa
    ADD CONSTRAINT tb_empresa_nome_empresa_key UNIQUE (razao_social);


--
-- Name: tb_empresa_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_empresa
    ADD CONSTRAINT tb_empresa_pkey PRIMARY KEY (cod_empresa);


--
-- Name: tb_etapa_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_etapa
    ADD CONSTRAINT tb_etapa_pkey PRIMARY KEY (cod_etapa);


--
-- Name: tb_itens_pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_itens_pedido
    ADD CONSTRAINT tb_itens_pedido_pkey PRIMARY KEY (cod_item_pedido);


--
-- Name: tb_logs_pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_logs_pedidos
    ADD CONSTRAINT tb_logs_pedidos_pkey PRIMARY KEY (id_logs_pedidos);


--
-- Name: tb_pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_pedidos
    ADD CONSTRAINT tb_pedidos_pkey PRIMARY KEY (cod_pedido);


--
-- Name: tb_perfis_desc_perfil_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tb_perfis
    ADD CONSTRAINT tb_perfis_desc_perfil_key UNIQUE (desc_perfil);


--
-- Name: tb_perfis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tb_perfis
    ADD CONSTRAINT tb_perfis_pkey PRIMARY KEY (cod_perfil);


--
-- Name: tb_tipo_item_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_tipo_item
    ADD CONSTRAINT tb_tipo_item_pkey PRIMARY KEY (cod_tipo_item);


--
-- Name: tb_tipo_item_tipo_item_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_tipo_item
    ADD CONSTRAINT tb_tipo_item_tipo_item_key UNIQUE (tipo_item);


--
-- Name: tb_uf_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_uf
    ADD CONSTRAINT tb_uf_pkey PRIMARY KEY (cod_uf);


--
-- Name: tb_uf_uf_ext_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_uf
    ADD CONSTRAINT tb_uf_uf_ext_key UNIQUE (uf_ext);


--
-- Name: tb_uf_uf_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_uf
    ADD CONSTRAINT tb_uf_uf_key UNIQUE (uf);


--
-- Name: tb_usuario_cpf_usuario_key; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT tb_usuario_cpf_usuario_key UNIQUE (cpf_usuario);


--
-- Name: tb_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: svc_sgrd; Tablespace: 
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT tb_usuario_pkey PRIMARY KEY (cod_usuario);


--
-- Name: fk_cod_perfil; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT fk_cod_perfil FOREIGN KEY (cod_perfil) REFERENCES tb_perfis(cod_perfil);


--
-- Name: fk_tb_itens_pedido_cod_tipo_item; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_itens_pedido
    ADD CONSTRAINT fk_tb_itens_pedido_cod_tipo_item FOREIGN KEY (cod_tipo_item) REFERENCES tb_tipo_item(cod_tipo_item);


--
-- Name: fk_tb_logs_pedidos_cod_pedido; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_logs_pedidos
    ADD CONSTRAINT fk_tb_logs_pedidos_cod_pedido FOREIGN KEY (cod_pedido) REFERENCES tb_pedidos(cod_pedido);


--
-- Name: fk_tb_logs_pedidos_cod_usuario; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_logs_pedidos
    ADD CONSTRAINT fk_tb_logs_pedidos_cod_usuario FOREIGN KEY (cod_usuario) REFERENCES tb_usuario(cod_usuario);


--
-- Name: fk_tb_pedidos_cod_empresa; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_pedidos
    ADD CONSTRAINT fk_tb_pedidos_cod_empresa FOREIGN KEY (cod_empresa) REFERENCES tb_empresa(cod_empresa);


--
-- Name: fk_tb_pedidos_cod_etapa; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_pedidos
    ADD CONSTRAINT fk_tb_pedidos_cod_etapa FOREIGN KEY (cod_etapa) REFERENCES tb_etapa(cod_etapa);


--
-- Name: fk_tb_pedidos_cod_solicitante; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_pedidos
    ADD CONSTRAINT fk_tb_pedidos_cod_solicitante FOREIGN KEY (cod_solicitante) REFERENCES tb_usuario(cod_usuario);


--
-- Name: fk_usuario_cod_area_setor; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT fk_usuario_cod_area_setor FOREIGN KEY (cod_area_setor) REFERENCES tb_area_setor(cod_area_setor);


--
-- Name: fk_usuario_cod_empresa; Type: FK CONSTRAINT; Schema: public; Owner: svc_sgrd
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT fk_usuario_cod_empresa FOREIGN KEY (cod_empresa) REFERENCES tb_empresa(cod_empresa);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: tb_area_setor; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_area_setor FROM PUBLIC;
REVOKE ALL ON TABLE tb_area_setor FROM svc_sgrd;
GRANT ALL ON TABLE tb_area_setor TO svc_sgrd;


--
-- Name: tb_empresa; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_empresa FROM PUBLIC;
REVOKE ALL ON TABLE tb_empresa FROM svc_sgrd;
GRANT ALL ON TABLE tb_empresa TO svc_sgrd;


--
-- Name: tb_empresa_cod_empresa_seq; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON SEQUENCE tb_empresa_cod_empresa_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tb_empresa_cod_empresa_seq FROM svc_sgrd;
GRANT ALL ON SEQUENCE tb_empresa_cod_empresa_seq TO svc_sgrd;


--
-- Name: tb_itens_pedido; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_itens_pedido FROM PUBLIC;
REVOKE ALL ON TABLE tb_itens_pedido FROM svc_sgrd;
GRANT ALL ON TABLE tb_itens_pedido TO svc_sgrd;


--
-- Name: tb_itens_pedido_cod_item_pedido_seq; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON SEQUENCE tb_itens_pedido_cod_item_pedido_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tb_itens_pedido_cod_item_pedido_seq FROM svc_sgrd;
GRANT ALL ON SEQUENCE tb_itens_pedido_cod_item_pedido_seq TO svc_sgrd;


--
-- Name: tb_logs_pedidos; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_logs_pedidos FROM PUBLIC;
REVOKE ALL ON TABLE tb_logs_pedidos FROM svc_sgrd;
GRANT ALL ON TABLE tb_logs_pedidos TO svc_sgrd;


--
-- Name: tb_logs_pedidos_id_logs_pedidos_seq; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON SEQUENCE tb_logs_pedidos_id_logs_pedidos_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tb_logs_pedidos_id_logs_pedidos_seq FROM svc_sgrd;
GRANT ALL ON SEQUENCE tb_logs_pedidos_id_logs_pedidos_seq TO svc_sgrd;


--
-- Name: tb_pedidos; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_pedidos FROM PUBLIC;
REVOKE ALL ON TABLE tb_pedidos FROM svc_sgrd;
GRANT ALL ON TABLE tb_pedidos TO svc_sgrd;


--
-- Name: tb_perfis; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE tb_perfis FROM PUBLIC;
REVOKE ALL ON TABLE tb_perfis FROM postgres;
GRANT ALL ON TABLE tb_perfis TO postgres;
GRANT ALL ON TABLE tb_perfis TO svc_sgrd;


--
-- Name: tb_perfis_cod_perfil_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE tb_perfis_cod_perfil_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tb_perfis_cod_perfil_seq FROM postgres;
GRANT ALL ON SEQUENCE tb_perfis_cod_perfil_seq TO postgres;
GRANT ALL ON SEQUENCE tb_perfis_cod_perfil_seq TO svc_sgrd;


--
-- Name: tb_tipo_item; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_tipo_item FROM PUBLIC;
REVOKE ALL ON TABLE tb_tipo_item FROM svc_sgrd;
GRANT ALL ON TABLE tb_tipo_item TO svc_sgrd;


--
-- Name: tb_tipo_item_cod_tipo_item_seq; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON SEQUENCE tb_tipo_item_cod_tipo_item_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tb_tipo_item_cod_tipo_item_seq FROM svc_sgrd;
GRANT ALL ON SEQUENCE tb_tipo_item_cod_tipo_item_seq TO svc_sgrd;


--
-- Name: tb_uf; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_uf FROM PUBLIC;
REVOKE ALL ON TABLE tb_uf FROM svc_sgrd;
GRANT ALL ON TABLE tb_uf TO svc_sgrd;


--
-- Name: tb_usuario; Type: ACL; Schema: public; Owner: svc_sgrd
--

REVOKE ALL ON TABLE tb_usuario FROM PUBLIC;
REVOKE ALL ON TABLE tb_usuario FROM svc_sgrd;
GRANT ALL ON TABLE tb_usuario TO svc_sgrd;


--
-- PostgreSQL database dump complete
--

