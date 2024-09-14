CREATE DATABASE cep_api_db;
USE cep_api_db;

-- Tabela para armazenar os detalhes da API e créditos
CREATE TABLE api_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    api_name VARCHAR(255) NOT NULL,
    credits INT NOT NULL,
    status ENUM('on', 'off') NOT NULL
);

-- Tabela para armazenar logs de consultas
CREATE TABLE api_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(10) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insira dados iniciais
INSERT INTO api_settings (api_name, credits, status) VALUES ('CEP API', 100, 'on');
