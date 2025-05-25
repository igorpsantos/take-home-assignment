# EBANX Take-Home Assignment 💼

Este repositório contém minha solução para o desafio técnico da EBANX para a vaga de Senior Software Engineer.

## 🧠 Sobre o projeto

A proposta do desafio era implementar uma API com dois endpoints: `GET /balance` e `POST /event`, sem persistência de dados, utilizando a linguagem de minha preferência.  

Escolhi utilizar **PHP puro** como linguagem principal por três motivos:

1. **Background técnico**: tenho sólida experiência com PHP e me sinto confortável desenvolvendo com a linguagem.
2. **Controle total da arquitetura**: evitar frameworks me permitiu construir *from scratch* estruturas essenciais como roteamento, ciclo de vida da aplicação e manipulação de requests.
3. **Performance e leveza**: uma API construída com PHP puro neste cenário consome menos memória e processa mais rapidamente, sendo ideal para um desafio simples e focado em regras de negócio.

---

## 📁 Estrutura do projeto

Organizei o projeto pensando em separação de responsabilidades, princípios do SOLID, Clean Code e facilidade de manutenção. Abaixo, alguns destaques:

App/
├── Http/
│ ├── Controllers/ # Camada de entrada HTTP (Controllers)
│ └── Requests/ # Normalização e validação de dados recebidos
├── Models/ # Representações das entidades (ex: Account)
├── Services/ # Camada de regras de negócio (ex: AccountService)
├── Repositories/ # Abstração para acesso a dados
helpers/
└── helper.php # Funções utilitárias globais
routes/
└── api.php # Definição das rotas (tipo Router)
storage/
└── account-state.json # Arquivo usado para simular persistência (ver nota abaixo)

index.php # Entry point da aplicação e ciclo de vida da requisição


Além disso:
- Criei uma estrutura de **roteamento minimalista** baseada no método e URI.
- Apliquei o padrão Singleton para simular armazenamento em memória.
- Incluí **comentários estratégicos** no código explicando decisões técnicas e sugestões de melhorias futuras.

---

## ⚠️ Observação importante

O PHP executa cada requisição como um **novo processo**, o que significa que qualquer dado salvo em memória (ex: arrays estáticos, Singletons) **é perdido ao final da execução**.

Como o desafio informava que não era necessário o uso de persistência em banco de dados e sessões, optei por simular um armazenamento temporário utilizando um **arquivo `.json` local**. Embora tecnicamente seja uma forma leve de persistência, foi a **única alternativa viável** dentro das limitações da linguagem para manter o estado entre requisições. Essa decisão será explicada com mais detalhes na entrevista.

---

## 🌐 Testes com NGROK

Utilizei o [Ngrok](https://ngrok.com/) para expor minha aplicação local à internet e rodar a suíte de testes automática disponibilizada pela EBANX.

---

## 🗂️ Versionamento

O projeto foi versionado desde o início com **commits passo a passo**, facilitando a análise da evolução e das decisões técnicas tomadas ao longo do desenvolvimento.

---

## ✅ Conclusão

A solução foi pensada para ser **simples, direta e funcional**, sem abrir mão das boas práticas de engenharia de software. Mesmo sem frameworks, o código está limpo, desacoplado e preparado para mudanças futuras com facilidade.

---