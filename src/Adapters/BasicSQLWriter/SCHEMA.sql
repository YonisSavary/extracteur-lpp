DROP TABLE IF EXISTS lpp_incompatibilite;
DROP TABLE IF EXISTS lpp_compatibilite;
DROP TABLE IF EXISTS lpp_code_prix;
DROP TABLE IF EXISTS lpp_code;


CREATE TABLE lpp_code (
    code VARCHAR(13) PRIMARY KEY,
    libelle VARCHAR(80) NOT NULL,

    fin_validite DATE NULL,
    age_maximal SMALLINT NULL,
    type_prestation CHAR,
    indication_medicale BOOLEAN
);

CREATE TABLE lpp_code_prix (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fk_code VARCHAR(13) NOT NULL,

    debut_validite DATE NULL,
    fin_validite DATE NULL,

    nature_prestation VARCHAR(3) NULL,
    entente_prealable BOOLEAN,
    date_arrete DATE,
    date_publication DATE,

    indication_pu_devis BOOLEAN,
    tarif_reference DECIMAL(8,2),

    majoration_971 DECIMAL(3,3),
    majoration_972 DECIMAL(3,3),
    majoration_973 DECIMAL(3,3),
    majoration_974 DECIMAL(3,3),
    majoration_975 DECIMAL(3,3),
    majoration_976 DECIMAL(3,3),

    quantite_maximale TINYINT NULL,

    montant_maximal DECIMAL(8,2),
    prix_unitaire DECIMAL(8,2),

    CONSTRAINT FOREIGN KEY (fk_code) REFERENCES lpp_code(code) ON DELETE CASCADE
);


CREATE TABLE lpp_incompatibilite (
    code VARCHAR(13) NOT NULL,
    reference VARCHAR(13) NOT NULL,

    CONSTRAINT FOREIGN KEY (code) REFERENCES lpp_code(code) ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (reference) REFERENCES lpp_code(code) ON DELETE CASCADE
);

CREATE TABLE lpp_compatibilite (
    code VARCHAR(13) NOT NULL,
    reference VARCHAR(13) NOT NULL,

    CONSTRAINT FOREIGN KEY (code) REFERENCES lpp_code(code) ON DELETE CASCADE,
    CONSTRAINT FOREIGN KEY (reference) REFERENCES lpp_code(code) ON DELETE CASCADE
);