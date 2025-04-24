# JobConnect RD - Plataforma de Empleos

**JobConnect RD** es una aplicación web desarrollada en **PHP** y **MySQL** que conecta candidatos en busca de empleo con empresas que publican ofertas laborales en la República Dominicana. Cumple con todos los requisitos del proyecto, permitiendo a los candidatos registrarse, crear un currículum digital con más de 15 campos, aplicar a ofertas, y a las empresas registrarse, publicar ofertas y revisar aplicaciones. Desplegada localmente con **XAMPP**, la plataforma es intuitiva, segura y visualmente atractiva, con un diseño coherente y responsive.

## 👥 Roles

### 1. Candidatos

- **Registro**:
    - Campos: Nombre, Apellido, Correo Electrónico, Contraseña.
    - Implementado en `general/Login_y_Registro/registro.php` con validación de correo único y hash de contraseñas (`password_hash()`).
- **Currículum Digital**:
    - Gestionado en `panel_candidatos/curriculum.php`.
    - **15+ campos** almacenados en las tablas `Candidatos`, `Formaciones_Academicas`, `Experiencias_Laborales`, `Habilidades`, `Idiomas`, `Logros_Proyectos`, y `Referencias`:
        1. Nombre(s) (`Usuarios.nombre`)
        2. Apellido(s) (`Usuarios.apellido`)
        3. Correo Electrónico (`Usuarios.correo`)
        4. Teléfono (`Candidatos.telefono`)
        5. Dirección (`Candidatos.direccion`)
        6. Ciudad/Provincia (`Candidatos.ciudad`)
        7. Formación Académica: Institución, Título, Fecha Inicio, Fecha Fin (`Formaciones_Academicas`)
        8. Experiencia Laboral: Empresa, Puesto, Fecha Inicio, Fecha Fin (`Experiencias_Laborales`)
        9. Habilidades Clave (`Habilidades.habilidad`)
        10. Idiomas: Idioma, Nivel (`Idiomas`)
        11. Objetivo Profesional/Resumen (`Candidatos.resumen_profesional`)
        12. Logros o Proyectos Destacados (`Logros_Proyectos.descripcion`)
        13. Disponibilidad (`Candidatos.disponibilidad`)
        14. Redes Profesionales (`Candidatos.redes_profesionales`)
        15. Referencias: Nombre Contacto, Descripción (`Referencias`)
        16. Foto (opcional, `Candidatos.foto`)
        17. CV PDF (opcional, `Candidatos.cv_pdf`)
    
    Los campos son editables, con validación para formatos correctos.
    
- **Aplicaciones**:
    - Los candidatos pueden aplicar a ofertas publicadas, generando registros en la tabla `Aplicaciones`.

### 2. Empresas

- **Registro**:
    - Campos: Nombre de la Empresa, Correo, Contraseña, Dirección, RNC, Sector, Ciudad, Teléfono, Correo Corporativo, Sitio Web, Descripción.
    - Implementado en `registro.php` con validación y almacenamiento en `Usuarios` y `Empresas`.
- **Publicación de Ofertas**:
    - Empresas crean ofertas con Título, Descripción, Requisitos, y Fecha de Publicación (almacenadas en `Ofertas`).
    - Implementado en `panel_empresas/ofertas/crear_oferta.php`.
- **Revisión de Candidatos**:
    - Listado de aplicaciones por oferta, mostrando número de postulantes y acceso a perfiles/CVs de candidatos.
    - Implementado en `panel_empresas/ofertas/candidatos.php`, con consultas a `Aplicaciones` y `Candidatos`.
    - Muestra un listado de ofertas publicadas `panel_empresas/empresas_panel.php` y vista de ofertas individuales con candidatos que aplicaron en `panel_empresas/ofertas/ver_oferta.php`

## 🏗️ Requisitos Técnicos / Funciones Clave

1. **Tecnologías**:
    - **Backend**: PHP 7.4+ para lógica del servidor y manejo de sesiones.
    - **Base de Datos**: MySQL para almacenamiento relacional.
    - **Frontend**: HTML, CSS, JavaScript (diseño basado en plantilla en `Libreria/plantilla.php`).
2. **Diseño/Plantilla**:
    - Diseño atractivo y coherente con la temática de empleos, usando una plantilla en `plantilla.php`.
    - Responsive para dispositivos móviles, con navegación clara y colores representativos.
3. **Registro y Autenticación**:
    - **Login/Logout**: Implementado en `Login.php` con `session_start()` y `password_verify()`.
    - Control de sesiones para diferenciar candidatos y empresas, redirigiendo a paneles respectivos.
4. **Gestión de Ofertas**:
    - Empresas pueden crear, editar, y eliminar ofertas (solo las propias) vía panel de empresas.
    - Candidatos ven un listado de ofertas disponibles en `panel_candidatos/buscar-empleo.php`.
5. **Aplicaciones a Ofertas**:
    - Candidatos aplican a ofertas, registrando en `Aplicaciones`.
    - Empresas ven cuántos candidatos aplicaron por oferta y acceden a sus pdatos/CVs (campos digitales y PDF, si subido).
6. **Gestión de CV**:
    - Formulario en `curriculum.php` con **campos** (15 requeridos + foto/PDF opcionales).
    - Campos almacenados en tablas relacionadas con claves foráneas.
7. **Conexión a la base de datos y gestion de datos:**  
    - Clase `conexion` (**`Libreria/bd/conexion.php`)** para consultas MySQL (selección, inserción, actualización).
    - Configuración de conexión a MySQL (**`Libreria/bd/db_config.php`)**.
    - Inserciones en tablas relacionadas con integridad referencial (claves foráneas, CASCADE).
    - Consultas para listar ofertas, aplicaciones, y perfiles, etc.
8. **Validación**: 
    - `registro.php` verifica correos únicos, formatos de datos, y campos obligatorios.
    - Validación en formularios de CV y ofertas (e.g., fechas válidas, textos no vacíos).

## Instalación

1. **Configurar XAMPP**: Inicia Apache y MySQL en el panel de control de XAMPP.
2. **Clonar el Proyecto.**
3. **Configurar la Base de Datos (para rama “organizando”)**:
    - Abre phpMyAdmin (`http://localhost/phpmyadmin`).
    - Crea la base de datos `PlataformaEmpleos`.
    - Ejecuta el script SQL para crear las tablas (ver abajo).

### Script SQL de la Base de Datos (`Libreria/bd/instalador.php`)

```sql
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    tipo_usuario ENUM('candidato', 'empresa') NOT NULL
);
CREATE TABLE Candidatos (
    id_candidato INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    resumen_profesional TEXT,
    profesion VARCHAR(100),
    disponibilidad VARCHAR(50),
    redes_profesionales VARCHAR(255),
    foto LONGBLOB,
    cv_pdf LONGBLOB,
    UNIQUE KEY uk_id_usuario (id_usuario),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);
CREATE TABLE Empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    rnc VARCHAR(20),
    sector VARCHAR(100),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    telefono VARCHAR(20),
    correo_corporativo VARCHAR(100),
    sitio_web VARCHAR(100),
    descripcion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) 
);
CREATE TABLE Formaciones_Academicas (
    id_formacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    institucion VARCHAR(255),
    titulo VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);
CREATE TABLE Experiencias_Laborales (
    id_experiencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    empresa VARCHAR(255),
    puesto VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);
CREATE TABLE Habilidades (
    id_habilidad INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    habilidad VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);
CREATE TABLE Idiomas (
    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    idioma VARCHAR(100),
    nivel VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);
CREATE TABLE Logros_Proyectos (
    id_logro INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);
CREATE TABLE Referencias (
    id_referencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    nombre_contacto VARCHAR(255),
    descripcion_contacto TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);
CREATE TABLE Ofertas (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    titulo VARCHAR(255),
    descripcion TEXT,
    requisitos TEXT,
    fecha_publicacion DATE,
    FOREIGN KEY (id_empresa) REFERENCES Empresas(id_empresa) ON DELETE CASCADE
);
CREATE TABLE Aplicaciones (
    id_aplicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    id_oferta INT NOT NULL,
    fecha_aplicacion DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE,
    FOREIGN KEY (id_oferta) REFERENCES Ofertas(id_oferta) ON DELETE CASCADE
);

```

1. **Poblar la Base de Datos**:

```sql
-- Empresa: Innovatech1
INSERT INTO Usuarios (id_usuario, nombre, apellido, correo, contrasena, fecha, tipo_usuario) VALUES
(6, 'Innovatech1', '-', 'contacto1@innovatechrd.com', '$2y$10$z7X1l3Qz1eK5y8m9n0o2uO6p7r8t9u0v1w2x3y4z5a6b7c8d9e0f', '2025-04-17', 'empresa');
INSERT INTO Empresas (id_empresa, id_usuario, rnc, sector, direccion, ciudad, telefono, correo_corporativo, sitio_web, descripcion) VALUES
(7, 6, '123789456', 'Tecnología', 'Av. Anacaona #75', 'Santo Domingo', '809-555-5555', 'info@innovatech1.com', 'www.innovatech1.com', 'Innovatech1 es una empresa de desarrollo de software.');
-- Oferta: Software Developer
INSERT INTO Ofertas (id_oferta, id_empresa, titulo, descripcion, requisitos, fecha_publicacion) VALUES
(16, 7, 'Software Developer', 'Desarrollador de software para proyectos web.', '2+ años en Python, JavaScript, SQL.', '2025-04-24');
-- Candidato: Carlos Rodríguez
INSERT INTO Usuarios (id_usuario, nombre, apellido, correo, contrasena, fecha, tipo_usuario) VALUES
(3, 'Carlos', 'Rodríguez', 'carlos.rodriguez@yahoo.com', '$2y$10$z7X1l3Qz1eK5y8m9n0o2uO6p7r8t9u0v1w2x3y4z5a6b7c8d9e0f', '1995-03-10', 'candidato');
INSERT INTO Candidatos (id_candidato, id_usuario, telefono, direccion, ciudad, resumen_profesional, profesion, disponibilidad, redes_profesionales) VALUES
(3, 3, '849-555-9012', 'Calle 2 #15', 'Santiago', 'Ingeniero de software con experiencia en Python.', 'Ingeniero de Software', 'Tiempo completo', 'github.com/carlosrodriguez');
INSERT INTO Formaciones_Academicas (id_candidato, institucion, titulo, fecha_inicio, fecha_fin) VALUES
(3, 'INTEC', 'Ingeniería en Sistemas', '2012-09-01', '2016-12-15');
INSERT INTO Experiencias_Laborales (id_candidato, empresa, puesto, fecha_inicio, fecha_fin) VALUES
(3, 'DataCore', 'Ingeniero de Software', '2017-02-01', NULL);
INSERT INTO Habilidades (id_candidato, habilidad) VALUES
(3, 'Python'), (3, 'Django'), (3, 'PostgreSQL');
INSERT INTO Idiomas (id_candidato, idioma, nivel) VALUES
(3, 'Español', 'Nativo'), (3, 'Inglés', 'Avanzado');
INSERT INTO Logros_Proyectos (id_candidato, descripcion) VALUES
(3, 'Desarrollo de un sistema de gestión empresarial en Python.');
INSERT INTO Referencias (id_candidato, nombre_contacto, descripcion_contacto) VALUES
(3, 'Ana Gómez', 'Jefa de proyecto en DataCore, ana.gomez@datacore.com');
-- Aplicación
INSERT INTO Aplicaciones (id_candidato, id_oferta, fecha_aplicacion) VALUES
(3, 16, '2025-04-26');

```

## Aporte de Integrantes del Grupo

| Nombre             | Matrícula   | Módulo Principal                     | Aporte                                                                 |
|--------------------|-------------|--------------------------------------|----------------------------------------------------------------------|
| Jonathan Frias     | 2023-1117   | Autenticación & Registro            | - Login/Logout<br>- Registro candidatos/empresas<br>- Control de sesión<br>- Validación de formularios<br>- Panel de candidatos<br>- Conexión a base de datos |
| Netanel de Jesus   | 2023-1103   | CV Digital (Candidatos)             | - Formulario de CV (15 campos)<br>- Subida de PDF (CV) y foto<br>- Visualización del CV |
| Zelidee Güémez     | 2023-1706   | Gestión de Ofertas (Empresas)       | - Crear, editar, eliminar ofertas<br>- Ver ofertas<br>- Ver candidatos aplicantes por oferta<br>- Panel de empresas<br>- Conexión base de datos |
| Pamela Blanco      | 2023-1668   | Aplicación a Ofertas (Candidatos)   | - Listar ofertas disponibles<br>- Aplicar y ver historial de aplicaciones a ofertas<br>- Panel de candidatos |
| Naroly Tolentino   | 2023-1783   | Diseño General & Entregables        | - Maquetado<br>- CSS global responsive<br>- PDF de entrega<br>- Video final<br>- Integración visual<br>- Páginas generales |
