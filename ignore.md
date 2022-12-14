[***> Дополнительно***](./extra.md)

[***< Ветвление***](./branching.md)

[***<< Перейти к содержанию***](./readme.md#содержание)

# Настройка .gitignore

В большинстве проектов есть файлы или целые директории, в которые мы не хотим (и, скорее всего, не захотим) коммитить. Мы можем удостовериться, что они случайно не попадут в `git add -A` при помощи файла ***.gitignore***
1. Создайте вручную файл под названием ***.gitignore*** и сохраните его в директорию проекта.
2. Внутри файла перечислите названия файлов/папок, которые нужно игнорировать, каждый с новой строки.
3. Файл ***.gitignore*** должен быть добавлен, закоммичен и отправлен на сервер, как любой другой файл в проекте.

Вот хорошие примеры файлов, которые нужно игнорировать:
* кэши зависимостей, например содержимое `/node_modules` или `/packages`
* скомпилированный код, например файлы `.o`, `.pyc` и `.class`
* каталоги для выходных данных сборки, например `/bin`, `/out` или `/target`
* файлы, сгенерированные во время выполнения, например `.log`, `.lock` или `.tmp`
* скрытые системные файлы, например `.DS_Store` или `Thumbs.db`
* личные файлы конфигурации ***IDE***, например `.idea/workspace.xml`

---

##  Шаблоны игнорирования в Git

Для сопоставления с именами файлов в ***.gitignore*** используются шаблоны подстановки. С помощью различных символов можно создавать собственные шаблоны.

<table border="1">
	<tr>
		<td style="text-align: center;">Шаблон</td>
		<td style="text-align: center;">Примеры соответствия</td>
		<td style="text-align: center;">Пояснение*</td>
	</tr>
	<tr>
		<td><code>**/logs</td>
		<td><code>logs/debug.log</code><br /> <code>logs/monday/foo.bar</code><br /> <code>build/logs/debug.log</code></td>
		<td>Добавьте в начало шаблона две звездочки, чтобы сопоставлять каталоги влюбом месте репозитория.</code></td>
	</tr>
	<tr>
		<td><code>**/logs/debug.log</code></td>
		<td><code>logs/monday/foo.bar</code><br /> <code>logs/debug.log</code><br /> <code>build/logs/debug.log</code><br /> <em>но не</em><br /> <code>logs/build/debug.log</code></td>
		<td>Две звездочки можно также использовать для сопоставления файлов на основе их имени и имени родительского каталога.</td>
	</tr>
	<tr>
		<td><code>*.log</code></td>
		<td><code>debug.log</code><br /> <code>foo.log</code><br /> <code>.log</code><br /> <code>logs/debug.log</code></td>
		<td>Одна звездочка — это подстановочный знак, который может соответствовать как нескольким символам, так и ни одному.</td>
	</tr>
	<tr>
		<td><code>*.log</code><br /> <code>!important.log</code></td>
		<td><code>debug.log</code><br /> <code>trace.log</code><br /> <em>но не</em><br /> <code>important.log</code><br /> <code>logs/important.log</code></td>
		<td>Добавление восклицательного знака в начало шаблона отменяет действие шаблона. Если файл соответствует некоему шаблону, но при этом <em>также</em> соответствует отменяющему шаблону, указанному после, такой файл не будет игнорироваться.</td>
	</tr>
	<tr>
		<td><code>*.log<code /><br /> <code>!important/*.log</code><br /> <code>trace.*</code></td>
		<td><code>debug.log</code><br> <code>important/trace.log</code><br /> <em>но не</em><br /> <code>important/debug.log</code></td>
		<td>Шаблоны, указанные после отменяющего шаблона, снова будут помечать файлы как игнорируемые, даже если ранее игнорирование этих файлов было отменено.</td>
	</tr>
	<tr>
		<td><code>/debug.log</code></td>
		<td><code>debug.log</code><br /> <em>но не</em><br /> <code>logs/debug.log</code></td>
		<td>Косая черта перед именем файла соответствует файлу в корневом каталоге репозитория.</td>
	</tr>
	<tr>
		<td><code>debug.log</code></td>
		<td><code>debug.log</code><br /> <code>logs/debug.log</code></td>
		<td>По умолчанию шаблоны соответствуют файлам, находящимся в любом каталоге</td>
	</tr>
	<tr>
		<td><code>debug?.log</code></td>
		<td><code>debug0.log</code><br /> <code>debugg.log</code><br /> <em>но не</em><br /> <code>debug10.log</code></td>
		<td>Знак вопроса соответствует строго одному символу.</td>
	</tr>
	<tr>
		<td><code>debug[0-9].log</code></td>
		<td><code>debug0.log</code><br /> <code>debug1.log</code><br /> <em>но не</em><br /> <code>debug10.log</code></td>
		<td>Квадратные скобки можно также использовать для указания соответствия одному символу из заданного диапазона.</td>
	</tr>
	<tr>
		<td><code>debug[01].log</code></td>
		<td><code>debug0.log</code><br /> <code>debug1.log</code><br /> <em>но не</em><br /> <code>debug2.log</code><br /> <code>debug01.log</code></td>
		<td>Квадратные скобки соответствуют одному символу из указанного набора.</td>
	</tr>
	<tr>
		<td><code>debug[!01].log</code></td>
		<td><code>debug2.log</code><br /> <em>но не</em><br /> <code>debug0.log</code><br /> <code>debug1.log</code><br /> <code>debug01.log</code></td>
		<td>Восклицательный знак можно использовать для указания соответствия любому символу, кроме символов из указанного набора.</td>
	</tr>
	<tr>
		<td><code>debug[a-z].log</code></td>
		<td><code>debuga.log</code><br /> <code>debugb.log</code><br /> <em>но не</em><br /> <code>debug1.log</code></td>
		<td>Диапазоны могут быть цифровыми или буквенными.</td>
	</tr>
	<tr>
		<td><code>logs</code></td>
		<td><code>logs</code><br /> <code>logs/debug.log</code><br /> <code>logs/latest/foo.</code><br /> <code>build/logs</code><br /> <code>build/logs/debug.log</code></td>
		<td>Без косой черты в конце этот шаблон будет соответствовать и файлам, и содержимому каталогов с таким именем. В примере соответствия слева игнорируются и каталоги, и файлы с именем <em>logs</em></td>
	</tr>
	<tr>
		<td>logs/</td>
		<td><code>logs/debug.log</code><br> <code>logs/latest/foo.bar</code><br> <code>build/logs/foo.bar</code><br> <code>build/logs/latest/debug.log</code></td>
		<td>Косая черта в конце шаблона означает каталог. Все содержимое любого каталога репозитория, соответствующего этому имени (включая все его файлы и подкаталоги), будет игнорироваться</td>
	</tr>
	<tr>
		<td><code>logs/</code><br/> <code>!logs/important.log</code></td>
		<td><code>logs/debug.log</code><br> <code>logs/important.log</code></td>
		<td>Минуточку! Разве файл <code>logs/important.log</code> из примера слева не должен быть исключен нз списка игнорируемых?<br /><br />Нет! Из-за странностей Git, связанных с производительностью, вы не можете отменить игнорирование файла, которое задано шаблоном соответствия каталогу</td>
	</tr>
	<tr>
		<td><code>logs/**/debug.log</code></td>
		<td><code>logs/debug.log</code><br> <code>logs/monday/debug.log</code><br> <code>logs/monday/pm/debug.log</code></td>
		<td>Две звездочки соответствуют множеству каталогов или ни одному.</td>
	</tr>
	<tr>
		<td><code>logs/*day/debug.log</code></td>
		<td><code>logs/monday/debug.log</code><br> <code>logs/tuesday/debug.log</code><br /> <em>но не</em><br /> <code>logs/latest/debug.log</code></td>
		<td>Подстановочные символы можно использовать и в именах каталогов.</td>
	</tr>
	<tr>
		<td><code>logs/debug.log</code></td>
		<td><code>logs/debug.log</code><br /> <em>но не</em><br /> <code>debug.log</code><br> <code>build/logs/debug.log</code></td>
		<td>Шаблоны, указывающие на файл в определенном каталоге, задаются относительно корневого каталога репозитория. (При желании можно добавить в начало косую черту, но она ни на что особо не повлияет.)</td>
	</tr>
</table>

Две звездочки `**` означают, что ваш файл ***.gitignore*** находится в каталоге верхнего уровня вашего репозитория, как указано в соглашении. Если в репозитории несколько файлов .gitignore, просто мысленно поменяйте слова «корень репозитория» на «каталог, содержащий файл ***.gitignore***» (и подумайте об объединении этих файлов, чтобы упростить работу для своей команды)

Помимо указанных символов, можно использовать символ `#`, чтобы добавить в файл .gitignore комментарии:
```
# ignore all logs
*.log
```
Если у вас есть файлы или каталоги, в имени которых содержатся спецсимволы шаблонов, для экранирования этих спецсимволов в .gitignore можно использовать обратную косую черту `\`
```
# ignore the file literally named foo[01].txt
foo\[01\].txt
```
---

##  Общие файлы .gitignore в вашем репозитории 

Обычно правила игнорирования *Git* задаются в файле ***.gitignore*** в корневом каталоге репозитория. Тем не менее вы можете определить несколько файлов ***.gitignore*** в разных каталогах репозитория. Каждый шаблон из конкретного файла ***.gitignore*** проверяется относительно каталога, в котором содержится этот файл. Однако проще всего (и этот подход рекомендуется в качестве общего соглашения) определить один файл ***.gitignore*** в корневом каталоге. После регистрации файла ***.gitignore*** для него, как и для любого другого файла в репозитории, включается контроль версий, а после публикации с помощью команды push он становится доступен остальным участникам команды. В файл ***.gitignore***, как правило, включаются только те шаблоны, которые будут полезны другим пользователям репозитория.

---

##  Персональные правила игнорирования в Git

В специальном файле, который находится в папке `.git/info/exclude`, можно определить персональные шаблоны игнорирования для конкретного репозитория. Этот файл не имеет контроля версий и не распространяется вместе с репозиторием, поэтому он хорошо подходит для указания шаблонов, которые будут полезны только вам. Например, если у вас есть пользовательские настройки для ведения журналов или специальные инструменты разработки, которые создают файлы в рабочем каталоге вашего репозитория, вы можете добавить их в `.git/info/exclude`, чтобы они случайно не попали в коммит в вашем репозитории.

---

 ## Глобальные правила игнорирования в Git

 Кроме того, для всех репозиториев в локальной системе можно определить глобальные шаблоны игнорирования *Git*, настроив параметр конфигурации *Git* `core.excludesFile`
 
 Этот файл нужно создать самостоятельно. Если вы не знаете, куда поместить глобальный файл ***.gitignore***, расположите его в домашнем каталоге (потом его будет легче найти). После создания этого файла необходимо настроить его местоположение с помощью команды `git config:`

 ```
touch ~/.gitignore
git config --global core.excludesFile ~/.gitignore
 ```
 Будьте внимательны при указании глобальных шаблонов игнорирования, поскольку для разных проектов актуальны различные типы файлов. Типичные кандидаты на глобальное игнорирование — это специальные файлы операционной системы (например, `.DS_Store` и `thumbs.db`) или временные файлы, создаваемые некоторыми инструментами разработки.

---

  ## Игнорирование ранее закоммиченного файла

Чтобы игнорировать файл, для которого ранее был сделан коммит, необходимо удалить этот файл из репозитория, а затем добавить для него правило в .gitignore . Используйте команду git rm с параметром --cached, чтобы удалить этот файл из репозитория, но оставить его в рабочем каталоге как игнорируемый файл.
  
```
echo debug.log >> .gitignore

git rm --cached debug.log
rm 'debug.log'

git commit -m "Start ignoring debug.log"
```
Опустите опцию `--cached`, чтобы удалить файл как из репозитория, так и из локальной файловой системы.

---

## Коммит игнорируемого файла 
Можно принудительно сделать коммит игнорируемого файла в репозиторий с помощью команды `git add` с параметром `-f` (или `--force`):
```
cat .gitignore
*.log
git add -f debug.log
git commit -m "Force adding debug.log"
```

Этот способ хорош, если у вас задан общий шаблон (например, `*.log`), но вы хотите сделать коммит определенного файла. Однако еще лучше в этом случае задать исключение из общего правила:

```
echo !debug.log >> .gitignore
  
cat .gitignore
*.log
!debug.log
  
git add debug.log
  
git commit -m "Adding debug.log"
```

Этот подход более прозрачен и понятен, если вы работаете в команде.

---
[***> Дополнительно***](./extra.md)

[***< Ветвление***](./branching.md)

[***<< Перейти к содержанию***](./readme.md#содержание)