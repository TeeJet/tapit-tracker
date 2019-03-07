--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.11
-- Dumped by pg_dump version 11.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;
--
-- Name: tracker; Type: DATABASE; Schema: -; Owner: ubuntu
--


ALTER DATABASE tracker OWNER TO ubuntu;

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: coordinates; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.coordinates (
    id integer NOT NULL,
    lat double precision,
    lng double precision,
    device_id integer NOT NULL,
    created_at integer
);


ALTER TABLE public.coordinates OWNER TO ubuntu;

--
-- Name: coordinates_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.coordinates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.coordinates_id_seq OWNER TO ubuntu;

--
-- Name: coordinates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ubuntu
--

ALTER SEQUENCE public.coordinates_id_seq OWNED BY public.coordinates.id;


--
-- Name: devices; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.devices (
    id integer NOT NULL,
    name character varying,
    created_at integer
);


ALTER TABLE public.devices OWNER TO ubuntu;

--
-- Name: devices_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.devices_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.devices_id_seq OWNER TO ubuntu;

--
-- Name: devices_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ubuntu
--

ALTER SEQUENCE public.devices_id_seq OWNED BY public.devices.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying,
    password character varying,
    created_at integer
);


ALTER TABLE public.users OWNER TO ubuntu;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO ubuntu;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ubuntu
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: coordinates id; Type: DEFAULT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.coordinates ALTER COLUMN id SET DEFAULT nextval('public.coordinates_id_seq'::regclass);


--
-- Name: devices id; Type: DEFAULT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.devices ALTER COLUMN id SET DEFAULT nextval('public.devices_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: coordinates; Type: TABLE DATA; Schema: public; Owner: ubuntu
--



--
-- Data for Name: devices; Type: TABLE DATA; Schema: public; Owner: ubuntu
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: ubuntu
--



--
-- Name: coordinates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.coordinates_id_seq', 1, false);


--
-- Name: devices_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.devices_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: coordinates coordinates_pk; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.coordinates
    ADD CONSTRAINT coordinates_pk PRIMARY KEY (id);


--
-- Name: devices devices_pk; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.devices
    ADD CONSTRAINT devices_pk PRIMARY KEY (id);


--
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- Name: coordinates_id_uindex; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE UNIQUE INDEX coordinates_id_uindex ON public.coordinates USING btree (id);


--
-- Name: devices_id_uindex; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE UNIQUE INDEX devices_id_uindex ON public.devices USING btree (id);


--
-- Name: users_id_uindex; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE UNIQUE INDEX users_id_uindex ON public.users USING btree (id);


--
-- Name: coordinates fk-coordinates_device_id; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.coordinates
    ADD CONSTRAINT "fk-coordinates_device_id" FOREIGN KEY (device_id) REFERENCES public.devices(id);


--
-- PostgreSQL database dump complete
--

