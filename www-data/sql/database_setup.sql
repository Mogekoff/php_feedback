CREATE TABLE public.creds
(
    id bigint NOT NULL DEFAULT nextval('creds_id_seq'::regclass),
    email character varying(254) COLLATE pg_catalog."default" NOT NULL,
    phone character varying(12) COLLATE pg_catalog."default" NOT NULL,
    message character varying(1000) COLLATE pg_catalog."default",
    CONSTRAINT creds_pkey PRIMARY KEY (id)
)

    TABLESPACE pg_default;

ALTER TABLE public.creds
    OWNER to postgres;