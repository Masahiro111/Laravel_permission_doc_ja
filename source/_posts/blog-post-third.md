---
extends: _layouts.blog
section: body
title: Laravel の CRUD を丸暗記して、感じたこと。
tags: 初学者向け
author: Masahiro111
slug: blog-3
---

基本的な Laravel の CRUD のコードをたくさん書いていて、知らず知らずのうちに丸暗記してしまいました...

今回は、CRUDのコードを丸暗記する「前」と「後」で、個人的に思ったことや感じたことを少しメモに残せたらなと思います。

# CRUD のコードを丸暗記して感じたこと

## 正解は、「１つ」じゃない

何度も、CRUD のコードを書いているうちに、自分が打っている CRUD のコードの他にも、同じような意味を持つコードが複数あることに気づき始めます。特に、YouTube で CRUD 系の動画を拝見していると、投稿者の「好み」によって、CRUD のコードの書き方に特色がでてきます。

**:open_mouth: 「この動画の投稿者は、こういう書き方が好きなんだ！」**

とか

**:sob: 「自分の書いていたコードより、めっちゃシンプルなコードやん...」**

とか、**丸暗記していたおかげで、自分のコードと、相手のコードを比較することが安易になります。** もちろん、丸暗記しなくてもコードの比較はできますが、暗記しているおかげで、コードの理解が深まったり、正解は1つじゃないんだ、と思うようになりました。

## 理解できなかったコードが、理解できるようになる不思議

最初は理解できないコードでも、何度も同じコードを書いていると、後々理解できるようになることが多いです。とても不思議なことなのですが、コードを書いているうちに、**「あっ！これって、こういうこと！？」**というような感じで理解できちゃう場面があります。

もちろん、今 Laravel の本体内部のコードを見ても、いまだに理解はできませんが、CRUD や、小さなアプリを作成するような教材等は、最初はワケの分からないコードだと思っていても、複数回、繰り返しコードを書いていると、「あっ、こういうことか！」と理解できる場面がきっとあります。

個人的なお勧めは、教材を学ぶ際、**最初の１回目は「さらっと感じだけ掴んで」、２、３回目で「しっかり理解する」**。という感覚で勉強したほうが良いのではないかと思います。

## 簡単なアプリが作りやすくなる

当たり前っちゃ当たり前の話なのですが、CRUD はアプリの基本的な機能ですので、仕組みを理解し覚えていれば、簡単なアプリを作成しやすくなります。アプリを拡張する際も、基本は CRUD を応用する感じがほとんどだと思うので、初学者ほど、CRUD を早めに理解するべきなのかなと思います。

:thinking: **「でも、暗記しなくてもコピペでもええやん？」**

↑ もちろん、その通りです！

コピペでも、暗記でも、コードが一緒なら結果も一緒です。ですが、コピペだと、**コードの内容を理解しないまま貼り付けるケースが多々あります。**個人的には、これがとても問題だと思っています...

自分の話ですが、コピペで貼り付けたコードの場合、あまりコードの内容を覚えていないことが多く、再度、同じ処理のコードを書こうとした際に、「ど、どんなコード書けば良いんだっけ…」と、なってしまいます。

コピペも良いとは思いますが、**最初のうちは、自分で手を動かしてコードを書きながら覚えていく** のが、よりベターなのかなと思っています。

## 少しだけ、「自信」がついた感じがする

「丸暗記できる、ワイってすごいやん？」という根拠のない自信がつきます。:sweat_smile:
