# PHP Business BA

[![Build Status](https://travis-ci.org/phpba/php-business-ba.svg?branch=gh-pages)](https://travis-ci.org/phpba/php-business-ba)

Esse é o repositório com a lista de empresas que usam PHP na Bahia.

O objetivo é que os nomes dessas empresas fiquem disponíveis para consumo via API.

Todas as empresas cadastradas precisam estar cientes que seus nomes/marcas estarão visiveís para outras pessoas e que não são informações criticas ou sigilosas.

Fique a vontade para adicionar outras empresas ou corrigir as que já existem.


## Empresas

O arquivo [/data/companies.json](https://github.com/phpba/php-business-ba/data/companies.json) lista todas as empresas.

```json
{
    "key": "exemplo",
    "name": "Nome da Empresa",
    "location": {
        "city": "Salvador",
        "state": "Bahia",
        "acronym": "BA"
    },
    "employees": "12",
    "website": "http://exemplo.com.br",
    "years_using_php": "5",
    "framework": ["Laravel"],
    "use_tests": ["Teste Unitário, Teste de Integração, Teste de Aceitação"],
    "other_technologies": ["NodeJS"]
}
```
