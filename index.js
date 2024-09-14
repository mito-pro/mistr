const express = require('express');
const axios = require('axios');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 4018;

// Middleware para tratar requisições JSON
app.use(express.json());

// Middleware CORS
app.use(cors());

// Informações sobre o criador da API
const criadorDaApi = 'Místico';

// Rota de documentação
app.get('/', (req, res) => {
  res.send(`Documentação da API criada por ${criadorDaApi}`);
});

// Rota para consulta de CEP
app.get('/consulta_cep/:cep', async (req, res) => {
  // Código para consulta de CEP
});

// Rota para consulta de CNPJ
app.get('/consulta_cnpj/:cnpj', async (req, res) => {
  // Código para consulta de CNPJ
});

// Rota para consulta de IP
app.get('/consulta_ip/:ip', async (req, res) => {
  try {
    const ipAddress = req.params.ip;
    const apiKey = 'a3b0b9d32c234908a0aaebfdd0185538';
    const apiUrl = `https://api.ipgeolocation.io/ipgeo?apiKey=${apiKey}&ip=${ipAddress}&fields=*`;
    const response = await axios.get(apiUrl);
    const data = response.data;

    // Formatando os dados
    const formattedData = {
      ip: data.ip,
      hostname: data.hostname,
      continent_code: data.continent_code,
      continent_name: data.continent_name,
      country_code2: data.country_code2,
      country_code3: data.country_code3,
      country_name: data.country_name,
      country_capital: data.country_capital,
      state_prov: data.state_prov,
      district: data.district,
      city: data.city,
      zipcode: data.zipcode,
      latitude: data.latitude,
      longitude: data.longitude,
      is_eu: data.is_eu,
      calling_code: data.calling_code,
      country_tld: data.country_tld,
      languages: data.languages,
      country_flag: data.country_flag,
      isp: data.isp,
      connection_type: data.connection_type,
      organization: data.organization,
      asn: data.asn,
      geoname_id: data.geoname_id,
      currency: data.currency,
      time_zone: data.time_zone,
      security: data.security,
      user_agent: data.user_agent
    };

    res.json(formattedData);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Erro interno do servidor' });
  }
});

// Rota para gerar link compartilhável
app.post('/gerar_link', (req, res) => {
  // Lógica para gerar link com base nos dados recebidos em req.body
  const linkGerado = 'https://seusite.com/link/123'; // Substitua pelo código real de geração de link
  res.json({ link: linkGerado });
});

// Tratamento de rota não encontrada
app.use((req, res) => {
  res.status(404).json({ error: 'Rota não encontrada' });
});

// Tratamento de erro genérico
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Erro interno do servidor' });
});

app.listen(PORT, () => {
  console.log('Aplicativo aberto na porta: ' + PORT);
});
