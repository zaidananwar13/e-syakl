--
-- PostgreSQL database dump
--

-- Dumped from database version 13.4 (Ubuntu 13.4-1.pgdg20.04+1)
-- Dumped by pg_dump version 13.4 (Ubuntu 13.4-1.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO esyakl_dba;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO esyakl_dba;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: instansi; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.instansi (
    id_instansi integer NOT NULL,
    nama character varying(255) NOT NULL,
    lokasi character varying(255) NOT NULL,
    foto character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.instansi OWNER TO esyakl_dba;

--
-- Name: instansi_id_instansi_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.instansi_id_instansi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.instansi_id_instansi_seq OWNER TO esyakl_dba;

--
-- Name: instansi_id_instansi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.instansi_id_instansi_seq OWNED BY public.instansi.id_instansi;


--
-- Name: kategori; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.kategori (
    id_kategori integer NOT NULL,
    judul character varying(255) NOT NULL,
    gambar character varying(255) NOT NULL,
    deskripsi character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kategori OWNER TO esyakl_dba;

--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.kategori_id_kategori_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kategori_id_kategori_seq OWNER TO esyakl_dba;

--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.kategori_id_kategori_seq OWNED BY public.kategori.id_kategori;


--
-- Name: kategori_silabus; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.kategori_silabus (
    id_kategori_silabus integer NOT NULL,
    id_kelas integer NOT NULL,
    judul character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kategori_silabus OWNER TO esyakl_dba;

--
-- Name: kategori_silabus_id_kategori_silabus_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.kategori_silabus_id_kategori_silabus_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kategori_silabus_id_kategori_silabus_seq OWNER TO esyakl_dba;

--
-- Name: kategori_silabus_id_kategori_silabus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.kategori_silabus_id_kategori_silabus_seq OWNED BY public.kategori_silabus.id_kategori_silabus;


--
-- Name: kelas; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.kelas (
    id_kelas integer NOT NULL,
    id_kategori integer NOT NULL,
    id_reviewer integer NOT NULL,
    judul character varying(255) NOT NULL,
    gambar character varying(255) NOT NULL,
    langkah character varying(255) NOT NULL,
    level character varying(255) NOT NULL,
    deskripsi_singkat character varying(255) NOT NULL,
    durasi character varying(255) NOT NULL,
    deskripsi_kelas character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kelas OWNER TO esyakl_dba;

--
-- Name: kelas_id_kelas_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.kelas_id_kelas_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kelas_id_kelas_seq OWNER TO esyakl_dba;

--
-- Name: kelas_id_kelas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.kelas_id_kelas_seq OWNED BY public.kelas.id_kelas;


--
-- Name: kelas_user; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.kelas_user (
    id_kelas_user integer NOT NULL,
    id_user integer NOT NULL,
    id_kelas integer NOT NULL,
    point_review character varying(255) NOT NULL,
    komentar_review character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kelas_user OWNER TO esyakl_dba;

--
-- Name: kelas_user_id_kelas_user_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.kelas_user_id_kelas_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kelas_user_id_kelas_user_seq OWNER TO esyakl_dba;

--
-- Name: kelas_user_id_kelas_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.kelas_user_id_kelas_user_seq OWNED BY public.kelas_user.id_kelas_user;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO esyakl_dba;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO esyakl_dba;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO esyakl_dba;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO esyakl_dba;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO esyakl_dba;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: reviewer; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.reviewer (
    id_reviewer integer NOT NULL,
    nama character varying(255) NOT NULL,
    foto character varying(255) NOT NULL,
    jabatan character varying(255) NOT NULL,
    portofolio character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.reviewer OWNER TO esyakl_dba;

--
-- Name: reviewer_id_reviewer_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.reviewer_id_reviewer_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviewer_id_reviewer_seq OWNER TO esyakl_dba;

--
-- Name: reviewer_id_reviewer_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.reviewer_id_reviewer_seq OWNED BY public.reviewer.id_reviewer;


--
-- Name: sub_kategori_silabus; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.sub_kategori_silabus (
    id_sub_kategori_silabus integer NOT NULL,
    id_kategori_silabus integer NOT NULL,
    judul character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.sub_kategori_silabus OWNER TO esyakl_dba;

--
-- Name: sub_kategori_silabus_id_sub_kategori_silabus_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.sub_kategori_silabus_id_sub_kategori_silabus_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sub_kategori_silabus_id_sub_kategori_silabus_seq OWNER TO esyakl_dba;

--
-- Name: sub_kategori_silabus_id_sub_kategori_silabus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.sub_kategori_silabus_id_sub_kategori_silabus_seq OWNED BY public.sub_kategori_silabus.id_sub_kategori_silabus;


--
-- Name: user; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public."user" (
    id_user integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public."user" OWNER TO esyakl_dba;

--
-- Name: user_id_user_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.user_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_user_seq OWNER TO esyakl_dba;

--
-- Name: user_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.user_id_user_seq OWNED BY public."user".id_user;


--
-- Name: users; Type: TABLE; Schema: public; Owner: esyakl_dba
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO esyakl_dba;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: esyakl_dba
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO esyakl_dba;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: esyakl_dba
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: instansi id_instansi; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.instansi ALTER COLUMN id_instansi SET DEFAULT nextval('public.instansi_id_instansi_seq'::regclass);


--
-- Name: kategori id_kategori; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kategori ALTER COLUMN id_kategori SET DEFAULT nextval('public.kategori_id_kategori_seq'::regclass);


--
-- Name: kategori_silabus id_kategori_silabus; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kategori_silabus ALTER COLUMN id_kategori_silabus SET DEFAULT nextval('public.kategori_silabus_id_kategori_silabus_seq'::regclass);


--
-- Name: kelas id_kelas; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas ALTER COLUMN id_kelas SET DEFAULT nextval('public.kelas_id_kelas_seq'::regclass);


--
-- Name: kelas_user id_kelas_user; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas_user ALTER COLUMN id_kelas_user SET DEFAULT nextval('public.kelas_user_id_kelas_user_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: reviewer id_reviewer; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.reviewer ALTER COLUMN id_reviewer SET DEFAULT nextval('public.reviewer_id_reviewer_seq'::regclass);


--
-- Name: sub_kategori_silabus id_sub_kategori_silabus; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.sub_kategori_silabus ALTER COLUMN id_sub_kategori_silabus SET DEFAULT nextval('public.sub_kategori_silabus_id_sub_kategori_silabus_seq'::regclass);


--
-- Name: user id_user; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public."user" ALTER COLUMN id_user SET DEFAULT nextval('public.user_id_user_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: instansi; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.instansi (id_instansi, nama, lokasi, foto, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: kategori; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.kategori (id_kategori, judul, gambar, deskripsi, created_at, updated_at) FROM stdin;
12	Shorof	20210917045557.jpg	Belajar Bahasa Arab Shorof dengan 75% Praktik 25% Teori	\N	\N
11	Nahwu	20210917045224.png	Belajar Nahwu dengan Pembelajaran yang bahagia dan ceria	\N	\N
13	Calligraphy	20210917064418.png	Belajar Kaligrafi bersama E-Syakl	\N	\N
\.


--
-- Data for Name: kategori_silabus; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.kategori_silabus (id_kategori_silabus, id_kelas, judul, created_at, updated_at) FROM stdin;
11	4	Persiapan Belajar	\N	\N
12	4	Pendahuluan	\N	\N
\.


--
-- Data for Name: kelas; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.kelas (id_kelas, id_kategori, id_reviewer, judul, gambar, langkah, level, deskripsi_singkat, durasi, deskripsi_kelas, created_at, updated_at) FROM stdin;
4	11	11	Beginner Nahwu Class	20210917050613.jpeg	3 Langkah	Pemula	Belajar Nahwu Dasar dengan Cepat	2 Jam	Materi Nahwu untuk pemula untuk mampu memahami tata bahasa pada kalimat sederhana dalam Bahasa Arab	\N	\N
5	12	11	Beginner Shorof Class	20210917060134.jpeg	4 Langkah	Pemula	Belajar Shorof, memahami lebih lanjut penggunaan huruf pada bahasa Arab	3 Jam	Materi Shorof tahap pemula untuk mampu memahami pola perubahan pada bentuk kata yang sering dijumpai dalam Bahasa Arab	\N	\N
6	13	11	Beginner Calligraphy Class	20210917064616.png	4 Langkah	Pemula	Kelas Kaligrafi Dasar	5 Jam	Belajar Kaligrafi Dasar dengan cepat dan mudah	\N	\N
\.


--
-- Data for Name: kelas_user; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.kelas_user (id_kelas_user, id_user, id_kelas, point_review, komentar_review, created_at, updated_at) FROM stdin;
11	7	4	5	Pembelajaran kini menjadi lebih mudah bersama E-Syakl	\N	\N
12	7	5	4	Belajar kelas bahasa arab di E-Syakl sangat menyenangkan, untuk tim E-Syakl semoga menjadi lebih baik lagi dalam membangun aplikasi pembelajaran bahasa arab di Indonesia.	\N	\N
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2019_12_14_000001_create_personal_access_tokens_table	1
5	2021_09_08_022642_instansi	1
6	2021_09_08_023558_reviewer	1
7	2021_09_08_023658_kategori	1
8	2021_09_08_023759_user	1
9	2021_09_08_023900_kelas	1
10	2021_09_08_025838_kelas_user	1
11	2021_09_08_030052_kategori_silabus	1
12	2021_09_08_030234_sub_kategori_silabus	1
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: reviewer; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.reviewer (id_reviewer, nama, foto, jabatan, portofolio, created_at, updated_at) FROM stdin;
11	Farhan Naufaldy	20210917050023.png	Ketua Reviewer	Banyak	\N	\N
\.


--
-- Data for Name: sub_kategori_silabus; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.sub_kategori_silabus (id_sub_kategori_silabus, id_kategori_silabus, judul, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public."user" (id_user, username, password, created_at, updated_at) FROM stdin;
7	nocty	$2y$10$cI9ag9AcAYzOcDNb/cpyxu/HlDAGpnmccU.e0Qt8BgXHKvDfRRqYa	2021-09-16 08:24:01	2021-09-16 08:24:01
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: esyakl_dba
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: instansi_id_instansi_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.instansi_id_instansi_seq', 1, false);


--
-- Name: kategori_id_kategori_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.kategori_id_kategori_seq', 13, true);


--
-- Name: kategori_silabus_id_kategori_silabus_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.kategori_silabus_id_kategori_silabus_seq', 12, true);


--
-- Name: kelas_id_kelas_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.kelas_id_kelas_seq', 6, true);


--
-- Name: kelas_user_id_kelas_user_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.kelas_user_id_kelas_user_seq', 12, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: reviewer_id_reviewer_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.reviewer_id_reviewer_seq', 11, true);


--
-- Name: sub_kategori_silabus_id_sub_kategori_silabus_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.sub_kategori_silabus_id_sub_kategori_silabus_seq', 1, false);


--
-- Name: user_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.user_id_user_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: esyakl_dba
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: instansi instansi_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.instansi
    ADD CONSTRAINT instansi_pkey PRIMARY KEY (id_instansi);


--
-- Name: kategori kategori_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kategori
    ADD CONSTRAINT kategori_pkey PRIMARY KEY (id_kategori);


--
-- Name: kategori_silabus kategori_silabus_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kategori_silabus
    ADD CONSTRAINT kategori_silabus_pkey PRIMARY KEY (id_kategori_silabus);


--
-- Name: kelas kelas_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_pkey PRIMARY KEY (id_kelas);


--
-- Name: kelas_user kelas_user_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas_user
    ADD CONSTRAINT kelas_user_pkey PRIMARY KEY (id_kelas_user);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: reviewer reviewer_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.reviewer
    ADD CONSTRAINT reviewer_pkey PRIMARY KEY (id_reviewer);


--
-- Name: sub_kategori_silabus sub_kategori_silabus_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.sub_kategori_silabus
    ADD CONSTRAINT sub_kategori_silabus_pkey PRIMARY KEY (id_sub_kategori_silabus);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id_user);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: esyakl_dba
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: esyakl_dba
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: kategori_silabus kategori_silabus_id_kelas_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kategori_silabus
    ADD CONSTRAINT kategori_silabus_id_kelas_foreign FOREIGN KEY (id_kelas) REFERENCES public.kelas(id_kelas);


--
-- Name: kelas kelas_id_kategori_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_id_kategori_foreign FOREIGN KEY (id_kategori) REFERENCES public.kategori(id_kategori);


--
-- Name: kelas kelas_id_reviewer_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_id_reviewer_foreign FOREIGN KEY (id_reviewer) REFERENCES public.reviewer(id_reviewer);


--
-- Name: kelas_user kelas_user_id_kelas_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas_user
    ADD CONSTRAINT kelas_user_id_kelas_foreign FOREIGN KEY (id_kelas) REFERENCES public.kelas(id_kelas);


--
-- Name: kelas_user kelas_user_id_user_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.kelas_user
    ADD CONSTRAINT kelas_user_id_user_foreign FOREIGN KEY (id_user) REFERENCES public."user"(id_user);


--
-- Name: sub_kategori_silabus sub_kategori_silabus_id_kategori_silabus_foreign; Type: FK CONSTRAINT; Schema: public; Owner: esyakl_dba
--

ALTER TABLE ONLY public.sub_kategori_silabus
    ADD CONSTRAINT sub_kategori_silabus_id_kategori_silabus_foreign FOREIGN KEY (id_kategori_silabus) REFERENCES public.kategori_silabus(id_kategori_silabus);


--
-- PostgreSQL database dump complete
--

