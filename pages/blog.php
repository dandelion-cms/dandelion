<!-- teste -->

= Dandelion Markdown =

Lorem ipsum dolor sit amet, `consectetur` adipisicing elit, sed doeiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enimad minim veniam, quis nostrud exercitation ullamco laboris nisi utaliquip ex ea commodo consequat. Duis aute irure dolor inreprehenderit in voluptate velit esse cillum dolore eu fugiat nullapariatur.

== 1. Títulos ==

De um a seis sinais de "=" envolvendo os títulos. Os títulos devem estar sempre sozinhos em suas linhas.

'''
 = Título 1 =
 == Título 2 ==
 === Título 3 ===
 ==== Título 4 ====
 ===== Título 5 =====
 ====== Título 6 ======
'''

Resultando em:

= Título 1 =
== Título 2 ==
=== Título 3 ===
==== Título 4 ====
===== Título 5 =====
====== Título 6 ======

== 2. Parágrafos e Quebras de linha ==

Para definir um parágrafo, basta deixar uma linha em branco abaixo do texto. Linhas seguidas de texto serão consideradas um parágrafo com várias quebras entre si.

'''
 Isso aqui é um pequeno parágrafo de texto. Abaixo dele haverá uma linha em
 branco para definí-lo.

 Isso é uma linha seguida de uma quebra.
 Outra linha quebrada do mesmo parágrafo.
 Mais uma linha para deixar bem clara a ideia.
'''

&nbsp;

Resultando em:

Isso aqui é um pequeno parágrafo de texto. Abaixo dele haverá uma linha em branco para definí-lo.

Isso é uma linha seguida de uma quebra.
Outra linha quebrada do mesmo parágrafo.
Mais uma linha para deixar bem clara a ideia.

== 3. Estilos de Texto ==

Basta fazer como no exemplo:

'''
 \*Texto em negrito\*

 \_Texto em itálico\_

 \~Texto sublinhado\~

 \^Texto pequeno\^

 \---Texto riscado\---

 \`Código\`

 \*\_Texto em negrito e itálico\_\*
'''

*Texto em negrito*

_Texto em itálico_

~Texto sublinhado~

^Texto pequeno^

---Texto riscado---

`Código`

*_Texto em negrito e itálico_*

== 4. Blocos de citação e preformatados ==

Blocos preformatados e de `citação` devem ter pelo menos um espaço antes de cada linha, ou a formatação irá falhar.

'''
 \'''
  Este é um bloco
     preformatado
         de texto.

  Nem é preciso mostrar novamente o resultado. :)
 \'''

 \>>>
  Este é um bloco de citação.
 \>>>
'''

A citação fica assim:

>>>
 Este é um bloco de citação.
>>>

== 5. Escapando caracteres de formatação ==

Para evitar a formatação indesejada, basta acrescentar uma barra invertida (\) antes do caracter conflitante que se deseja utilizar no texto.

'''
 Exemplos:
 =========

 \\* resulta em \*
 \\_ resulta em \_
 \\` resulta em \`
 \\~ resulta em \~
 \\= resulta em \=
 \\>>> resulta em \>>>
 \\--- resulta em \---
 \\''' resulta em \'''
'''

== 6. Links ==

Podemos criar links de quatro formas diferentes:

'''
 Exemplo 1: \[[http://exemplo.com|Rótulo do link::Título do link]]
'''

Resulta em: [[http://exemplo.com|Rótulo do link::Título do link]] (Aponte no link para ver o título...)

'''
 Exemplo 2: \[[http://exemplo.com|Rótulo do link]]
'''

Resulta em: [[http://exemplo.com|Rótulo do link]] (Com rótulo, mas *sem* título...)

'''
 Exemplo 3: \[[http://exemplo.com::Título do link]]
'''

Resulta em: [[http://exemplo.com::Título do link]] (Sem rótulo, mas com título...)

'''
 Exemplo 4: \[[http://exemplo.com]]
'''

Resulta em: [[http://exemplo.com]] (Sem rótulo nem título...)

>>>
 *Observação:* Ao ser deixado sozinho numa linha, os links serão crados automaticamente dentro de um parágrafo.
>>>

'''
 Exemplo:

 \[[http://exemplo.com|Rótulo::Título]]

 No código HTML ficaria assim:

 &lt;p class="a-block"&gt;&lt;a href="http://exemplo.com" title="Título"&gt;Rótulo&lt;/a&gt;&lt;/p&gt;
'''

A classe `a-block` é criada automaticamente para facilitar a criação de estilos.

== 7. Imagens ==

Também há várias formas de inserir uma imagem no texto.

'''
 Exemplo 1: \{{images/exemplo.png}}
'''

Resulta em: {{images/exemplo.png}}

'''
 Exemplo 2: \{{images/exemplo.png::Título da imagem}}
'''

Resulta em: {{images/exemplo.png::Título da imagem}} (passe o mouse para ver o título...)

'''
 Exemplo 3: \{{http://exemplo.com|images/exemplo.png::Título da imagem}}
'''

Resulta em: {{http://exemplo.com|images/exemplo.png::Título da imagem}} (Agora temos um link com título...)

'''
 Exemplo 4: \{{http://exemplo.com|images/exemplo.png}}
'''

Resulta em: {{http://exemplo.com|images/exemplo.png}} (Agora temos um link sem título...)

>>>
 Assim como nos links, uma imagem isolada numa linha será envolvida automaticamente por um bloco "div", como no exemplo...
>>>

'''
 \{{images/exemplo.png}}

 Resultará em:

 &lt;div class="picture-block"&gt;&lt;img src="images/exemplo.png" /&gt;&lt;/div&gt;
'''

A classe `picture-block` é criada automaticamente para facilitar a criação de estilos.

== 8. Listas ==

Por enquanto, podemos fazer apenas um nível de listas, mas o processo é muito simples. Basta deixar um espaço em branco no começo da linha seguido de "\*", para listas não ordenadas, ou "+", para as ordenadas.

'''
 Lista não-ordenada:

 \* Item 1
 \* Item 2
 \* Item 3
 \* Item 4

'''

Resulta em:

 * Item 1
 * Item 2
 * Item 3
 * Item 4

'''
 Lista ordenada:

 \+ Item 1
 \+ Item 2
 \+ Item 3
 \+ Item 4

'''

Resulta em:

 + Item 1
 + Item 2
 + Item 3
 + Item 4

^_Última atualização: [php]last-update[/php]_^
