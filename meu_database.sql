create table teste;
CREATE TABLE anuidade (
    id SERIAL PRIMARY KEY,
    anoAnu TEXT NOT NULL,
    valor TEXT
);

CREATE TABLE associado (
    id SERIAL PRIMARY KEY,
    nome TEXT NOT NULL,
    email TEXT,
    cpf TEXT,
    datafiliacao DATE,
	ano VARCHAR(100)
);

CREATE TABLE pagamento (
    id SERIAL PRIMARY KEY,
    id_associado INT REFERENCES associado(id),
    id_anuidade INT REFERENCES anuidade(id),
    data_pagamento DATE DEFAULT CURRENT_DATE,
    pago BOOLEAN DEFAULT FALSE
);