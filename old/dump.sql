-- SQL para la base de datos:

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL,
  clave VARCHAR(100) NOT NULL
);

CREATE TABLE socios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  email VARCHAR(100),
  telefono VARCHAR(20),
  estado ENUM('activo', 'inactivo', 'moroso') DEFAULT 'activo'
);

CREATE TABLE pagos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  socio_id INT,
  fecha_pago DATE,
  monto DECIMAL(10, 2),
  metodo_pago VARCHAR(50),
  observaciones TEXT,
  FOREIGN KEY (socio_id) REFERENCES socios(id)
);