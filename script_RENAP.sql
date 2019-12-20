
CREATE SCHEMA IF NOT EXISTS RENAPDB DEFAULT CHARACTER SET latin7;
USE RENAPDB ;

DROP TABLE IF EXISTS RENAP.Departamento;
-- -----------------------------------------------------
-- Table Departamento
-- -----------------------------------------------------
CREATE TABLE Departamento(
  id_departamento INT AUTO_INCREMENT NOT NULL,
  Nombre_departamento VARCHAR(45) NOT NULL,
  codigo_departamento VARCHAR(4) NOT NULL,
  PRIMARY KEY (id_departamento));

DROP TABLE IF EXISTS RENAP.Municipio;
-- -----------------------------------------------------
-- Table Municipio
-- -----------------------------------------------------
CREATE TABLE Municipio(
  id_municipio INT AUTO_INCREMENT NOT NULL,
  Nombre_municipio VARCHAR(45) NOT NULL,
  codigo_municipio VARCHAR(4) NOT NULL,
  Departamento_id_departamento INT NOT NULL,
  PRIMARY KEY (id_municipio),
  FOREIGN KEY (Departamento_id_departamento) REFERENCES Departamento(id_departamento));

DROP TABLE IF EXISTS RENAP.Persona;
-- -----------------------------------------------------
-- Table Persona
-- -----------------------------------------------------
CREATE TABLE Persona(
  id_persona INT AUTO_INCREMENT NOT NULL,
  DPI BIGINT NULL,
  passw VARCHAR(45) NULL,
  Nombre VARCHAR(45) NOT NULL,
  Apellido VARCHAR(45) NOT NULL,
  Genero VARCHAR(10) NOT NULL,
  Estado_Civil VARCHAR(15) NOT NULL,
  Fecha_nacimiento VARCHAR(45) NOT NULL,
  Municipio_id_municipio INT NOT NULL,
  PRIMARY KEY (id_persona),
  FOREIGN KEY (Municipio_id_municipio) REFERENCES Municipio(id_municipio));

DROP TABLE IF EXISTS RENAP.Matrimonio;
-- -----------------------------------------------------
-- Table Matrimonio
-- -----------------------------------------------------
CREATE TABLE Matrimonio(
  id_matrimonio INT AUTO_INCREMENT NOT NULL,
  fecha_matrimonio VARCHAR(45) NOT NULL,
  Estado_Matrimonio VARCHAR(15) NOT NULL,
  Persona_id_Esposa INT NOT NULL,
  Persona_id_Esposo INT NOT NULL,
  PRIMARY KEY (id_matrimonio),
  FOREIGN KEY (Persona_id_Esposa) REFERENCES Persona(id_persona),
  FOREIGN KEY (Persona_id_Esposo) REFERENCES Persona(id_persona));

DROP TABLE IF EXISTS RENAP.Defuncion;
-- -----------------------------------------------------
-- Table Defuncion
-- -----------------------------------------------------
CREATE TABLE Defuncion(
  id_defuncion INT AUTO_INCREMENT NOT NULL,
  Persona_id_persona INT NOT NULL,
  fecha VARCHAR(45) NOT NULL,
  PRIMARY KEY (id_defuncion),
  FOREIGN KEY (Persona_id_persona) REFERENCES Persona(id_persona));

DROP TABLE IF EXISTS RENAP.Tipo_Licencia;
-- -----------------------------------------------------
-- Table Tipo_Licencia
-- -----------------------------------------------------
CREATE TABLE Tipo_Licencia(
  id_tipo_licencia INT AUTO_INCREMENT NOT NULL,
  Descripcion VARCHAR(45) NOT NULL,
  Descripcion_Letra VARCHAR(1) NOT NULL,
  PRIMARY KEY (id_tipo_licencia));

DROP TABLE IF EXISTS RENAP.Asignacion_licencia;
-- -----------------------------------------------------
-- Table Asignacion_licencia
-- -----------------------------------------------------
CREATE TABLE Asignacion_licencia(
  idAsignacion_licencia INT AUTO_INCREMENT NOT NULL,
  Fecha_asignacion VARCHAR(45) NOT NULL,
  Persona_id_persona INT NOT NULL,
  Tipo_Licencia_id_tipo_licencia INT NOT NULL,
  PRIMARY KEY (idAsignacion_licencia),
  FOREIGN KEY (Persona_id_persona) REFERENCES Persona(id_persona),
  FOREIGN KEY (Tipo_Licencia_id_tipo_licencia) REFERENCES Tipo_Licencia(id_tipo_licencia));

DROP TABLE IF EXISTS RENAP.Asignacion_Tutor;
-- -----------------------------------------------------
-- Table Asignacion_Tutor
-- -----------------------------------------------------
CREATE TABLE Asignacion_Tutor(
  id_asignacion_tutor INT AUTO_INCREMENT NOT NULL,
  Persona_id_persona INT NOT NULL,
  Persona_id_tutora INT NOT NULL,
  Persona_id_tutor INT NOT NULL,
  PRIMARY KEY (id_asignacion_tutor),
  FOREIGN KEY (Persona_id_persona) REFERENCES Persona(id_persona),
  FOREIGN KEY (Persona_id_tutora) REFERENCES Persona(id_persona),
  FOREIGN KEY (Persona_id_tutor) REFERENCES Persona(id_persona));

-- -----------------------------------------------------
-- Table Temporal_Depa-Muni
-- -----------------------------------------------------
CREATE TABLE Temporal_depa_muni(
  codigo_departamento VARCHAR(45),
  nombre_departamento VARCHAR(45),
  codigo_municipio VARCHAR(45),
  nombre_municipio VARCHAR(45)
);

CREATE TABLE Temporal_persona(
  dpi BIGINT,
  pass VARCHAR(45),
  nombre VARCHAR(45),
  apellido VARCHAR(45),
  genero VARCHAR(10),
  estado_civil VARCHAR(15),
  fecha_nac VARCHAR(45),
  codigo_municipio VARCHAR(4)
);

-- -----------------------------------------------------
-- carga masiva
-- -----------------------------------------------------
/*
LOAD DATA INFILE 'c:/DeptoMuni_RENAP.csv' 
INTO TABLE Temporal_depa_muni 
FIELDS TERMINATED BY ';' 
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'c:/Persona_RENAP.csv' 
INTO TABLE Temporal_persona 
FIELDS TERMINATED BY ';' 
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
*/
-- -----------------------------------------------------
-- insertar Departamento-Municipio
-- -----------------------------------------------------

insert into Departamento(Nombre_departamento,codigo_departamento)
select distinct t.nombre_departamento, t.codigo_departamento
from Temporal_depa_muni as t;

insert into Municipio(Nombre_municipio,codigo_municipio,Departamento_id_departamento)
select t.nombre_municipio, t.codigo_municipio, d.id_departamento 
from Temporal_depa_muni as t, Departamento as d
where t.codigo_departamento = d.codigo_departamento;

-- -----------------------------------------------------
-- insertar personas
-- ----------------------------------------------------- 

insert into Persona(DPI,passw,Nombre,Apellido,Genero,Estado_Civil,Fecha_nacimiento,Municipio_id_municipio)
select t.dpi, t.pass,t.nombre,t.apellido,t.genero,t.estado_civil,t.fecha_nac, m.id_municipio
from Temporal_persona as t, Municipio as m
where t.codigo_municipio = m.codigo_municipio;
