# Registro das melhorias — Loraflix

## 1. Adaptação para celular e tablet

Em `css/style.css`, a navegação passa a reorganizar seus itens em telas de até
720 px. O banner, os cards, a busca e os formulários também recebem dimensões e
espaçamentos adequados para telas menores, reduzindo cortes e rolagem horizontal.

## 2. Acessibilidade visual e por teclado

Links e controles passam a ter um indicador de foco visível para navegação por
teclado. O texto dos links da navegação fica mais legível ao passar o mouse ou
receber foco, o placeholder da busca ganha mais contraste e animações são
reduzidas quando o sistema operacional solicita preferência por movimento
reduzido.

## Validação

- `php -l` executado em todos os arquivos PHP do projeto: sem erros de sintaxe.
- `git diff --check`: sem erros de whitespace.
- No navegador, o layout se ajustou a um viewport estreito (312 px efetivos),
  sem rolagem horizontal; navegação em linhas, grade em uma coluna e foco de
  teclado visível foram confirmados.
